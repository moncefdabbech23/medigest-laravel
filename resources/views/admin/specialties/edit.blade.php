@extends('layouts.admin')
@section('title', 'Modifier la spécialité')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Modifier : {{ $specialty->name }}</h1>

    <form method="POST" action="{{ route('admin.specialty.update', $specialty) }}" class="glass max-w-lg space-y-5 rounded-2xl p-6">
        @csrf
        @method('PUT')
        <x-form.input name="name" label="Nom" :value="$specialty->name" />
        <x-form.input name="icon" label="Icône (emoji)" :value="$specialty->icon" />
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.specialty.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection