{{-- resources/views/patients/appointments/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Reporter le rendez-vous')
@section('content')
    <h1 class="text-2xl font-bold">Reporter le rendez-vous</h1>
    <p class="text-slate-500">{{ $appointment->doctor->user->name }} · actuellement le {{
        $appointment->date->format('d/m/Y') }} à {{ $appointment->hour() }}</p>
    <form method="GET" action="{{ route('my.appointment.edit', $appointment) }}" class="glass mt-6 flex
        flex-wrap items-end gap-3 rounded-2xl p-4">
        <div>
            <label for="day">Nouveau jour</label>
            <input type="date" id="day" name="date" value="{{ $date }}" min="{{ now()->toDateString() }}">
        </div>
        <button type="submit" class="btn-primary">Voir les horaires</button>
    </form>
    <form method="POST" action="{{ route('my.appointment.update', $appointment) }}" class="glass mt-6 space-y-4
        rounded-2xl p-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="date" value="{{ $date }}">
        <x-form.errors />
        <div class="grid grid-cols-3 gap-2 sm:grid-cols-6">
            @forelse ($slots as $slot)
                <label class="!mb-0 cursor-pointer rounded-xl border border-white/70 bg-white/60 p-2
                    text-center has-[:checked]:border-teal-500 has-[:checked]:bg-teal-500
                    has-[:checked]:text-white {{ $slot['free'] ? '' : 'pointer-events-none opacity-40
                    line-through' }}">
                    <input type="radio" name="time" value="{{ $slot['time'] }}" class="sr-only" @disabled(!
                        $slot['free'])>
                    {{ $slot['time'] }}
                </label>
            @empty
                <p class="col-span-full text-slate-500">Pas de consultation ce jour-là.</p>
            @endforelse
        </div>
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Confirmer le report</button>
            <a href="{{ route('my.appointment.index') }}" class="btn-outline">Retour</a>
        </div>
    </form>
@endsection
