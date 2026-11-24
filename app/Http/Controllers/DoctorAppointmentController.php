<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\UserNotification;
use Illuminate\Http\Request;
class DoctorAppointmentController extends Controller
{
    // /doctor/appointments : les rendez-vous du médecin connecté
    public function index(Request $request)
    {
        $doctor = $request->user()->doctor;
        $base = $doctor->appointments()->with('patient.user');
        $pending = (clone $base)->where('status', Appointment::PENDING)
            ->whereDate('date', '>=', today())->orderBy('date')->orderBy('time')->get();
        $today = (clone $base)->whereDate('date', today())
            ->where('status', Appointment::CONFIRMED)->orderBy('time')->get();
        $week = (clone $base)->whereBetween('date', [today()->addDay(), today()->addDays(7)])
            ->where('status', Appointment::CONFIRMED)->orderBy('date')->orderBy('time')->get();
        return view('doctors.appointments.index', compact('doctor', 'pending', 'today', 'week'));
    }
    // PATCH /doctor/appointments/{appointment}/status
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $this->authorizeDoctor($appointment);
        $data = $request->validate(['status' => 'required|in:confirmed,cancelled']);
        $appointment->update($data);
        $message = $data['status'] === Appointment::CONFIRMED
            ? 'Votre rendez-vous du ' . $appointment->date->format('d/m/Y') . ' à ' . $appointment->hour() . '
                est confirmé.'
            : 'Votre rendez-vous du ' . $appointment->date->format('d/m/Y') . ' a été refusé par le médecin.';
        UserNotification::send($appointment->patient->user_id, $message);
        return back()->with('success', $data['status'] === Appointment::CONFIRMED ? 'Rendez-vous confirmé.' :
            'Rendez-vous refusé.');
    }
    // Sécurité : un médecin ne touche qu'à SES rendez-vous
    private function authorizeDoctor(Appointment $appointment): void
    {
        abort_unless($appointment->doctor()->is(auth()->user()->doctor), 403);
    }
}
