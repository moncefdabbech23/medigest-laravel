{{-- resources/views/patients/appointments/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Mes rendez-vous')
@section('content')
    <h1 class="text-2xl font-bold">Mes rendez-vous</h1>
    <p class="text-slate-500">{{ $patient->user->name }}</p>
    <h2 class="mt-6 mb-3 text-lg font-bold">À venir</h2>
    @forelse ($upcoming as $appointment)
        <div class="glass mb-3 flex flex-wrap items-center justify-between gap-3 rounded-2xl p-4">
            <div>
                <p class="font-semibold">{{ $appointment->date->format('d/m/Y') }} à {{ $appointment->hour()
                    }}</p>
                <p class="text-sm text-slate-500">{{ $appointment->doctor->user->name }} · {{
                    $appointment->doctor->specialty->name }}</p>
                <p class="text-sm">{{ $appointment->statusLabel() }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('appointment.edit', $appointment) }}" class="btn-outline">Reporter</a>
                <form method="POST" action="{{ route('appointment.cancel', $appointment) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" onclick="return confirm('Annuler ce rendez-vous ?')">Annuler</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-slate-500">Aucun rendez-vous à venir.</p>
    @endforelse
    <h2 class="mt-8 mb-3 text-lg font-bold">Historique</h2>
    @forelse ($history as $appointment)
        <p class="border-b border-white/70 py-2">
            {{ $appointment->date->format('d/m/Y') }} à {{ $appointment->hour() }}
            — {{ $appointment->doctor->user->name }} — {{ $appointment->statusLabel() }}
        </p>
    @empty
        <p class="text-slate-500">Aucun rendez-vous passé.</p>
    @endforelse
@endsection
