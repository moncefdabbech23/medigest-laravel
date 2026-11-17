@extends('layouts.admin')
@section('title', 'Mon profil')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Mon profil</h1>
            <p class="text-slate-500">{{ $doctor->specialty->icon }} {{ $doctor->specialty->name }} · {{ $doctor->user->email }}</p>
        </div>
        @if ($doctor->is_validated)
            <a href="{{ route('doctor.show', $doctor) }}" class="btn-outline" target="_blank">Voir ma fiche publique ↗</a>
        @endif
    </div>

    <form method="POST" action="{{ route('doctor.profile.update') }}" class="glass max-w-3xl space-y-5 rounded-2xl p-6">
        @csrf
        @method('PUT')

        <x-form.errors />

        <div class="grid gap-5 md:grid-cols-2">
            <x-form.input name="name" label="Nom affiché (ex. Dr Amine Ben Salah)" :value="$doctor->user->name" />
            <x-form.select name="city_id" label="Ville" :options="$cities" :selected="$doctor->city_id" />
            <x-form.input name="office_address" label="Adresse du cabinet" :value="$doctor->office_address" />
            <x-form.input name="fee" label="Tarif de la consultation (DT)" type="number" step="0.01" min="0" :value="$doctor->fee" />
        </div>

        <x-form.textarea name="description" label="Présentation (visible par les patients)" :value="$doctor->description" rows="5" />

        <p class="text-xs text-slate-500">La spécialité et la validation du compte sont gérées par l’administrateur.</p>
        <button type="submit" class="btn-primary">Enregistrer</button>
    </form>
@endsection