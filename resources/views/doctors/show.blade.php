@extends('layouts.app')
@section('title', $doctor->user->name)

@section('content')
    <a href="{{ route('doctor.index') }}" class="text-sm font-semibold text-teal-700 hover:underline">← Tous les médecins</a>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_1fr]">
        <section data-tilt="4" class="glass rounded-3xl p-6">
            <div class="flex flex-wrap items-center gap-5">
                <span class="flex size-20 items-center justify-center rounded-3xl bg-gradient-to-br from-teal-400 to-sky-500 text-3xl font-bold text-white shadow-xl">
                    {{ mb_substr(str_replace('Dr ', '', $doctor->user->name), 0, 1) }}
                </span>
                <div>
                    <h1 class="text-2xl font-bold">{{ $doctor->user->name }}</h1>
                    <a href="{{ route('specialty.show', $doctor->specialty) }}" class="font-semibold text-teal-600 hover:underline">
                        {{ $doctor->specialty->icon }} {{ $doctor->specialty->name }}
                    </a>
                    <p class="text-sm text-slate-500">📍 {{ $doctor->office_address ?? $doctor->city->name }}</p>
                </div>
            </div>

            <p class="mt-5 border-t border-white/70 pt-5 leading-7 text-slate-600">
                {{ $doctor->description ?: 'Aucune présentation renseignée.' }}
            </p>

            <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                <p class="text-lg font-bold">{{ number_format($doctor->fee, 2, ',', ' ') }} DT <span class="text-sm font-normal text-slate-500">la consultation</span></p>
                @if (Route::has('appointment.create'))
                    <a href="{{ route('appointment.create', $doctor) }}" class="btn-primary">📅 Prendre rendez-vous</a>
                @endif
            </div>
        </section>

        <section class="glass rounded-3xl p-6">
            <h2 class="mb-4 font-bold">🕒 Horaires du cabinet</h2>
            @foreach ($doctor->availabilities as $availability)
                <p class="flex justify-between border-b border-white/70 py-2 text-sm">
                    <span class="font-semibold">{{ $availability->dayName() }}</span>
                    @if ($availability->is_active)
                        <span>{{ substr($availability->start_time, 0, 5) }} – {{ substr($availability->end_time, 0, 5) }}
                            <span class="text-xs text-slate-400">· {{ $availability->slot_duration }} min</span></span>
                    @else
                        <span class="text-slate-400">Fermé</span>
                    @endif
                </p>
            @endforeach
        </section>
    </div>
@endsection