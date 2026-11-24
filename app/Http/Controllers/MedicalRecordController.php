<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
class MedicalRecordController extends Controller
{
    // /my/record : le dossier du patient connecté (lecture seule)
    public function mine(Request $request)
    {
        return $this->render($request->user()->patient, false);
    }
    // /doctor/patients/{patient}/record : un médecin ouvre le dossier d'un de SES patients (B14)
    public function forDoctor(Request $request, Patient $patient)
    {
        $doctor = $request->user()->doctor;
        // Il doit avoir eu au moins un rendez-vous avec ce patient
        abort_unless($doctor->appointments()->where('patient_id', $patient->id)->exists(), 403);
        return $this->render($patient, true);
    }
    private function render(Patient $patient, bool $canEdit)
    {
        $patient->load('user');
        $consultations = $patient->appointments()
            ->where('status', Appointment::DONE)
            ->whereHas('consultation')
            ->with([
                'doctor.user',
                'doctor.specialty',
                'consultation.prescription.medications',
            ])
            ->orderByDesc('date')
            ->get();
        // with('consultation.appointment') : pour savoir quel médecin a demandé l'examen (B15)
        $labTests = $patient->labTests()->with('consultation.appointment')->latest()->get();
        $radiologies = $patient->radiologies()->with('consultation.appointment')->latest()->get();
        return view('patients.record', compact('patient', 'consultations', 'labTests', 'radiologies',
            'canEdit'));
    }
}