<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            'Médecine générale' => '🩺',
            'Cardiologie' => '❤️',
            'Dentiste' => '🦷',
            'Dermatologie' => '🧴',
            'Pédiatrie' => '👶',
            'Ophtalmologie' => '👁️',
            'Gynécologie' => '🤰',
            'ORL' => '👂',
        ];

        foreach ($specialties as $name => $icon) {
            Specialty::create(['name' => $name, 'icon' => $icon]);
        }
    }
}