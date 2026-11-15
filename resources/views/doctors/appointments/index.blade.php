{{-- resources/views/doctors/appointments/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Mes rendez-vous')
@section('content')
    <h1 class="text-2xl font-bold">Rendez-vous de {{ $doctor->user->name }}</h1>
    <h2 class="mt-6 mb-3 text-lg font-bold">Demandes en attente ({{ $pending->count() }})</h2>
    @forelse ($pending as $appointment)
        <div class="glass mb-3 flex flex-wrap items-center justify-between gap-3 rounded-2xl p-4">
            <div>
                <p class="font-semibold">{{ $appointment->patient->user->name }}</p>
                <p class="text-sm text-slate-500">{{ $appointment->date->format('d/m/Y') }} à {{
                    $appointment->hour() }} · {{ $appointment->reason }}</p>
            </div>
            <div class="flex gap-2">
                @foreach (['confirmed' => 'Confirmer', 'cancelled' => 'Refuser'] as $status => $label)
                    <form method="POST" action="{{ route('appointment.status', $appointment) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit" class="{{ $status === 'confirmed' ? 'btn-primary' : 'btn-outline'
                            }}">{{ $label }}</button>
                    </form>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-slate-500">Aucune demande en attente.</p>
    @endforelse
    <h2 class="mt-8 mb-3 text-lg font-bold">Aujourd’hui</h2>
    @forelse ($today as $appointment)
        <div class="glass mb-3 flex items-center justify-between rounded-2xl p-4">
            <p><strong>{{ $appointment->hour() }}</strong> — {{ $appointment->patient->user->name }} · {{
                $appointment->reason }}</p>
            @if (Route::has('consultation.create')) {{-- bouton actif après l'étape B10 --}}
                <a href="{{ route('consultation.create', $appointment) }}" class="btn-primary">Consultation</a>
            @endif
        </div>
    @empty
        <p class="text-slate-500">Aucun rendez-vous confirmé aujourd’hui.</p>
    @endforelse
    <h2 class="mt-8 mb-3 text-lg font-bold">7 prochains jours</h2>
    @forelse ($week as $appointment)
        <p class="border-b border-white/70 py-2">{{ $appointment->date->format('d/m/Y') }} à {{
            $appointment->hour() }} — {{ $appointment->patient->user->name }}</p>
    @empty
        <p class="text-slate-500">Rien de prévu.</p>
    @endforelse
@endsection