{{-- resources/views/appointments/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Prendre rendez-vous')
@section('content')
    <a href="{{ route('doctor.show', $doctor) }}" class="text-sm font-semibold text-teal-700 hover:underline">←
        Fiche du médecin</a>
    <h1 class="mt-4 text-2xl font-bold">Rendez-vous avec {{ $doctor->user->name }}</h1>
    <p class="text-slate-500">{{ $doctor->specialty->name }} · {{ $doctor->city->name }} · {{
        number_format($doctor->fee, 0) }} DT</p>
    {{-- 1. Choisir le jour --}}
    <form method="GET" action="{{ route('appointment.create', $doctor) }}" class="glass mt-6 flex flex-wrap
        items-end gap-3 rounded-2xl p-4">
        <div>
            <label for="day">Jour</label>
            <input type="date" id="day" name="date" value="{{ $date }}" min="{{ now()->toDateString() }}">
        </div>
        <button type="submit" class="btn-primary">Voir les horaires</button>
    </form>
    {{-- 2. Choisir l'heure et envoyer --}}
    <form method="POST" action="{{ route('appointment.store', $doctor) }}" class="glass mt-6 space-y-5
        rounded-2xl p-6">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        <x-form.errors />
        <p class="font-semibold">Horaires du {{ \Illuminate\Support\Carbon::parse($date)->translatedFormat('l j
            F') }}</p>
        <div class="grid grid-cols-3 gap-2 sm:grid-cols-6">
            @forelse ($slots as $slot)
                <label class="!mb-0 cursor-pointer rounded-xl border border-white/70 bg-white/60 p-2
                    text-center has-[:checked]:border-teal-500 has-[:checked]:bg-teal-500
                    has-[:checked]:text-white {{ $slot['free'] ? '' : 'pointer-events-none opacity-40
                    line-through' }}">
                    <input type="radio" name="time" value="{{ $slot['time'] }}" class="sr-only"
                           @disabled(! $slot['free']) @checked(old('time') === $slot['time'])>
                    {{ $slot['time'] }}
                </label>
            @empty
                <p class="col-span-full text-slate-500">Le médecin ne consulte pas ce jour-là. Choisissez un
                    autre jour.</p>
            @endforelse
        </div>
        <x-form.input name="reason" label="Motif de la consultation" />
        <p class="text-sm text-slate-500">Rendez-vous au nom de <strong>{{ auth()->user()->name }}</strong>.</p>
        <button type="submit" class="btn-primary"> Demander ce rendez-vous</button>
    </form>
@endsection
