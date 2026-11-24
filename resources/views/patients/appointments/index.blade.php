{{-- resources/views/patients/appointments/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Mes rendez-vous')
@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Mes rendez-vous</h1>
            <p class="text-slate-500">{{ $patient->user->name }}</p>
        </div>
        <a href="{{ route('doctor.index') }}" class="btn-primary">+ Nouveau rendez-vous</a>
    </div>
    <h2 class="mb-3 text-lg font-bold">À venir</h2>
    @forelse ($upcoming as $appointment)
        <div data-tilt="4" class="glass mb-3 flex flex-wrap items-center justify-between gap-3 rounded-2xl p-4">
            <div>
                <p class="font-semibold">{{ $appointment->date->translatedFormat('l j F Y') }} à {{
                    $appointment->hour() }}</p>
                <p class="text-sm text-slate-500">{{ $appointment->doctor->user->name }} · {{
                    $appointment->doctor->specialty->name }}</p>
                <span class="mt-1 inline-block rounded-full px-2.5 py-0.5 text-xs font-semibold {{
                    $appointment->status === 'confirmed' ? 'bg-teal-100 text-teal-700' : 'bg-amber-100
                    text-amber-700' }}">
                    {{ $appointment->statusLabel() }}
                </span>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('my.appointment.edit', $appointment) }}" class="btn-outline">Reporter</a>
                <form method="POST" action="{{ route('my.appointment.cancel', $appointment) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-danger" onclick="return confirm('Annuler ce rendez-vous
                        ?')">Annuler</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-slate-500">Aucun rendez-vous à venir.</p>
    @endforelse
    <h2 class="mb-3 mt-8 text-lg font-bold">Historique</h2>
    <div class="glass rounded-2xl p-4">
        @forelse ($history as $appointment)
            <p class="flex justify-between border-b border-white/70 py-2 text-sm">
                <span>{{ $appointment->date->format('d/m/Y') }} à {{ $appointment->hour() }} — {{
                    $appointment->doctor->user->name }}</span>
                <span class="font-semibold">{{ $appointment->statusLabel() }}</span>
            </p>
        @empty
            <p class="text-slate-500">Aucun rendez-vous passé.</p>
        @endforelse
    </div>
@endsection
