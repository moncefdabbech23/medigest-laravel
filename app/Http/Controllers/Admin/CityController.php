<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    // Liste paginée (avec le nombre de médecins de chaque ville)
    public function index()
    {
        $cities = City::withCount('doctors')->orderBy('name')->paginate(10);

        return view('admin.cities.index', compact('cities'));
    }

    // Formulaire d'ajout
    public function create()
    {
        return view('admin.cities.create');
    }

    // Enregistrer l'ajout
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100|unique:cities',
        ]);

        City::create($data);

        return to_route('admin.city.index')->with('success', 'Ville ajoutée.');
    }

    // Détail : la ville et ses médecins
    public function show(City $city)
    {
        $city->load('doctors.user', 'doctors.specialty');

        return view('admin.cities.show', compact('city'));
    }

    // Formulaire de modification
    public function edit(City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    // Enregistrer la modification
    public function update(Request $request, City $city)
    {
        $data = $request->validate([
            // ignorer la ville en cours pour la règle unique
            'name' => 'required|max:100|unique:cities,name,' . $city->id,
        ]);

        $city->update($data);

        return to_route('admin.city.index')->with('success', 'Ville modifiée.');
    }

    // Supprimer
    public function destroy(City $city)
    {
        // Interdit si des médecins exercent dans cette ville (restrictOnDelete)
        if ($city->doctors()->exists()) {
            return back()->with('error', 'Impossible : des médecins exercent dans cette ville.');
        }

        $city->delete();

        return to_route('admin.city.index')->with('success', 'Ville supprimée.');
    }
}