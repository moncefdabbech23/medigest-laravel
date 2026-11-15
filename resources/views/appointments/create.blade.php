{{-- resources/views/appointments/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Prendre rendez-vous')
@section('content')
    <h1 class="text-2xl font-bold">Rendez-vous avec {{ $doctor->user->name }}</h1>
    <p class="text-slate-500">{{ $doctor->specialty->name }} · {{ $doctor->city->name }}</p>
    @if (session('success'))
        <x-alert class="mt-4">{{ session('success') }}</x-alert>
    @endif
    {{-- 1. Choisir le jour : le formulaire GET recharge la page avec ?date=... --}}
    <form method="GET" action="{{ route('appointment.create', $doctor) }}" class="glass mt-6 flex items-end
        gap-3 rounded-2xl p-4">
        <div>
            <label for="day">Jour</label>
            <input type="date" id="day" name="date" value="{{ $date }}" min="{{ now()->toDateString() }}">
        </div>
        <button type="submit" class="btn-primary">Voir les horaires</button>
    </form>
    {{-- 2. Choisir l'heure et envoyer la demande --}}
    <form method="POST" action="{{ route('appointment.store', $doctor) }}" class="glass mt-6 space-y-4
        rounded-2xl p-6">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        @if ($errors->any())
            <x-alert type="danger">
                @foreach ($errors->all() as $error) <p>{{ $error }}</p> @endforeach
            </x-alert>
        @endif
        <p class="font-semibold">Horaires du {{ \Illuminate\Support\Carbon::parse($date)->format('d/m/Y') }}</p>
        <div class="grid grid-cols-3 gap-2 md:grid-cols-6">
            @forelse ($slots as $slot)
                <label class="rounded-xl border p-2 text-center {{ $slot['free'] ? 'cursor-pointer' :
                    'opacity-40 line-through' }}">
                    <input type="radio" name="time" value="{{ $slot['time'] }}"
                           @disabled(! $slot['free']) @checked(old('time') === $slot['time'])>
                    {{ $slot['time'] }}
                </label>
            @empty
                <p class="col-span-full text-slate-500">Le médecin ne consulte pas ce jour-là. Choisissez un
                    autre jour.</p>
            @endforelse
        </div>
        {{-- Temporaire : choix du patient (sera le patient connecté en partie 3) --}}
        <div>
            <label for="patient_id">Patient</label>
            <select name="patient_id" id="patient_id">
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}" @selected(old('patient_id') == $patient->id)>{{
                        $patient->user->name }}</option>
                @endforeach
            </select>
        </div>
        <x-form.input name="reason" label="Motif de la consultation" />
        <button type="submit" class="btn-primary">Demander ce rendez-vous</button>
    </form>
@endsection
