<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::withCount('doctors')->orderBy('name')->paginate(10);

        return view('admin.specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('admin.specialties.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100|unique:specialties',
            'icon' => 'nullable|max:20',
        ]);

        Specialty::create($data);

        return to_route('admin.specialty.index')->with('success', 'Spécialité ajoutée.');
    }

    public function show(Specialty $specialty)
    {
        $specialty->load('doctors.user', 'doctors.city');

        return view('admin.specialties.show', compact('specialty'));
    }

    public function edit(Specialty $specialty)
    {
        return view('admin.specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty)
    {
        $data = $request->validate([
            'name' => 'required|max:100|unique:specialties,name,' . $specialty->id,
            'icon' => 'nullable|max:20',
        ]);

        $specialty->update($data);

        return to_route('admin.specialty.index')->with('success', 'Spécialité modifiée.');
    }

    public function destroy(Specialty $specialty)
    {
        if ($specialty->doctors()->exists()) {
            return back()->with('error', 'Impossible : des médecins ont cette spécialité.');
        }

        $specialty->delete();

        return to_route('admin.specialty.index')->with('success', 'Spécialité supprimée.');
    }
}