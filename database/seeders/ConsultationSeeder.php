<?php
namespace Database\Seeders;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Medication;
use Illuminate\Database\Seeder;
class ConsultationSeeder extends Seeder
{
    public function run(): void
    {
        $medications = Medication::pluck('id')->all();   // médicaments de la personne A
        // Une consultation pour chaque rendez-vous terminé
        foreach (Appointment::where('status', 'done')->get() as $i => $appointment) {
            $consultation = Consultation::create([
                'appointment_id' => $appointment->id,
                'diagnosis' => ['Palpitations bénignes', 'Rhinopharyngite virale', 'Diabète équilibré'][$i % 3],
                'notes' => 'Contrôle dans 3 mois.',
            ]);
            $prescription = $consultation->prescription()->create([
                'date' => $appointment->date,
            ]);
            // Remplir la table pivot avec attach()
            $prescription->medications()->attach($medications[$i % count($medications)], [
                'dosage' => '1 comprimé',
                'frequency' => '2 fois par jour',
                'duration' => '7 jours',
            ]);
            $consultation->labTests()->create([
                'patient_id' => $appointment->patient_id,
                'type' => 'Glycémie à jeun',
                'result' => 'Normale (0,92 g/L)',
            ]);
            $consultation->radiologies()->create([
                'patient_id' => $appointment->patient_id,
                'type' => 'Radiographie thoracique',
                'report' => 'Aucune anomalie visible.',
            ]);
        }
    }
}