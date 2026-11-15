<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Medication;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ConsultationController extends Controller
{
    // /appointments/{appointment}/consultation/create
    public function create(Appointment $appointment)
    {
        if ($appointment->consultation()->exists()) {
            return back()->with('success', 'La consultation de ce rendez-vous est déjà enregistrée.');
        }
        $appointment->load('patient.user', 'doctor.user');
        $medications = Medication::orderBy('name')->get();
        return view('consultations.create', compact('appointment', 'medications'));
    }
    public function store(Request $request, Appointment $appointment)
    {
        // Une seule consultation par rendez-vous (appointment_id est unique)
        abort_if($appointment->consultation()->exists(), 409, 'Consultation déjà enregistrée.');
        // Ignorer les lignes d'ordonnance et les examens laissés vides
        $request->merge([
            'items' => array_values(array_filter($request->input('items', []), fn ($i) => !
                empty($i['medication_id']))),
            'lab_tests' => array_values(array_filter($request->input('lab_tests', []))),
            'radiologies' => array_values(array_filter($request->input('radiologies', []))),
        ]);
        $data = $request->validate([
            'diagnosis' => 'required|max:2000',
            'notes' => 'nullable|max:2000',
            'items' => 'array',
            'items.*.medication_id' => 'required|integer|exists:medications,id',
            'items.*.dosage' => 'required|max:100',
            'items.*.frequency' => 'required|max:100',
            'items.*.duration' => 'required|max:100',
            'lab_tests' => 'array',
            'lab_tests.*' => 'string|max:150',
MediGest · Personne B · guide complet page 37
            'radiologies' => 'array',
            'radiologies.*' => 'string|max:150',
        ]);
        // Sécurité : refuser un médicament auquel le patient est allergique
        $allergies = $appointment->patient->allergyList();
        $names = Medication::whereIn('id', collect($data['items'])->pluck('medication_id'))->pluck('name');
        foreach ($names as $name) {
            foreach ($allergies as $allergy) {
                if (str_contains(mb_strtolower($name), $allergy)) {
                    return back()->withErrors(['items' => "Allergie du patient : « $allergy ». $name ne peut
                        pas être prescrit."])
                        ->withInput();
                }
            }
        }
        // Tout est enregistré ensemble, ou rien (transaction)
        DB::transaction(function () use ($data, $appointment) {
            $consultation = $appointment->consultation()->create([
                'diagnosis' => $data['diagnosis'],
                'notes' => $data['notes'] ?? null,
            ]);
            if (! empty($data['items'])) {
                $prescription = $consultation->prescription()->create(['date' => today()]);
                // sync() avec les colonnes de la table pivot
                $prescription->medications()->sync(
                    collect($data['items'])->mapWithKeys(fn ($item) => [
                        $item['medication_id'] => [
                            'dosage' => $item['dosage'],
                            'frequency' => $item['frequency'],
                            'duration' => $item['duration'],
                        ],
                    ])->all()
                );
            }
            foreach ($data['lab_tests'] as $type) {
                $consultation->labTests()->create(['patient_id' => $appointment->patient_id, 'type' => $type]);
            }
            foreach ($data['radiologies'] as $type) {
                $consultation->radiologies()->create(['patient_id' => $appointment->patient_id, 'type' =>
                    $type]);
            }
            $appointment->update(['status' => Appointment::DONE]);
        });
        UserNotification::send($appointment->patient->user_id, 'Votre dossier médical a été mis à jour par
            votre médecin.');
        return to_route('doctor.appointment.index', $appointment->doctor_id)
            ->with('success', 'Consultation enregistrée.');
    }
}