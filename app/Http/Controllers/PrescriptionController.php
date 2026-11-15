<?php
namespace App\Http\Controllers;
use App\Models\Prescription;
class PrescriptionController extends Controller
{
    // /prescriptions/{prescription}
    public function show(Prescription $prescription)
    {
        $prescription->load([
            'medications',
            'consultation.appointment.patient.user',
            'consultation.appointment.doctor.user',
            'consultation.appointment.doctor.specialty',
        ]);
        return view('prescriptions.show', compact('prescription'));
    }
}