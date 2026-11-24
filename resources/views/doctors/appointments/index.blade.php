{{-- resources/views/doctors/appointments/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Mes rendez-vous')
@section('content')
    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-widest text-teal-600">Espace médecin</p>
        <h1 class="text-2xl font-bold">Bonjour {{ $doctor->user->name }}</h1>
        <p class="text-slate-500">{{ ucfirst(now()->translatedFormat('l j F Y')) }}</p>
    </div>
    {{-- 3 compteurs --}}
    <div class="mb-8 grid gap-4 sm:grid-cols-3">
        @foreach ([['Demandes en attente', $pending->count(), 'from-amber-400 to-amber-600'],
                   ['Aujourd’hui', $today->count(), 'from-teal-400 to-teal-600'],
                   ['7 prochains jours', $week->count(), 'from-sky-400 to-sky-600']] as [$label, $value,
                       $color])
            <div data-tilt="8" class="glass rounded-2xl p-5">
                <p class="text-sm text-slate-500">{{ $label }}</p>
                <p class="mt-2 bg-gradient-to-br {{ $color }} bg-clip-text text-3xl font-bold
                    text-transparent">{{ $value }}</p>
            </div>
        @endforeach
    </div>
    <h2 class="mb-3 text-lg font-bold">Demandes en attente</h2>
    @forelse ($pending as $appointment)
        <div class="glass mb-3 flex flex-wrap items-center justify-between gap-3 rounded-2xl p-4">
            <div>
                <p class="font-semibold">{{ $appointment->patient->user->name }}</p>
                <p class="text-sm text-slate-500">{{ $appointment->date->format('d/m/Y') }} à {{
                    $appointment->hour() }} · {{ $appointment->reason }}</p>
            </div>
            <div class="flex gap-2">
                @foreach (['confirmed' => 'Confirmer', 'cancelled' => 'Refuser'] as $status => $label)
                    <form method="POST" action="{{ route('doctor.appointment.status', $appointment) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit" class="{{ $status === 'confirmed' ? 'btn-primary' : 'btn-danger'
                            }}">{{ $label }}</button>
                    </form>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-slate-500">Aucune demande en attente.</p>
    @endforelse
    <h2 class="mb-3 mt-8 text-lg font-bold">Aujourd’hui</h2>
    @forelse ($today as $appointment)
        <div class="glass mb-3 flex flex-wrap items-center justify-between gap-3 rounded-2xl p-4">
            <p><strong>{{ $appointment->hour() }}</strong> — {{ $appointment->patient->user->name }}
                <span class="text-slate-500">· {{ $appointment->reason }}</span></p>
            <div class="flex gap-2">
                <a href="{{ route('doctor.patient.record', $appointment->patient) }}"
                    class="btn-outline">Dossier</a>
                <a href="{{ route('doctor.consultation.create', $appointment) }}"
                    class="btn-primary">Consultation</a>
            </div>
        </div>
    @empty
        <p class="text-slate-500">Aucun rendez-vous confirmé aujourd’hui.</p>
    @endforelse
    <h2 class="mb-3 mt-8 text-lg font-bold">7 prochains jours</h2>
    <div class="glass rounded-2xl p-4">
        @forelse ($week as $appointment)
            <p class="flex justify-between border-b border-white/70 py-2 text-sm">
                <span>{{ $appointment->date->format('d/m/Y') }} à {{ $appointment->hour() }} — {{
                    $appointment->patient->user->name }}</span>
                <a href="{{ route('doctor.patient.record', $appointment->patient) }}" class="font-semibold
                    text-teal-700 hover:underline">Dossier</a>
            </p>
        @empty
            <p class="text-slate-500">Rien de prévu.</p>
        @endforelse
    </div>
@endsection