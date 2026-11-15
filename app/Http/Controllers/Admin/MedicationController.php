<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medication;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    // Formes proposées dans la liste déroulante
    public const FORMS = ['Comprimé', 'Gélule', 'Sirop', 'Spray', 'Pommade', 'Injection', 'Solution nasale', 'Collyre'];

    public function index()
    {
        $medications = Medication::orderBy('name')->paginate(10);

        return view('admin.medications.index', compact('medications'));
    }

    public function create()
    {
        return view('admin.medications.create', ['forms' => self::FORMS]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:150|unique:medications',
            'form' => 'nullable|max:50',
        ]);

        Medication::create($data);

        return to_route('admin.medication.index')->with('success', 'Médicament ajouté.');
    }

    public function show(Medication $medication)
    {
        return view('admin.medications.show', compact('medication'));
    }

    public function edit(Medication $medication)
    {
        return view('admin.medications.edit', ['medication' => $medication, 'forms' => self::FORMS]);
    }

    public function update(Request $request, Medication $medication)
    {
        $data = $request->validate([
            'name' => 'required|max:150|unique:medications,name,' . $medication->id,
            'form' => 'nullable|max:50',
        ]);

        $medication->update($data);

        return to_route('admin.medication.index')->with('success', 'Médicament modifié.');
    }

    public function destroy(Medication $medication)
    {
        // Si le médicament figure dans une ordonnance (table de la personne B), MySQL refuse : on affiche un message
        try {
            $medication->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Impossible : ce médicament figure dans des ordonnances.');
        }

        return to_route('admin.medication.index')->with('success', 'Médicament supprimé.');
    }
}