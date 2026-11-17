@extends('layouts.admin')
@section('title', 'Mes horaires')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Mes horaires</h1>
        <p class="text-slate-500">{{ $doctor->user->name }} · {{ $doctor->specialty->name }}</p>
    </div>

    <form method="POST" action="{{ route('doctor.availability.update') }}" class="glass space-y-4 rounded-2xl p-6">
        @csrf
        @method('PUT')

        <x-form.errors />

        <div class="hidden grid-cols-[140px_1fr_1fr_1fr] gap-4 px-2 text-xs font-bold uppercase tracking-wider text-slate-400 md:grid">
            <span>Jour</span><span>Début</span><span>Fin</span><span>Durée d’un créneau</span>
        </div>

        @foreach ($availabilities as $day => $availability)
            @php
                $active = old("availabilities.$day.is_active", $availability->is_active);
                $start = old("availabilities.$day.start_time", substr($availability->start_time ?? '09:00', 0, 5));
                $end = old("availabilities.$day.end_time", substr($availability->end_time ?? '17:00', 0, 5));
                $duration = old("availabilities.$day.slot_duration", $availability->slot_duration ?? 30);
            @endphp

            <div class="grid items-center gap-3 rounded-xl border border-white/70 bg-white/40 p-3 md:grid-cols-[140px_1fr_1fr_1fr]">
                <label class="!mb-0 flex items-center gap-2">
                    <input type="hidden" name="availabilities[{{ $day }}][is_active]" value="0">
                    <input type="checkbox" name="availabilities[{{ $day }}][is_active]" value="1" @checked($active)>
                    {{ \App\Models\Availability::DAYS[$day] }}
                </label>
                <input type="time" name="availabilities[{{ $day }}][start_time]" value="{{ $start }}" aria-label="Début">
                <input type="time" name="availabilities[{{ $day }}][end_time]" value="{{ $end }}" aria-label="Fin">
                <select name="availabilities[{{ $day }}][slot_duration]" aria-label="Durée">
                    @foreach ($durations as $minutes)
                        <option value="{{ $minutes }}" @selected($duration == $minutes)>{{ $minutes }} min</option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <p class="text-xs text-slate-500">Décochez un jour pour le fermer. Les patients ne pourront réserver que les jours cochés.</p>
        <button type="submit" class="btn-primary">Enregistrer mes horaires</button>
    </form>
@endsection