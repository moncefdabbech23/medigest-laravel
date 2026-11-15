@extends('layouts.app')
@section('title', 'Nos médecins')

@section('content')
    <h1 class="text-3xl font-bold">Nos médecins</h1>
    <p class="text-slate-500">{{ $doctors->total() }} médecin(s) trouvé(s)</p>

    <form method="GET" action="{{ route('doctor.index') }}" class="glass mt-6 grid gap-3 rounded-2xl p-4 md:grid-cols-[1.5fr_1fr_1fr_auto_auto]">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom du médecin" aria-label="Nom">
        <select name="city" aria-label="Ville">
            <option value="">Toutes les villes</option>
            @foreach ($cities as $city)
                <option value="{{ $city->id }}" @selected(request('city') == $city->id)>{{ $city->name }}</option>
            @endforeach
        </select>
        <select name="specialty" aria-label="Spécialité">
            <option value="">Toutes les spécialités</option>
            @foreach ($specialties as $specialty)
                <option value="{{ $specialty->id }}" @selected(request('specialty') == $specialty->id)>{{ $specialty->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary">Filtrer</button>
        <a href="{{ route('doctor.index') }}" class="btn-outline">Effacer</a>
    </form>

    <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($doctors as $doctor)
            @include('partials.doctor-card', ['doctor' => $doctor])
        @empty
            <div class="glass col-span-full rounded-2xl p-10 text-center text-slate-500">
                Aucun médecin ne correspond à votre recherche.
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $doctors->links() }}</div>
@endsection