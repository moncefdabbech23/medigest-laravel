@extends('layouts.admin')
@section('title', $specialty->name)

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold">{{ $specialty->icon }} {{ $specialty->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.specialty.edit', $specialty) }}" class="btn-outline">Éditer</a>
            <a href="{{ route('admin.specialty.index') }}" class="btn-outline">← Retour</a>
        </div>
    </div>

    <div class="glass rounded-2xl p-6">
        <h2 class="mb-3 font-bold">Médecins ({{ $specialty->doctors->count() }})</h2>
        @forelse ($specialty->doctors as $doctor)
            <p class="border-b border-white/70 py-2">
                <strong>{{ $doctor->user->name }}</strong>
                <span class="text-slate-500">· {{ $doctor->city->name }}</span>
            </p>
        @empty
            <p class="text-slate-500">Aucun médecin pour cette spécialité.</p>
        @endforelse
    </div>
@endsection