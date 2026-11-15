<?php
namespace App\Services;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Carbon;
// Calcule les créneaux d'un médecin pour un jour donné, à partir de ses disponibilités
class SlotService
{
    /**
     * @return array<int, array{time: string, free: bool}>
     */
    public function slots(Doctor $doctor, string $date, ?int $ignoreAppointmentId = null): array
    {
        $day = Carbon::parse($date);
        // Disponibilité du jour (1 = lundi ... 7 = dimanche), table de la personne A
        $availability = $doctor->availabilities()
            ->where('weekday', $day->dayOfWeekIso)
            ->where('is_active', true)
            ->first();
        if (! $availability) {
            return [];   // le médecin ne travaille pas ce jour-là
        }
        // Heures déjà prises (hors rendez-vous annulés)
        $taken = $doctor->appointments()
            ->whereDate('date', $day->toDateString())
            ->where('status', '!=', Appointment::CANCELLED)
            ->when($ignoreAppointmentId, fn ($q) => $q->where('id', '!=', $ignoreAppointmentId))
            ->pluck('time')
            ->map(fn ($t) => substr($t, 0, 5))
            ->all();
        $start = Carbon::parse($day->toDateString() . ' ' . $availability->start_time);
        $end = Carbon::parse($day->toDateString() . ' ' . $availability->end_time);
        $step = (int) $availability->slot_duration;
        $slots = [];
        for ($t = $start->copy(); $t->copy()->addMinutes($step)->lte($end); $t->addMinutes($step)) {
            $hour = $t->format('H:i');
            $slots[] = [
                'time' => $hour,
                'free' => ! in_array($hour, $taken) && $t->isFuture(),
            ];
      }
        return $slots;
    }
    public function isFree(Doctor $doctor, string $date, string $time, ?int $ignoreAppointmentId = null): bool
    {
        foreach ($this->slots($doctor, $date, $ignoreAppointmentId) as $slot) {
            if ($slot['time'] === $time) {
                return $slot['free'];
            }
        }
        return false;   // heure hors des horaires du médecin
    }
}