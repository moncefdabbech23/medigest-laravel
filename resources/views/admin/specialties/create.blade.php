@extends('layouts.admin')
@section('title', 'Nouvelle spécialité')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Nouvelle spécialité</h1>

    <form method="POST" action="{{ route('admin.specialty.store') }}" class="glass max-w-lg space-y-5 rounded-2xl p-6">
        @csrf
        <x-form.input name="name" label="Nom" />
        <x-form.input name="icon" label="Icône (emoji, ex. 🩺)" />
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Enregistrer</button>
            <a href="{{ route('admin.specialty.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection