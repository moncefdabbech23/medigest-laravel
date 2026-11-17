<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorProfileController extends Controller
{
    // GET /doctor/profile
    public function edit(Request $request)
    {
        $doctor = $request->user()->doctor->load('user', 'specialty', 'city');
        $cities = City::orderBy('name')->pluck('name', 'id');

        return view('doctors.profile', compact('doctor', 'cities'));
    }

    // PUT /doctor/profile
    public function update(Request $request)
    {
        $doctor = $request->user()->doctor;

        $data = $request->validate([
            'name' => 'required|max:150',
            'city_id' => 'required|exists:cities,id',
            'office_address' => 'nullable|max:255',
            'fee' => 'required|numeric|min:0|max:9999',
            'description' => 'nullable|max:2000',
        ]);

        DB::transaction(function () use ($doctor, $data) {
            $doctor->user->update(['name' => $data['name']]);
            $doctor->update(collect($data)->only(['city_id', 'office_address', 'fee', 'description'])->all());
        });

        return to_route('doctor.profile.edit')->with('success', 'Profil mis à jour.');
    }
}