<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Chiffres clés ---
        $stats = [
            'patients' => Patient::count(),
            'doctors' => Doctor::where('is_validated', true)->count(),
            'appointmentsMonth' => Appointment::whereYear('date', now()->year)
                ->whereMonth('date', now()->month)->count(),
            'pendingDoctors' => Doctor::where('is_validated', false)->count(),
        ];

        // --- Rendez-vous par statut (en attente, confirmé, annulé, terminé) ---
        $byStatus = Appointment::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // --- Rendez-vous des 6 derniers mois (pour le graphique en barres) ---
        $start = now()->subMonths(5)->startOfMonth();
        $perMonth = Appointment::where('date', '>=', $start)->get()
            ->groupBy(fn ($a) => $a->date->format('Y-m'))
            ->map->count();

        $months = collect(range(0, 5))->map(function ($i) use ($start, $perMonth) {
            $month = $start->copy()->addMonths($i);
            return [
                'label' => ucfirst($month->translatedFormat('M')),
                'total' => $perMonth[$month->format('Y-m')] ?? 0,
            ];
        });
        $maxMonth = max(1, $months->max('total'));   // évite une division par 0

        // --- Médecins les plus demandés ---
        $topDoctors = Doctor::with(['user', 'specialty'])
            ->withCount('appointments')
            ->orderByDesc('appointments_count')
            ->take(5)
            ->get();

        // --- Derniers rendez-vous ---
        $latestAppointments = Appointment::with(['patient.user', 'doctor.user'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'byStatus', 'months', 'maxMonth', 'topDoctors', 'latestAppointments'
        ));
    }
}