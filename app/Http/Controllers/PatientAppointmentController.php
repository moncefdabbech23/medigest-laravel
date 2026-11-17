<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\UserNotification;
use App\Services\SlotService;
use Illuminate\Http\Request;
class PatientAppointmentController extends Controller
{
    // /patients/{patient}/appointments
    public function index(Patient $patient)
    {
        $appointments = $patient->appointments()
            ->with(['doctor.user', 'doctor.specialty'])
            ->orderByDesc('date')
            ->orderByDesc('time')
            ->get();
        // Séparer les rendez-vous à venir et l'historique
        $upcoming = $appointments->filter(fn ($a) => $a->date->gte(today())
            && in_array($a->status, [Appointment::PENDING, Appointment::CONFIRMED]))->sortBy('date');
        $history = $appointments->diff($upcoming);
        return view('patients.appointments.index', compact('patient', 'upcoming', 'history'));
    }
    // Formulaire pour reporter : /appointments/{appointment}/edit?date=...
    public function edit(Request $request, Appointment $appointment, SlotService $slotService)
    {
        $date = $request->query('date', $appointment->date->toDateString());
        $slots = $slotService->slots($appointment->doctor, $date, $appointment->id);
        return view('patients.appointments.edit', compact('appointment', 'date', 'slots'));
    }
    // Enregistrer le report (mêmes contrôles que la réservation)
    public function update(Request $request, Appointment $appointment, SlotService $slotService)
    {
        $data = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);
        if (! $slotService->isFree($appointment->doctor, $data['date'], $data['time'], $appointment->id)) {
            return back()->withErrors(['time' => 'Ce créneau n’est pas disponible.'])->withInput();

        }
        // Un rendez-vous reporté doit être confirmé à nouveau par le médecin
        $appointment->update($data + ['status' => Appointment::PENDING]);
        UserNotification::send($appointment->doctor->user_id,
            'Un rendez-vous a été reporté au ' . $appointment->date->format('d/m/Y') . ' à ' . $data['time'] .
                '.');
        return to_route('patient.appointment.index', $appointment->patient_id)
            ->with('success', 'Rendez-vous reporté.');
    }
    // Annuler : PATCH /appointments/{appointment}/cancel
    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => Appointment::CANCELLED]);
        UserNotification::send($appointment->doctor->user_id,
            'Le rendez-vous du ' . $appointment->date->format('d/m/Y') . ' a été annulé par le patient.');
        return back()->with('success', 'Rendez-vous annulé.');
    }
}