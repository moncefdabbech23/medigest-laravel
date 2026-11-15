<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // [nom, email, spécialité, ville, tarif, début, fin, jours travaillés, validé]
        $doctors = [
            ['Dr Amine Ben Salah', 'amine', 'Médecine générale', 'Tunis', 60, '09:00', '16:00', [1, 2, 3, 4, 5, 6], true],
            ['Dr Yasmine Trabelsi', 'yasmine', 'Pédiatrie', 'La Marsa', 80, '10:00', '17:00', [1, 2, 3, 4, 5], true],
            ['Dr Mohamed Gharbi', 'mohamed', 'Cardiologie', 'Sousse', 100, '08:30', '14:30', [1, 2, 3, 4], true],
            ['Dr Inès Khelifi', 'ines', 'Dermatologie', 'Sfax', 75, '09:00', '15:00', [2, 3, 4, 5, 6], true],
            ['Dr Sami Bouzid', 'sami', 'Dentiste', 'Tunis', 70, '09:00', '17:00', [1, 2, 3, 4, 5], true],
            ['Dr Rania Mejri', 'rania', 'Ophtalmologie', 'Ariana', 90, '10:00', '16:00', [1, 3, 5], true],
            ['Dr Walid Chaabane', 'walid', 'Gynécologie', 'Nabeul', 85, '09:00', '13:00', [1, 2, 4, 6], true],
            ['Dr Karim Jaziri', 'jaziri', 'ORL', 'Bizerte', 70, '09:00', '15:00', [1, 2, 3, 4, 5], false], // à valider par l'admin
        ];

        foreach ($doctors as [$name, $login, $specialty, $city, $fee, $start, $end, $days, $validated]) {
            $user = User::create([
                'name' => $name,
                'email' => "$login@medigest.tn",
                'password' => 'medecin123',
                'role' => 'doctor',
            ]);

            $doctor = Doctor::create([
                'user_id' => $user->id,
                'specialty_id' => Specialty::where('name', $specialty)->first()->id,
                'city_id' => City::where('name', $city)->first()->id,
                'office_address' => "Cabinet médical, $city",
                'fee' => $fee,
                'description' => "$specialty à $city. Consultations sur rendez-vous.",
                'is_validated' => $validated,
            ]);

            // 7 disponibilités : une par jour (actives seulement les jours travaillés)
            for ($day = 1; $day <= 7; $day++) {
                $doctor->availabilities()->create([
                    'weekday' => $day,
                    'start_time' => $start,
                    'end_time' => $day === 6 ? '12:00' : $end,   // samedi : matin seulement
                    'slot_duration' => 30,
                    'is_active' => in_array($day, $days),
                ]);
            }
        }
    }
}