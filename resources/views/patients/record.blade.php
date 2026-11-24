{{-- resources/views/patients/record.blade.php
     Utilisée par le patient (/my/record, lecture seule) et par le médecin (/doctor/patients/{patient}/record).
     $canEdit = true pour le médecin : il peut déposer les résultats (formulaires actifs après l'étape B15).
         --}}
@extends('layouts.admin')
@section('title', 'Dossier médical')
@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-teal-600">Dossier médical</p>
            <h1 class="text-2xl font-bold">{{ $patient->user->name }}</h1>
        </div>
        @if ($canEdit)
            <a href="{{ route('doctor.appointment.index') }}" class="btn-outline">← Mes rendez-vous</a>
        @endif
    </div>
    <x-form.errors class="mb-4" />
    {{-- Fiche --}}
    <div data-tilt="3" class="glass grid gap-3 rounded-2xl p-6 md:grid-cols-3">
        <p>Né(e) le : <strong>{{ $patient->birth_date?->format('d/m/Y') ?? '—' }}</strong></p>
        <p>Groupe sanguin : <strong>{{ $patient->blood_type ?? '—' }}</strong></p>
        <p>Allergies : <strong class="text-rose-600">{{ $patient->allergies ?: 'Aucune' }}</strong></p>
        <p>Maladies chroniques : {{ $patient->chronic_diseases ?: 'Aucune' }}</p>
        <p>Téléphone : {{ $patient->phone ?? '—' }}</p>
        <p>Contact d’urgence : {{ $patient->emergency_contact ?? '—' }}</p>
    </div>
    {{-- Consultations et ordonnances --}}
    <h2 class="mb-3 mt-8 text-lg font-bold">Consultations ({{ $consultations->count() }})</h2>
    @forelse ($consultations as $appointment)
        @php($consultation = $appointment->consultation)
        <div class="glass mb-4 rounded-2xl p-5">
            <p class="font-semibold">{{ $appointment->date->format('d/m/Y') }} — {{
                $appointment->doctor->user->name }}
                <span class="font-normal text-slate-500">({{ $appointment->doctor->specialty->name
                    }})</span></p>
            <p class="mt-2"><strong>Diagnostic :</strong> {{ $consultation->diagnosis }}</p>
            @if ($consultation->notes)
                <p class="text-slate-600">{{ $consultation->notes }}</p>
            @endif
            @if ($consultation->prescription)
                <p class="mt-3 font-semibold">Ordonnance</p>
                <ul class="list-disc pl-6 text-sm">
                    @foreach ($consultation->prescription->medications as $medication)

                        <li>{{ $medication->name }} — {{ $medication->pivot->dosage }}, {{
                            $medication->pivot->frequency }}, {{ $medication->pivot->duration }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('prescription.show', $consultation->prescription) }}" class="btn-outline
                    mt-3"> Voir / imprimer</a>
            @endif
        </div>
    @empty
        <p class="text-slate-500">Aucune consultation pour le moment.</p>
    @endforelse
    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        {{-- Analyses --}}
        <section>
            <h2 class="mb-3 text-lg font-bold"> Analyses</h2>
            @forelse ($labTests as $test)
                <div class="glass mb-3 rounded-2xl p-4">
                    <p class="font-semibold">{{ $test->type }}</p>
                    <p class="text-sm text-slate-600">{{ $test->result ?? 'Résultat en attente' }}</p>
                    @if ($test->result_file)
                        <a href="{{ asset('storage/' . $test->result_file) }}" target="_blank" class="mt-2
                            inline-block text-sm font-semibold text-teal-700 hover:underline"> Ouvrir le
                            PDF</a>
                    @endif
                    {{-- Le médecin qui a demandé l'analyse dépose le résultat (B15) --}}
                    @if ($canEdit && Route::has('doctor.lab-test.update') &&
                        $test->consultation->appointment->doctor_id == auth()->user()->doctor->id)
                        <form method="POST" action="{{ route('doctor.lab-test.update', $test) }}"
                            enctype="multipart/form-data" class="mt-3 space-y-2 border-t border-white/70 pt-3">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="result" value="{{ $test->result }}" placeholder="Résultat
                                (ex. Normale, 0,92 g/L)" aria-label="Résultat">
                            <input type="file" name="result_file" accept="application/pdf" aria-label="PDF du
                                résultat">
                            <button type="submit" class="btn-outline">Enregistrer le résultat</button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-slate-500">Aucune analyse.</p>
            @endforelse
        </section>
        {{-- Radios --}}
        <section>
            <h2 class="mb-3 text-lg font-bold"> Radios</h2>
            @forelse ($radiologies as $radiology)
                <div class="glass mb-3 rounded-2xl p-4">
                    <p class="font-semibold">{{ $radiology->type }}</p>
                    <p class="text-sm text-slate-600">{{ $radiology->report ?? 'Compte rendu en attente' }}</p>
                    @if ($radiology->image)
                        <a href="{{ asset('storage/' . $radiology->image) }}" target="_blank">
                            <img src="{{ asset('storage/' . $radiology->image) }}" alt="{{ $radiology->type }}"
                                class="mt-3 h-40 w-full rounded-xl object-cover">
                        </a>
                    @endif
                    @if ($canEdit && Route::has('doctor.radiology.update') &&
                        $radiology->consultation->appointment->doctor_id == auth()->user()->doctor->id)
                        <form method="POST" action="{{ route('doctor.radiology.update', $radiology) }}"
                            enctype="multipart/form-data" class="mt-3 space-y-2 border-t border-white/70 pt-3">
                            @csrf
                            @method('PATCH')
                            <textarea name="report" rows="2" placeholder="Compte rendu" aria-label="Compte
                                rendu">{{ $radiology->report }}</textarea>
                            <input type="file" name="image" accept="image/*" aria-label="Image de la radio">
                            <button type="submit" class="btn-outline">Enregistrer la radio</button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-slate-500">Aucune radio.</p>
            @endforelse
        </section>
    </div>
@endsection
