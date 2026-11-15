<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // Annuaire : /doctors?q=amine&city=1&specialty=2
    public function index(Request $request)
    {
        $doctors = Doctor::with(['user', 'specialty', 'city'])
            ->where('is_validated', true)                                   // seulement les médecins validés
            ->when($request->q, fn ($query, $q) =>
                $query->whereHas('user', fn ($u) => $u->where('name', 'like', "%$q%")))
            ->when($request->city, fn ($query, $city) => $query->where('city_id', $city))
            ->when($request->specialty, fn ($query, $s) => $query->where('specialty_id', $s))
            ->orderBy('fee')
            ->paginate(6)
            ->withQueryString();                                             // garde les filtres dans la pagination

        $cities = City::orderBy('name')->get();
        $specialties = Specialty::orderBy('name')->get();

        return view('doctors.index', compact('doctors', 'cities', 'specialties'));
    }

    // Fiche publique : /doctors/{doctor}
    public function show(Doctor $doctor)
    {
        abort_unless($doctor->is_validated, 404);   // un médecin non validé n'est pas visible

        $doctor->load(['user', 'specialty', 'city', 'availabilities']);

        return view('doctors.show', compact('doctor'));
    }
}