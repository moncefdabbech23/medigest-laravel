@extends('layouts.admin')
@section('title', $specialty->name)

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold">{{ $specialty->icon }} {{ $specialty->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('specialty.show', $specialty) }}" class="btn-outline">Voir la page publique</a>
            <a href="{{ route('admin.specialty.edit', $specialty) }}" class="btn-outline">Éditer</a>
            <a href="{{ route('admin.specialty.index') }}" class="btn-outline">← Retour</a>
        </div>
    </div>

    <div class="glass rounded-2xl p-6">
        <h2 class="mb-3 font-bold">Médecins ({{ $specialty->doctors->count() }})</h2>
        @forelse ($specialty->doctors as $doctor)
            <div class="flex items-center justify-between border-b border-white/70 py-2">
                <p>
                    <strong>{{ $doctor->user->name }}</strong>
                    <span class="text-slate-500">· {{ $doctor->city->name }}</span>
                    @unless ($doctor->is_validated)
                        <span class="ml-2 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">En attente</span>
                    @endunless
                </p>
                <a href="{{ route('admin.doctor.show', $doctor) }}" class="text-sm font-semibold text-teal-700 hover:underline">Voir →</a>
            </div>
        @empty
            <p class="text-slate-500">Aucun médecin pour cette spécialité.</p>
        @endforelse
    </div>
@endsection