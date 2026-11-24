<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\UserNotification;
use App\Services\SlotService;
use Illuminate\Http\Request;
class AppointmentController extends Controller
{
    // Page de réservation : /doctors/{doctor}/book?date=2026-11-20 (patient connecté)
    public function create(Request $request, Doctor $doctor, SlotService $slotService)
    {
        abort_unless($doctor->is_validated, 404);
        $date = $request->query('date', now()->toDateString());
        $slots = $slotService->slots($doctor, $date);
        return view('appointments.create', compact('doctor', 'date', 'slots'));
    }
    public function store(Request $request, Doctor $doctor, SlotService $slotService)
    {
        abort_unless($doctor->is_validated, 404);
        $data = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'reason' => 'nullable|max:255',
        ]);
        if (! $slotService->isFree($doctor, $data['date'], $data['time'])) {
            return back()
                ->withErrors(['time' => 'Ce créneau n’est plus disponible. Choisissez une autre heure.'])
                ->withInput();
        }
        // Le patient est maintenant l'utilisateur connecté (plus de liste déroulante)
        $patient = $request->user()->patient;
        $appointment = $doctor->appointments()->create($data + [
            'patient_id' => $patient->id,
            'status' => Appointment::PENDING,
        ]);
        UserNotification::send(
            $doctor->user_id,
            'Nouvelle demande de ' . $request->user()->name . ' le ' . $appointment->date->format('d/m/Y') . '
                à ' . $data['time'] . '.'
        );
        return to_route('my.appointment.index')->with('success', 'Demande envoyée. Le médecin doit la
            confirmer.');
    }
}