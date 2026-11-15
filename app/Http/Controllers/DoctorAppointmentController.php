<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\UserNotification;
use Illuminate\Http\Request;
class DoctorAppointmentController extends Controller
{
    // /doctors/{doctor}/appointments
    public function index(Doctor $doctor)
    {
        $base = $doctor->appointments()->with('patient.user');
        $pending = (clone $base)->where('status', Appointment::PENDING)
            ->whereDate('date', '>=', today())->orderBy('date')->orderBy('time')->get();
        $today = (clone $base)->whereDate('date', today())
            ->where('status', Appointment::CONFIRMED)->orderBy('time')->get();
        $week = (clone $base)->whereBetween('date', [today()->addDay(), today()->addDays(7)])
            ->where('status', Appointment::CONFIRMED)->orderBy('date')->orderBy('time')->get();
        return view('doctors.appointments.index', compact('doctor', 'pending', 'today', 'week'));
    }
    // Confirmer ou refuser : PATCH /appointments/{appointment}/status
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);
        $appointment->update($data);
        $message = $data['status'] === Appointment::CONFIRMED
            ? 'Votre rendez-vous du ' . $appointment->date->format('d/m/Y') . ' à ' . $appointment->hour() . '
                est confirmé.'
            : 'Votre rendez-vous du ' . $appointment->date->format('d/m/Y') . ' a été refusé par le médecin.';
        // Prévenir le patient
        UserNotification::send($appointment->patient->user_id, $message);
        return back()->with('success', 'Rendez-vous ' . ($data['status'] === Appointment::CONFIRMED ?
            'confirmé.' : 'refusé.'));
    }
}