{{-- resources/views/consultations/create.blade.php --}}
@extends('layouts.admin')
@section('title', 'Consultation')
@section('content')
    <h1 class="text-2xl font-bold">Consultation — {{ $appointment->patient->user->name }}</h1>
    <p class="text-slate-500">{{ $appointment->date->format('d/m/Y') }} à {{ $appointment->hour() }} · {{
        $appointment->reason }}</p>
    @if ($appointment->patient->allergies)
        <x-alert type="danger" class="mt-4">⚠ Allergies : {{ $appointment->patient->allergies }}</x-alert>
    @endif
    @if ($errors->any())
        <x-alert type="danger" class="mt-4">
            @foreach ($errors->all() as $error) <p>{{ $error }}</p> @endforeach
        </x-alert>
    @endif
    <form method="POST" action="{{ route('consultation.store', $appointment) }}" class="glass mt-6 space-y-6
        rounded-2xl p-6">
        @csrf
        <div>
            <label for="diagnosis">Diagnostic</label>
            <textarea id="diagnosis" name="diagnosis" rows="3">{{ old('diagnosis') }}</textarea>
        </div>
        <div>
            <label for="notes">Notes et conseils</label>
            <textarea id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
        </div>
        <h2 class="text-lg font-bold">Ordonnance</h2>
        {{-- 4 lignes ; les lignes sans médicament sont ignorées --}}
        @for ($i = 0; $i < 4; $i++)
            <div class="grid gap-2 md:grid-cols-4">
                <select name="items[{{ $i }}][medication_id]">
                    <option value="">— Médicament —</option>
                    @foreach ($medications as $medication)
                        <option value="{{ $medication->id }}" @selected(old("items.$i.medication_id") ==
                            $medication->id)>
                            {{ $medication->name }}
                        </option>
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
        <h2 class="text-lg font-bold">Examens demandés</h2>
        <div class="grid gap-2 md:grid-cols-2">
            @for ($i = 0; $i < 2; $i++)
                <input name="lab_tests[]" placeholder="Analyse (ex. Glycémie à jeun)" value="{{
                    old("lab_tests.$i") }}">
                <input name="radiologies[]" placeholder="Radio (ex. Radiographie thoracique)" value="{{
                    old("radiologies.$i") }}">
            @endfor
        </div>
        <button type="submit" class="btn-primary">Enregistrer la consultation</button>
    </form>
@endsection