@extends('layouts.admin')
@section('title', 'Tableau de bord')

@section('content')
    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-widest text-teal-600">Administration</p>
        <h1 class="text-2xl font-bold">Vue d’ensemble</h1>
        <p class="text-slate-500">{{ ucfirst(now()->translatedFormat('l j F Y')) }}</p>
    </div>

    {{-- 1. Chiffres clés : cartes 3D --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['Patients inscrits', $stats['patients'], '☺', 'from-teal-400 to-teal-600', route('admin.patient.index')],
            ['Médecins actifs', $stats['doctors'], '⚕', 'from-sky-400 to-sky-600', route('admin.doctor.index', ['status' => 'validated'])],
            ['Rendez-vous ce mois', $stats['appointmentsMonth'], '📅', 'from-violet-400 to-violet-600', null],
            ['Médecins à valider', $stats['pendingDoctors'], '⏳', 'from-amber-400 to-amber-600', route('admin.doctor.index', ['status' => 'pending'])],
        ] as [$label, $value, $icon, $color, $link])
            <a @if ($link) href="{{ $link }}" @endif data-tilt="8" class="glass block rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-500">{{ $label }}</p>
                    <span class="flex size-10 items-center justify-center rounded-xl bg-gradient-to-br {{ $color }} text-lg text-white shadow-lg">{{ $icon }}</span>
                </div>
                <p class="mt-3 text-3xl font-bold">{{ $value }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1.4fr_1fr]">
        {{-- 2. Graphique en barres (CSS, sans librairie) --}}
        <section class="glass rounded-2xl p-6">
            <h2 class="font-bold">Rendez-vous par mois</h2>
            <p class="text-xs text-slate-500">Les 6 derniers mois</p>
            <div class="mt-6 flex h-48 items-end gap-3">
                @foreach ($months as $month)
                    <div class="flex flex-1 flex-col items-center gap-2">
                        <span class="text-xs font-semibold text-slate-600">{{ $month['total'] }}</span>
                        <div class="w-full rounded-t-xl bg-gradient-to-t from-teal-600 to-teal-300 shadow-lg shadow-teal-600/20"
                             style="height: {{ max(4, $month['total'] / $maxMonth * 140) }}px"></div>
                        <span class="text-xs text-slate-500">{{ $month['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- 3. Répartition par statut --}}
        <section class="glass rounded-2xl p-6">
            <h2 class="mb-4 font-bold">Statut des rendez-vous</h2>
            @php
                $statuses = [
                    'pending' => ['En attente', 'bg-amber-400'],
                    'confirmed' => ['Confirmés', 'bg-teal-500'],
                    'done' => ['Terminés', 'bg-sky-500'],
                    'cancelled' => ['Annulés', 'bg-rose-400'],
                ];
                $totalStatus = max(1, $byStatus->sum());
            @endphp
            @foreach ($statuses as $key => [$label, $color])
                @php($count = $byStatus[$key] ?? 0)
                <div class="mb-3">
                    <div class="mb-1 flex justify-between text-sm">
                        <span>{{ $label }}</span>
                        <span class="font-semibold">{{ $count }}</span>
                    </div>
                    <div class="h-2.5 overflow-hidden rounded-full bg-white/70">
                        <div class="h-full rounded-full {{ $color }}" style="width: {{ $count / $totalStatus * 100 }}%"></div>
                    </div>
                </div>
            @endforeach
        </section>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        {{-- 4. Médecins les plus demandés --}}
        <section class="glass rounded-2xl p-6">
            <h2 class="mb-4 font-bold">Médecins les plus demandés</h2>
            @forelse ($topDoctors as $i => $doctor)
                <div class="flex items-center justify-between border-b border-white/70 py-2.5">
                    <div class="flex items-center gap-3">
                        <span class="flex size-8 items-center justify-center rounded-lg bg-teal-500/10 text-sm font-bold text-teal-700">{{ $i + 1 }}</span>
                        <div>
                            <p class="font-semibold">{{ $doctor->user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $doctor->specialty->name }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold">{{ $doctor->appointments_count }} RDV</span>
                </div>
            @empty
                <p class="text-slate-500">Aucun médecin.</p>
            @endforelse
        </section>

        {{-- 5. Derniers rendez-vous --}}
        <section class="glass rounded-2xl p-6">
            <h2 class="mb-4 font-bold">Derniers rendez-vous</h2>
            @forelse ($latestAppointments as $appointment)
                <div class="flex items-center justify-between border-b border-white/70 py-2.5 text-sm">
                    <div>
                        <p class="font-semibold">{{ $appointment->patient->user->name }}</p>
                        <p class="text-xs text-slate-500">
                            {{ $appointment->doctor->user->name }} · {{ $appointment->date->format('d/m/Y') }} à {{ $appointment->hour() }}
                        </p>
                    </div>
                    <span class="rounded-full bg-white/80 px-2.5 py-1 text-xs font-semibold">{{ $appointment->statusLabel() }}</span>
                </div>
            @empty
                <p class="text-slate-500">Aucun rendez-vous pour le moment.</p>
            @endforelse
        </section>
    </div>
@endsection