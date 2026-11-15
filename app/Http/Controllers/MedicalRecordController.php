<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Patient;
class MedicalRecordController extends Controller
{
    // /patients/{patient}/record
    public function show(Patient $patient)
    {
        // with() charge tout en quelques requêtes (pas de problème N + 1)
        $patient->load('user');
        $consultations = $patient->appointments()
            ->where('status', Appointment::DONE)
            ->whereHas('consultation')
            ->with([
                'doctor.user',
                'doctor.specialty',
                'consultation.prescription.medications',
                'consultation.labTests',
                'consultation.radiologies',
            ])
            ->orderByDesc('date')
            ->get();
        $labTests = $patient->labTests()->latest()->get();
        $radiologies = $patient->radiologies()->latest()->get();
        return view('patients.record', compact('patient', 'consultations', 'labTests', 'radiologies'));
    }
}