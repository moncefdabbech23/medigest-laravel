@extends('layouts.admin')
@section('title', $doctor->user->name)

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">{{ $doctor->user->name }}</h1>
            <p class="text-slate-500">{{ $doctor->specialty->icon }} {{ $doctor->specialty->name }} · {{ $doctor->city->name }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.doctor.edit', $doctor) }}" class="btn-outline">Éditer</a>
            <a href="{{ route('admin.doctor.index') }}" class="btn-outline">← Retour</a>
        </div>
    </div>
    <a href="{{ route('doctor.availability.edit', $doctor) }}" class="btn-outline">Modifier les horaires</a>

    <div class="grid gap-6 md:grid-cols-2">
        <div data-tilt="6" class="glass rounded-2xl p-6">
            <h2 class="mb-3 font-bold">Informations</h2>
            <p>Email : {{ $doctor->user->email }}</p>
            <p>Cabinet : {{ $doctor->office_address ?? '—' }}</p>
            <p>Tarif : {{ number_format($doctor->fee, 2, ',', ' ') }} DT</p>
            <p>Statut : <strong>{{ $doctor->is_validated ? 'Validé' : 'En attente de validation' }}</strong></p>
            <p class="mt-3 text-slate-600">{{ $doctor->description }}</p>
        </div>

        <div class="glass rounded-2xl p-6">
            <h2 class="mb-3 font-bold">Horaires</h2>
            @foreach ($doctor->availabilities as $availability)
                <p class="flex justify-between border-b border-white/70 py-1.5">
                    <span class="font-semibold">{{ $availability->dayName() }}</span>
                    <span class="{{ $availability->is_active ? '' : 'text-slate-400' }}">
                        {{ $availability->is_active ? substr($availability->start_time, 0, 5) . ' – ' . substr($availability->end_time, 0, 5) : 'Fermé' }}
                    </span>
                </p>
            @endforeach
        </div>
    </div>
@endsection