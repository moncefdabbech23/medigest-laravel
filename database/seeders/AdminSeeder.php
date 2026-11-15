<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@medigest.tn',
            'password' => 'admin123',   // chiffré automatiquement (cast 'hashed' du modèle User)
            'role' => 'admin',
        ]);
    }
}