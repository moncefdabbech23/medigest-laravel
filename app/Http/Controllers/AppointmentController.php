<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\UserNotification;
use App\Services\SlotService;
use Illuminate\Http\Request;
class AppointmentController extends Controller
{
    // Page de réservation : /doctors/{doctor}/book?date=2026-11-20
    public function create(Request $request, Doctor $doctor, SlotService $slotService)
    {
        $date = $request->query('date', now()->toDateString());
        $slots = $slotService->slots($doctor, $date);
        // Temporaire (avant la partie 3) : on choisit le patient dans une liste
        $patients = Patient::with('user')->get();
        return view('appointments.create', compact('doctor', 'date', 'slots', 'patients'));
    }
    public function store(Request $request, Doctor $doctor, SlotService $slotService)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'reason' => 'nullable|max:255',
        ]);
        if (! $slotService->isFree($doctor, $data['date'], $data['time'])) {
            return back()
                ->withErrors(['time' => 'Ce créneau n’est plus disponible. Choisissez une autre heure.'])
                ->withInput();
        }
        $appointment = $doctor->appointments()->create($data + ['status' => Appointment::PENDING]);
        // Prévenir le médecin
        UserNotification::send(
            $doctor->user_id,
            'Nouvelle demande de rendez-vous le ' . $appointment->date->format('d/m/Y') . ' à ' . $data['time']
                . '.'
        );
        return to_route('appointment.create', [$doctor, 'date' => $data['date']])
            ->with('success', 'Demande envoyée. Le médecin doit la confirmer.');
    }
}
