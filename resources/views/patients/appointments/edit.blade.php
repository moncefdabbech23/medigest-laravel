{{-- resources/views/patients/appointments/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Reporter le rendez-vous')
@section('content')
    <h1 class="text-2xl font-bold">Reporter le rendez-vous</h1>
    <p class="text-slate-500">Actuellement : {{ $appointment->date->format('d/m/Y') }} à {{
        $appointment->hour() }}</p>
    <form method="GET" action="{{ route('appointment.edit', $appointment) }}" class="glass mt-6 flex items-end
        gap-3 rounded-2xl p-4">
        <div>
            <label for="day">Nouveau jour</label>
            <input type="date" id="day" name="date" value="{{ $date }}" min="{{ now()->toDateString() }}">
        </div>
        <button type="submit" class="btn-primary">Voir les horaires</button>
    </form>
    <form method="POST" action="{{ route('appointment.update', $appointment) }}" class="glass mt-6 space-y-4
        rounded-2xl p-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="date" value="{{ $date }}">
        @error('time') <x-alert type="danger">{{ $message }}</x-alert> @enderror
        <div class="grid grid-cols-3 gap-2 md:grid-cols-6">
            @forelse ($slots as $slot)
                <label class="rounded-xl border p-2 text-center {{ $slot['free'] ? '' : 'opacity-40
                    line-through' }}">
                    <input type="radio" name="time" value="{{ $slot['time'] }}" @disabled(! $slot['free'])>
                    {{ $slot['time'] }}
                </label>
            @empty
                <p class="col-span-full text-slate-500">Pas de consultation ce jour-là.</p>
            @endforelse
        </div>
        <button type="submit" class="btn-primary">Confirmer le report</button>
    </form>
@endsection