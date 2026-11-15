{{-- resources/views/admin/patients/show.blade.php --}}
@extends('layouts.admin')
@section('title', $patient->user->name)
@section('content')
    <h1 class="text-2xl font-bold">{{ $patient->user->name }}</h1>
    <p class="text-slate-500">{{ $patient->user->email }} · {{ $patient->phone }}</p>
    <div class="glass mt-6 grid gap-2 rounded-2xl p-6 md:grid-cols-2">
        <p>Né(e) le : {{ $patient->birth_date?->format('d/m/Y') ?? '—' }}</p>
        <p>Groupe sanguin : {{ $patient->blood_type ?? '—' }}</p>
        <p>Allergies : {{ $patient->allergies ?: 'Aucune' }}</p>
        <p>Maladies chroniques : {{ $patient->chronic_diseases ?: 'Aucune' }}</p>
    </div>
    <h2 class="mt-8 mb-3 text-lg font-bold">Rendez-vous</h2>
    @forelse ($patient->appointments as $appointment)
        <p>{{ $appointment->date->format('d/m/Y') }} à {{ $appointment->hour() }}
            — {{ $appointment->doctor->user->name }} — {{ $appointment->statusLabel() }}</p>
    @empty
        <p class="text-slate-500">Aucun rendez-vous.</p>
    @endforelse
    @if (Route::has('patient.record')) {{-- lien actif après l'étape B11 --}}
        <a href="{{ route('patient.record', $patient) }}" class="btn-primary mt-6 inline-block">Voir le dossier
            médical</a>

        
    @endif
@endsection