@extends('layouts.admin')
@section('title', 'Nouveau médicament')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Nouveau médicament</h1>

    <form method="POST" action="{{ route('admin.medication.store') }}" class="glass max-w-lg space-y-5 rounded-2xl p-6">
        @csrf
        <x-form.input name="name" label="Nom et dosage (ex. Paracétamol 500 mg)" />
        <x-form.select name="form" label="Forme" :options="array_combine($forms, $forms)" />
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Enregistrer</button>
            <a href="{{ route('admin.medication.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
