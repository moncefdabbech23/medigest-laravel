<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Doctor;
use App\Models\Specialty;

class HomeController extends Controller
{
    public function index()
    {
        // Spécialités avec le nombre de médecins validés
        $specialties = Specialty::withCount(['doctors' => fn ($q) => $q->where('is_validated', true)])
            ->orderBy('name')
            ->get();

        // 3 derniers médecins validés
        $doctors = Doctor::with(['user', 'specialty', 'city'])
            ->where('is_validated', true)
            ->latest()
            ->take(3)
            ->get();

        // Listes du formulaire de recherche
        $cities = City::orderBy('name')->get();

        return view('home', compact('specialties', 'doctors', 'cities'));
    }
}