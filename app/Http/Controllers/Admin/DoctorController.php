<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    // Liste avec filtre : ?status=validated ou ?status=pending
    public function index(Request $request)
    {
        $status = $request->query('status');

        $doctors = Doctor::with(['user', 'specialty', 'city'])          // évite le problème N + 1
            ->when($status === 'validated', fn ($q) => $q->where('is_validated', true))
            ->when($status === 'pending', fn ($q) => $q->where('is_validated', false))
            ->latest()
            ->paginate(10)
            ->withQueryString();                                        // garde le filtre dans la pagination

        $pendingCount = Doctor::where('is_validated', false)->count();

        return view('admin.doctors.index', compact('doctors', 'status', 'pendingCount'));
    }

    public function create()
    {
        return view('admin.doctors.create', $this->formOptions());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules() + [
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Le compte utilisateur, la fiche médecin et ses horaires : tout ou rien
        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'doctor',
            ]);

            $doctor = $user->doctor()->create($this->doctorFields($data));

            // Horaires par défaut : lundi à vendredi, 9 h – 17 h, créneaux de 30 min
            for ($day = 1; $day <= 7; $day++) {
                $doctor->availabilities()->create(['weekday' => $day, 'is_active' => $day <= 5]);
            }
        });

        return to_route('admin.doctor.index')->with('success', 'Médecin ajouté.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'specialty', 'city', 'availabilities']);

        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $doctor->load('user');

        return view('admin.doctors.edit', ['doctor' => $doctor] + $this->formOptions());
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate($this->rules() + [
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($doctor->user_id)],
        ]);

        DB::transaction(function () use ($data, $doctor) {
            $doctor->user->update(['name' => $data['name'], 'email' => $data['email']]);
            $doctor->update($this->doctorFields($data));
        });

        return to_route('admin.doctor.index')->with('success', 'Médecin modifié.');
    }

    public function destroy(Doctor $doctor)
    {
        // Supprimer le compte supprime aussi la fiche médecin et ses horaires (cascadeOnDelete)
        $doctor->user->delete();

        return to_route('admin.doctor.index')->with('success', 'Médecin supprimé.');
    }

    // Valider ou suspendre un médecin : PATCH /admin/doctors/{doctor}/validate
    public function toggleValidation(Doctor $doctor)
    {
        $doctor->update(['is_validated' => ! $doctor->is_validated]);

        $message = $doctor->is_validated
            ? $doctor->user->name . ' est validé : il apparaît dans l’annuaire.'
            : $doctor->user->name . ' est suspendu : il n’apparaît plus dans l’annuaire.';

        return back()->with('success', $message);
    }

    // ---------- Méthodes privées réutilisées ----------

    private function rules(): array
    {
        return [
            'name' => 'required|max:150',
            'specialty_id' => 'required|exists:specialties,id',
            'city_id' => 'required|exists:cities,id',
            'office_address' => 'nullable|max:255',
            'fee' => 'required|numeric|min:0|max:9999',
            'description' => 'nullable|max:2000',
            'is_validated' => 'nullable|boolean',
        ];
    }

    private function doctorFields(array $data): array
    {
        return [
            'specialty_id' => $data['specialty_id'],
            'city_id' => $data['city_id'],
            'office_address' => $data['office_address'] ?? null,
            'fee' => $data['fee'],
            'description' => $data['description'] ?? null,
            'is_validated' => (bool) ($data['is_validated'] ?? false),
        ];
    }

    // Listes déroulantes : [id => nom]
    private function formOptions(): array
    {
        return [
            'specialties' => Specialty::orderBy('name')->pluck('name', 'id'),
            'cities' => City::orderBy('name')->pluck('name', 'id'),
        ];
    }
}