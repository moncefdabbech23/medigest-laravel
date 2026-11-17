<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Espace') · MediGest</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    @include('partials.background')

    <aside class="no-print fixed inset-y-3 left-3 z-30 hidden w-60 lg:block">
        @include('partials.sidebar')
    </aside>

    <div id="drawer" class="no-print fixed inset-0 z-40 hidden lg:hidden">
        <div class="absolute inset-0 bg-slate-950/40" data-drawer-toggle></div>
        <aside class="absolute inset-y-3 left-3 w-64">@include('partials.sidebar')</aside>
    </div>

    <div class="lg:pl-[16.5rem]">
        <header class="glass no-print sticky top-3 z-20 mx-3 mt-3 flex items-center justify-between gap-3 rounded-2xl px-4 py-3 lg:mx-4">
    <div class="flex items-center gap-3">
        <button type="button" data-drawer-toggle class="btn-outline !px-3 lg:hidden" aria-label="Ouvrir le menu">☰</button>
        <p class="hidden text-sm text-slate-500 sm:block">@yield('title', 'Espace')</p>
    </div>

    <div class="flex items-center gap-3">
        @yield('header-actions')

        {{-- Cloche : fichier créé par la personne B (B17) --}}
        @includeIf('partials.notification-bell')

        <div class="flex items-center gap-2.5 rounded-xl border border-white/70 bg-white/60 py-1.5 pl-1.5 pr-3">
            @if (auth()->user()->avatar ?? null)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="" class="size-8 rounded-lg object-cover">
            @else
                <span class="flex size-8 items-center justify-center rounded-lg bg-gradient-to-br from-teal-400 to-sky-500 text-sm font-bold text-white">
                    {{ mb_substr(str_replace('Dr ', '', auth()->user()->name), 0, 1) }}
                </span>
            @endif
            <div class="hidden leading-tight sm:block">
                <p class="max-w-40 truncate text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                <p class="text-[11px] text-slate-500">{{ auth()->user()->roleLabel() }}</p>
            </div>
        </div>
    </div>
</header>

        <main class="mx-auto max-w-6xl px-5 py-8">
            @include('partials.flash')
            @if (auth()->user()->role === 'doctor' && ! auth()->user()->doctor?->is_validated)
    <x-alert type="warning" class="mb-6">
        ⏳ Votre compte attend la validation de l’administrateur : vous n’apparaissez pas encore dans l’annuaire.
    </x-alert>
@endif
            @yield('content')
        </main>
    </div>
</body>
</html>