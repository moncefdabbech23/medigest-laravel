@extends('layouts.admin')
@section('title', 'Tableau de bord')

@section('content')
    <h1 class="text-2xl font-bold">Tableau de bord</h1>
    <p class="text-slate-500">Les statistiques arrivent à l’étape A12.</p>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        @foreach (['Patients', 'Médecins', 'Rendez-vous'] as $label)
            <div data-tilt="8" class="glass rounded-2xl p-5">
                <p class="text-sm text-slate-500">{{ $label }}</p>
                <p class="mt-3 text-3xl font-bold">0</p>
            </div>
        @endforeach
    </div>
@endsection