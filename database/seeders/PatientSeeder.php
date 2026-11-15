<?php
namespace Database\Seeders;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            ['Sarra Mansour', 'sarra@medigest.tn', '1992-04-14', 'F', 'A+', 'Pénicilline', 'Aucune'],
            ['Ahmed Jlassi', 'ahmed@medigest.tn', '1985-09-02', 'M', 'O+', '', 'Hypertension'],
            ['Leïla Trabelsi', 'leila@medigest.tn', '2001-01-23', 'F', 'B+', 'Pollen, Arachides', 'Asthme'],
            ['Karim Hammami', 'karim@medigest.tn', '1978-11-30', 'M', 'AB-', 'Aspirine', 'Diabète de type 2'],
            ['Nour Ben Youssef', 'nour@medigest.tn', '1996-06-18', 'F', 'O-', '', ''],
            ['Omar Cherif', 'omar@medigest.tn', '1969-03-05', 'M', 'A-', 'Ibuprofène', 'Cholestérol'],
        ];
        foreach ($patients as [$name, $email, $birth, $gender, $blood, $allergies, $diseases]) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('patient123'),
                'role' => 'patient',
            ]);
            Patient::create([
                'user_id' => $user->id,
                'birth_date' => $birth,
                'gender' => $gender,
                'blood_type' => $blood,
                'phone' => '22 000 000',
                'allergies' => $allergies,
                'chronic_diseases' => $diseases,
                'address' => 'Tunis',
                'emergency_contact' => 'Famille - 98 000 000',
            ]);
        }
    }
}
