<?php
namespace Database\Seeders;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;
class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $doctor = Doctor::first();          // le premier médecin de la personne A
        $patients = Patient::all();
        // [patient, jours par rapport à aujourd'hui, heure, motif, statut]
        $rows = [
            [0, 2, '10:30', 'Contrôle annuel', 'confirmed'],
            [1, 0, '14:00', 'Suivi de la tension', 'confirmed'],
            [2, 0, '14:30', 'Toux persistante', 'pending'],
            [3, 1, '09:00', 'Renouvellement d’ordonnance', 'pending'],
            [4, 3, '11:30', 'Maux de gorge', 'pending'],
            [0, -35, '09:30', 'Palpitations', 'done'],
            [1, -7, '10:00', 'Rhume', 'done'],
            [3, -21, '09:30', 'Bilan du diabète', 'done'],
            [5, -28, '16:00', 'Fatigue', 'cancelled'],
        ];
        foreach ($rows as [$p, $days, $time, $reason, $status]) {
            Appointment::create([
                'patient_id' => $patients[$p]->id,
                'doctor_id' => $doctor->id,
                'date' => now()->addDays($days)->toDateString(),
                'time' => $time,
                'reason' => $reason,
                'status' => $status,
            ]);
        }
    }
}