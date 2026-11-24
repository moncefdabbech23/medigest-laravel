<?php
namespace App\Console\Commands;
use App\Models\Appointment;
use App\Models\UserNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
class SendAppointmentReminders extends Command
{
    // Le nom de la commande : php artisan rdv:reminder   (option : --date=2026-11-20)
    protected $signature = 'rdv:reminder {--date= : Date des rendez-vous à rappeler (par défaut : demain)}';
    protected $description = 'Envoie une notification de rappel aux patients qui ont un rendez-vous confirmé';
    public function handle(): int
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : today()->addDay();
        $appointments = Appointment::with(['patient', 'doctor.user'])
            ->whereDate('date', $date)
            ->where('status', Appointment::CONFIRMED)
            ->orderBy('time')
            ->get();
        $sent = 0;
        foreach ($appointments as $appointment) {
            $message = 'Rappel : rendez-vous le ' . $appointment->date->format('d/m/Y') . ' à ' .
                $appointment->hour()
                . ' avec ' . $appointment->doctor->user->name . '.';
            // Ne pas envoyer deux fois le même rappel si la commande est relancée
            $alreadySent = UserNotification::where('user_id', $appointment->patient->user_id)
                ->where('message', $message)
                ->exists();
            if ($alreadySent) {
                continue;
            }
            UserNotification::send($appointment->patient->user_id, $message);
            $this->line('✓ ' . $message);
            $sent++;
        }
        $this->info($sent . ' rappel(s) envoyé(s) pour le ' . $date->format('d/m/Y') . '.');
        return self::SUCCESS;
    }
}