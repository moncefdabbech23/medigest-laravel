@extends('layouts.admin')
@section('title', 'Modifier la ville')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Modifier : {{ $city->name }}</h1>

    <form method="POST" action="{{ route('admin.city.update', $city) }}" class="glass max-w-lg space-y-5 rounded-2xl p-6">
        @csrf
        @method('PUT')
        <x-form.input name="name" label="Nom de la ville" :value="$city->name" />

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.city.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection