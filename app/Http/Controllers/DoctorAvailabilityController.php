<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;

class DoctorAvailabilityController extends Controller
{
    public const DURATIONS = [15, 20, 30, 45, 60];

    // GET /doctor/availabilities
    public function edit(Request $request)
    {
        $doctor = $request->user()->doctor;   // le médecin connecté
        $doctor->load('user', 'specialty', 'availabilities');

        $availabilities = collect(Availability::DAYS)->map(function ($dayName, $day) use ($doctor) {
            return $doctor->availabilities->firstWhere('weekday', $day)
                ?? new Availability(['weekday' => $day, 'is_active' => false]);
        });

        return view('doctors.availabilities.edit', [
            'doctor' => $doctor,
            'availabilities' => $availabilities,
            'durations' => self::DURATIONS,
        ]);
    }

    // PUT /doctor/availabilities
    public function update(Request $request)
    {
        $doctor = $request->user()->doctor;

        $data = $request->validate([
            'availabilities' => 'required|array|size:7',
            'availabilities.*.is_active' => 'required|boolean',
            'availabilities.*.start_time' => 'required|date_format:H:i',
            'availabilities.*.end_time' => 'required|date_format:H:i',
            'availabilities.*.slot_duration' => 'required|integer|in:' . implode(',', self::DURATIONS),
        ]);

        foreach ($data['availabilities'] as $day => $row) {
            if ($row['is_active'] && $row['end_time'] <= $row['start_time']) {
                return back()
                    ->withErrors(["availabilities.$day.end_time" => Availability::DAYS[$day] . ' : l’heure de fin doit être après l’heure de début.'])
                    ->withInput();
            }
        }

        if (! collect($data['availabilities'])->contains('is_active', true)) {
            return back()->withErrors(['availabilities' => 'Ouvrez au moins un jour.'])->withInput();
        }

        foreach ($data['availabilities'] as $day => $row) {
            $doctor->availabilities()->updateOrCreate(
                ['weekday' => $day],
                [
                    'is_active' => (bool) $row['is_active'],
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time'],
                    'slot_duration' => $row['slot_duration'],
                ]
            );
        }

        return to_route('doctor.availability.edit')->with('success', 'Horaires enregistrés.');
    }
}