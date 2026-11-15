{{-- resources/views/patients/record.blade.php --}}
@extends('layouts.admin')
@section('title', 'Dossier médical')
@section('content')
    <h1 class="text-2xl font-bold">Dossier médical — {{ $patient->user->name }}</h1>
    {{-- Fiche --}}
    <div class="glass mt-6 grid gap-2 rounded-2xl p-6 md:grid-cols-3">
        <p>Né(e) le : <strong>{{ $patient->birth_date?->format('d/m/Y') ?? '—' }}</strong></p>
        <p>Groupe sanguin : <strong>{{ $patient->blood_type ?? '—' }}</strong></p>
        <p>Allergies : <strong class="text-red-600">{{ $patient->allergies ?: 'Aucune' }}</strong></p>
        <p>Maladies chroniques : {{ $patient->chronic_diseases ?: 'Aucune' }}</p>
        <p>Contact d’urgence : {{ $patient->emergency_contact ?? '—' }}</p>
    </div>
    {{-- Consultations et ordonnances --}}
    <h2 class="mt-8 mb-3 text-lg font-bold">Consultations ({{ $consultations->count() }})</h2>
    @forelse ($consultations as $appointment)
        @php($consultation = $appointment->consultation)
        <div class="glass mb-4 rounded-2xl p-5">
            <p class="font-semibold">{{ $appointment->date->format('d/m/Y') }} — {{
                $appointment->doctor->user->name }}
                <span class="text-slate-500">({{ $appointment->doctor->specialty->name }})</span></p>
            <p class="mt-2"><strong>Diagnostic :</strong> {{ $consultation->diagnosis }}</p>
            @if ($consultation->notes) <p class="text-slate-600">{{ $consultation->notes }}</p> @endif
            @if ($consultation->prescription)
                <p class="mt-3 font-semibold">Ordonnance</p>
                <ul class="list-disc pl-6">
                    @foreach ($consultation->prescription->medications as $medication)
                        <li>{{ $medication->name }} — {{ $medication->pivot->dosage }},
                            {{ $medication->pivot->frequency }}, {{ $medication->pivot->duration }}</li>
                    @endforeach
                </ul>
                @if (Route::has('prescription.show')) {{-- lien actif après l'étape B12 --}}
                    <a href="{{ route('prescription.show', $consultation->prescription) }}" class="btn-outline
                        mt-2 inline-block">Voir / imprimer</a>
                @endif
            @endif
        </div>
    @empty
        <p class="text-slate-500">Aucune consultation pour le moment.</p>
    @endforelse
    {{-- Analyses et radios --}}
    <div class="mt-8 grid gap-6 md:grid-cols-2">
        <div>
            <h2 class="mb-3 text-lg font-bold">Analyses</h2>
            @forelse ($labTests as $test)
                <p class="border-b border-white/70 py-2">{{ $test->type }} — {{ $test->result ?? 'résultat en
                    attente' }}</p>
            @empty
                <p class="text-slate-500">Aucune analyse.</p>
            @endforelse
        </div>
        <div>
            <h2 class="mb-3 text-lg font-bold">Radios</h2>
            @forelse ($radiologies as $radiology)
                <p class="border-b border-white/70 py-2">{{ $radiology->type }} — {{ $radiology->report ??
                    'compte rendu en attente' }}</p>
            @empty
                <p class="text-slate-500">Aucune radio.</p>
            @endforelse
        </div>
    </div>
@endsection