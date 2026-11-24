<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\LabTest;
use App\Models\Radiology;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class MedicalFileController extends Controller
{
    // PATCH /doctor/lab-tests/{labTest} : résultat d'analyse (texte + PDF)
    public function updateLabTest(Request $request, LabTest $labTest)
    {
        $this->authorizeDoctor($labTest->consultation->appointment);
        $data = $request->validate([
            'result' => 'nullable|max:1000',
            'result_file' => 'nullable|file|mimes:pdf|max:5120',   // PDF de 5 Mo maximum
        ]);
        unset($data['result_file']);   // on ne touche au fichier que si un nouveau est envoyé
        if ($request->hasFile('result_file')) {
            if ($labTest->result_file) {
                Storage::disk('public')->delete($labTest->result_file);   // supprimer l'ancien
            }
            $data['result_file'] = $request->file('result_file')->store('lab-tests', 'public');
        }
        $labTest->update($data);
        UserNotification::send($labTest->patient->user_id, 'Le résultat de votre analyse « ' . $labTest->type .
            ' » est disponible.');
        return back()->with('success', 'Résultat enregistré.');
    }
    // PATCH /doctor/radiologies/{radiology} : compte rendu + image
    public function updateRadiology(Request $request, Radiology $radiology)
    {
        $this->authorizeDoctor($radiology->consultation->appointment);
        $data = $request->validate([
            'report' => 'nullable|max:2000',
            'image' => 'nullable|image|max:2048',   // jpg, png, webp... 2 Mo maximum

        ]);
        unset($data['image']);
        if ($request->hasFile('image')) {
            if ($radiology->image) {
                Storage::disk('public')->delete($radiology->image);
            }
            $data['image'] = $request->file('image')->store('radiologies', 'public');
        }
        $radiology->update($data);
        UserNotification::send($radiology->patient->user_id, 'Votre radio « ' . $radiology->type . ' » est
            disponible.');
        return back()->with('success', 'Radio enregistrée.');
    }
    // Seul le médecin qui a demandé l'examen peut déposer le résultat
    private function authorizeDoctor(Appointment $appointment): void
    {
        abort_unless($appointment->doctor()->is(auth()->user()->doctor), 403);
    }
}