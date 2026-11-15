<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')->latest()->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }
    public function create()
    {
        return view('admin.patients.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules() + [
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|min:6',
        ]);
        // L'utilisateur et sa fiche patient sont créés ensemble, ou pas du tout
        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'patient',
            ]);
            $user->patient()->create($this->patientFields($data));
        });
        return to_route('admin.patient.index')->with('success', 'Patient ajouté.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['user', 'appointments.doctor.user']);
        return view('admin.patients.show', compact('patient'));
    }
    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }
    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate($this->rules() + [
            // ignorer l'email actuel du patient pour la règle unique
            'email' => ['required', 'email', 'max:150', Rule::unique('users',
                'email')->ignore($patient->user_id)],
        ]);
        DB::transaction(function () use ($data, $patient) {
            $patient->user->update(['name' => $data['name'], 'email' => $data['email']]);
            $patient->update($this->patientFields($data));
        });
        return to_route('admin.patient.index')->with('success', 'Patient modifié.');
    }
    public function destroy(Patient $patient)
    {
        // Supprimer l'utilisateur supprime aussi la fiche patient (cascadeOnDelete)
        $patient->user->delete();
        return to_route('admin.patient.index')->with('success', 'Patient supprimé.');
    }
    // Règles communes à store et update
    private function rules(): array
    {
        return [
            'name' => 'required|max:150',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:M,F',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'phone' => 'nullable|max:20',
            'allergies' => 'nullable|max:500',
            'chronic_diseases' => 'nullable|max:500',
            'address' => 'nullable|max:255',
            'emergency_contact' => 'nullable|max:255',
        ];
    }
    private function patientFields(array $data): array
    {
        return collect($data)->only([
            'birth_date', 'gender', 'blood_type', 'phone', 'allergies',
            'chronic_diseases', 'address', 'emergency_contact',
        ])->all();
    }
}