<?php

namespace App\Http\Controllers;

use App\Models\Specialty;

class SpecialtyController extends Controller
{
    // /specialties/{specialty} : la spécialité et ses médecins validés
    public function show(Specialty $specialty)
    {
        $doctors = $specialty->doctors()
            ->with(['user', 'city'])
            ->where('is_validated', true)
            ->paginate(6);

        return view('specialties.show', compact('specialty', 'doctors'));
    }
}