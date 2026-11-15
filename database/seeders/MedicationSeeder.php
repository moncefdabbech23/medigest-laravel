<?php

namespace Database\Seeders;

use App\Models\Medication;
use Illuminate\Database\Seeder;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        $medications = [
            ['Paracétamol 500 mg', 'Comprimé'],
            ['Amoxicilline 1 g', 'Comprimé'],
            ['Ibuprofène 400 mg', 'Comprimé'],
            ['Oméprazole 20 mg', 'Gélule'],
            ['Ventoline 100 µg', 'Spray'],
            ['Aspirine 500 mg', 'Comprimé'],
            ['Pénicilline V 1 MUI', 'Comprimé'],
            ['Cétirizine 10 mg', 'Comprimé'],
            ['Metformine 850 mg', 'Comprimé'],
            ['Sérum physiologique', 'Solution nasale'],
        ];

        foreach ($medications as [$name, $form]) {
            Medication::create(['name' => $name, 'form' => $form]);
        }
    }
}