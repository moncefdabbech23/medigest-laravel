@extends('layouts.app')
@section('title', 'Accueil')

@section('content')
    <section class="grid items-center gap-12 py-6 lg:grid-cols-2">
        <div>
            <span class="glass inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold text-teal-700">
                <span class="size-2 animate-pulse rounded-full bg-teal-500"></span> La santé, simplement.
            </span>
            <h1 class="mt-6 text-4xl font-bold leading-tight tracking-tight sm:text-6xl">
                Votre santé mérite
                <span class="bg-gradient-to-r from-teal-500 via-sky-500 to-violet-500 bg-clip-text text-transparent">le meilleur</span>
                accompagnement.
            </h1>
            <p class="mt-6 max-w-lg text-lg text-slate-600">
                Trouvez un médecin de confiance, prenez rendez-vous en quelques clics et retrouvez votre dossier médical.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('doctor.index') }}" class="btn-primary">Trouver un médecin</a>
                <button type="button" class="btn-outline" onclick="document.getElementById('video').showModal()">▶ Voir la vidéo</button>
            </div>
        </div>

        <div class="scene relative flex min-h-[360px] items-center justify-center">
            <div class="absolute size-72 rounded-full bg-gradient-to-br from-teal-300/50 to-sky-300/40 blur-3xl"></div>
            <div class="cube">
                <div class="f1">❤️</div><div class="f2">📅</div><div class="f3">💊</div>
                <div class="f4">🩺</div><div class="f5">🧪</div><div class="f6">🩻</div>
            </div>
            <div class="float-y absolute left-[8%] top-[12%] flex h-10 w-24 overflow-hidden rounded-full shadow-xl" style="--r:-30deg">
                <span class="w-1/2 bg-gradient-to-b from-rose-300 to-rose-500"></span>
                <span class="w-1/2 bg-gradient-to-b from-white to-slate-200"></span>
            </div>
            <div class="float-y-slow absolute bottom-[10%] right-[10%] size-16 rounded-full bg-[radial-gradient(circle_at_30%_30%,#fff,#5eead4_45%,#0f766e)] shadow-2xl"></div>
            <div class="float-y glass absolute bottom-[14%] left-[12%] flex size-16 items-center justify-center rounded-2xl text-3xl font-bold text-teal-600" style="--r:12deg">✚</div>
        </div>
    </section>

    <form method="GET" action="{{ route('doctor.index') }}" class="glass-strong mt-10 grid gap-3 rounded-2xl p-4 md:grid-cols-[1.5fr_1fr_1fr_auto]">
        <input type="text" name="q" placeholder="Nom du médecin" aria-label="Nom du médecin">
        <select name="city" aria-label="Ville">
            <option value="">Toutes les villes</option>
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
        <select name="specialty" aria-label="Spécialité">
            <option value="">Toutes les spécialités</option>
            @foreach ($specialties as $specialty)
                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary">Rechercher</button>
    </form>

    <section id="fonctionnement" class="glass mt-16 rounded-[2rem] p-8 sm:p-12">
        <p class="text-sm font-bold uppercase tracking-widest text-teal-600">Simple et rapide</p>
        <h2 class="mt-2 text-3xl font-bold">Votre parcours santé en 3 étapes</h2>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach ([
                ['01', '🔎', 'Trouvez votre médecin', 'Par spécialité, ville ou nom, parmi des médecins vérifiés.'],
                ['02', '📅', 'Réservez en ligne', 'Choisissez un créneau libre, le médecin confirme.'],
                ['03', '📋', 'Suivez votre dossier', 'Ordonnances, analyses et radios au même endroit.'],
            ] as [$num, $icon, $title, $text])
                <div data-tilt="9" class="rounded-2xl border border-white/70 bg-white/50 p-6">
                    <div class="mb-5 flex items-center justify-between">
                        <span class="flex size-12 items-center justify-center rounded-2xl bg-gradient-to-br from-teal-400 to-teal-600 text-2xl shadow-lg shadow-teal-600/30">{{ $icon }}</span>
                        <span class="text-4xl font-bold text-teal-900/10">{{ $num }}</span>
                    </div>
                    <h3 class="text-lg font-bold">{{ $title }}</h3>
                    <p class="mt-2 text-sm text-slate-500">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-16">
        <p class="text-sm font-bold uppercase tracking-widest text-teal-600">Nos spécialités</p>
        <h2 class="mt-2 text-3xl font-bold">Trouvez le spécialiste qu’il vous faut</h2>
        <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4">
            @foreach ($specialties as $specialty)
                <a href="{{ route('specialty.show', $specialty) }}" data-tilt="10" class="glass rounded-2xl p-4 transition hover:shadow-xl">
                    <span class="text-3xl">{{ $specialty->icon }}</span>
                    <p class="mt-3 font-semibold">{{ $specialty->name }}</p>
                    <p class="text-xs text-slate-500">{{ $specialty->doctors_count }} médecin(s)</p>
                </a>
            @endforeach
        </div>
    </section>

    <section class="mt-16">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-teal-600">Professionnels de confiance</p>
                <h2 class="mt-2 text-3xl font-bold">Nos médecins</h2>
            </div>
            <a href="{{ route('doctor.index') }}" class="btn-outline">Voir tous les médecins →</a>
        </div>
        <div class="mt-8 grid gap-5 md:grid-cols-3">
            @forelse ($doctors as $doctor)
                @include('partials.doctor-card', ['doctor' => $doctor])
            @empty
                <p class="text-slate-500">Aucun médecin pour le moment.</p>
            @endforelse
        </div>
    </section>

    <dialog id="video" class="m-auto w-[min(92vw,800px)] rounded-3xl bg-transparent p-0">
        <div class="glass-strong rounded-3xl p-4">
            <video src="{{ asset('videos/presentation.mp4') }}" poster="{{ asset('images/poster-presentation.jpg') }}" controls class="w-full rounded-2xl"></video>
            <form method="dialog" class="mt-3 text-right"><button class="btn-outline">Fermer</button></form>
        </div>
    </dialog>
@endsection