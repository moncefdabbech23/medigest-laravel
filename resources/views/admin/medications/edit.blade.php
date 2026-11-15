@extends('layouts.admin')
@section('title', 'Modifier le médicament')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Modifier : {{ $medication->name }}</h1>

    <form method="POST" action="{{ route('admin.medication.update', $medication) }}" class="glass max-w-lg space-y-5 rounded-2xl p-6">
        @csrf
        @method('PUT')
        <x-form.input name="name" label="Nom et dosage" :value="$medication->name" />
        <x-form.select name="form" label="Forme" :options="array_combine($forms, $forms)" :selected="$medication->form" />
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.medication.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection