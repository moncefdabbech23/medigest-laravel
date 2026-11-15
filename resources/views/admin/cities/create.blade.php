@extends('layouts.admin')
@section('title', 'Nouvelle ville')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Nouvelle ville</h1>

    <form method="POST" action="{{ route('admin.city.store') }}" class="glass max-w-lg space-y-5 rounded-2xl p-6">
        @csrf
        <x-form.input name="name" label="Nom de la ville" />

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Enregistrer</button>
            <a href="{{ route('admin.city.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection