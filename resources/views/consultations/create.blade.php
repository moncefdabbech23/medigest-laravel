{{-- resources/views/consultations/create.blade.php --}}
@extends('layouts.admin')
@section('title', 'Consultation')
@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Consultation — {{ $appointment->patient->user->name }}</h1>
            <p class="text-slate-500">{{ $appointment->date->format('d/m/Y') }} à {{ $appointment->hour() }} ·
                {{ $appointment->reason }}</p>
        </div>
        <a href="{{ route('doctor.patient.record', $appointment->patient) }}" class="btn-outline">Voir le
            dossier</a>
    </div>
    @if ($appointment->patient->allergies)
        <x-alert type="danger" class="mb-4">⚠ Allergies : {{ $appointment->patient->allergies }}</x-alert>
    @endif
    <x-form.errors class="mb-4" />
    <form method="POST" action="{{ route('doctor.consultation.store', $appointment) }}" class="glass space-y-6
        rounded-2xl p-6">
        @csrf
        <x-form.textarea name="diagnosis" label="Diagnostic" />
        <x-form.textarea name="notes" label="Notes et conseils" rows="2" />
        <div>
            <h2 class="mb-2 text-lg font-bold"> Ordonnance</h2>
            <p class="mb-3 text-xs text-slate-500">Remplissez de 0 à 4 lignes. Les lignes sans médicament sont
                ignorées.</p>
            @for ($i = 0; $i < 4; $i++)
                <div class="mb-2 grid gap-2 md:grid-cols-4">
                    <select name="items[{{ $i }}][medication_id]" aria-label="Médicament">
                        <option value="">— Médicament —</option>
                        @foreach ($medications as $medication)
                            <option value="{{ $medication->id }}" @selected(old("items.$i.medication_id") ==
                                $medication->id)>{{ $medication->name }}</option>
                        @endforeach
                    </select>
                    <input name="items[{{ $i }}][dosage]" placeholder="Dosage (1 comprimé)" value="{{
                        old("items.$i.dosage") }}">
                    <input name="items[{{ $i }}][frequency]" placeholder="Fréquence (3 fois/jour)" value="{{
                        old("items.$i.frequency") }}">
                    <input name="items[{{ $i }}][duration]" placeholder="Durée (5 jours)" value="{{
                        old("items.$i.duration") }}">
                </div>
            @endfor
        </div>
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <h2 class="mb-2 text-lg font-bold"> Analyses demandées</h2>
                @for ($i = 0; $i < 2; $i++)
                    <input name="lab_tests[]" class="mb-2" placeholder="Ex. Glycémie à jeun" value="{{
                        old("lab_tests.$i") }}">
                @endfor
            </div>
            <div>
                <h2 class="mb-2 text-lg font-bold"> Radios demandées</h2>
                @for ($i = 0; $i < 2; $i++)
                    <input name="radiologies[]" class="mb-2" placeholder="Ex. Radiographie thoracique"
                        value="{{ old("radiologies.$i") }}">
                @endfor
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Enregistrer la consultation</button>
            <a href="{{ route('doctor.appointment.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
