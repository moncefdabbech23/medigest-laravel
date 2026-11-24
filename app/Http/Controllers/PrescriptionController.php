<?php
namespace App\Http\Controllers;
use App\Models\Prescription;
use Illuminate\Http\Request;
class PrescriptionController extends Controller
{
    // /prescriptions/{prescription} : visible par le patient concerné, son médecin et l'admin
    public function show(Request $request, Prescription $prescription)
    {
        $prescription->load([
            'medications',
            'consultation.appointment.patient.user',
            'consultation.appointment.doctor.user',
            'consultation.appointment.doctor.specialty',
        ]);
        $appointment = $prescription->consultation->appointment;
        $user = $request->user();
        $allowed = $user->role === 'admin'
            || $appointment->patient()->is($user->patient)
            || $appointment->doctor()->is($user->doctor);
        abort_unless($allowed, 403);
        return view('prescriptions.show', compact('prescription'));
    }
}
