<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\UserNotification;
use App\Services\SlotService;
use Illuminate\Http\Request;
class PatientAppointmentController extends Controller
{
    // /my/appointments : les rendez-vous du patient connecté
    public function index(Request $request)
    {
        $patient = $request->user()->patient;
        $appointments = $patient->appointments()
            ->with(['doctor.user', 'doctor.specialty'])
            ->orderByDesc('date')
            ->orderByDesc('time')
            ->get();
        $upcoming = $appointments->filter(fn ($a) => $a->date->gte(today())
            && in_array($a->status, [Appointment::PENDING, Appointment::CONFIRMED]))->sortBy('date');
        $history = $appointments->diff($upcoming);
        return view('patients.appointments.index', compact('patient', 'upcoming', 'history'));
    }
    // /my/appointments/{appointment}/edit?date=... : reporter
    public function edit(Request $request, Appointment $appointment, SlotService $slotService)
    {
        $this->authorizeOwner($appointment);
        $date = $request->query('date', $appointment->date->toDateString());
        $slots = $slotService->slots($appointment->doctor, $date, $appointment->id);
        return view('patients.appointments.edit', compact('appointment', 'date', 'slots'));
    }
    public function update(Request $request, Appointment $appointment, SlotService $slotService)
    {
        $this->authorizeOwner($appointment);
        $data = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        if (! $slotService->isFree($appointment->doctor, $data['date'], $data['time'], $appointment->id)) {
            return back()->withErrors(['time' => 'Ce créneau n’est pas disponible.'])->withInput();
        }
        $appointment->update($data + ['status' => Appointment::PENDING]);
        UserNotification::send($appointment->doctor->user_id,
            'Un rendez-vous a été reporté au ' . $appointment->date->format('d/m/Y') . ' à ' . $data['time'] .
                '.');
        return to_route('my.appointment.index')->with('success', 'Rendez-vous reporté.');
    }
    public function cancel(Appointment $appointment)
    {
        $this->authorizeOwner($appointment);
        $appointment->update(['status' => Appointment::CANCELLED]);
        UserNotification::send($appointment->doctor->user_id,
            'Le rendez-vous du ' . $appointment->date->format('d/m/Y') . ' a été annulé par le patient.');
        return to_route('my.appointment.index')->with('success', 'Rendez-vous annulé.');
    }
    // Sécurité : un patient ne touche qu'à SES rendez-vous, et seulement s'ils sont encore à venir
    private function authorizeOwner(Appointment $appointment): void
    {
        abort_unless($appointment->patient()->is(auth()->user()->patient), 403);
        abort_unless(in_array($appointment->status, [Appointment::PENDING, Appointment::CONFIRMED]), 403,
            'Ce rendez-vous ne peut plus être modifié.');
    }
}