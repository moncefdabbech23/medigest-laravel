<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Personne A
            CitySeeder::class,
            SpecialtySeeder::class,
            MedicationSeeder::class,
            AdminSeeder::class,
            DoctorSeeder::class,

            // Personne B : ses seeders viendront ici (PatientSeeder, AppointmentSeeder, ConsultationSeeder)
        ]);
    }
}