<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = ['Tunis', 'Ariana', 'Ben Arous', 'La Marsa', 'Nabeul', 'Bizerte', 'Sousse', 'Monastir', 'Sfax', 'Gabès'];

        foreach ($cities as $name) {
            City::create(['name' => $name]);
        }
    }
}