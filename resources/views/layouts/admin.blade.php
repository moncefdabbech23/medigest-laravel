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
        <header class="glass no-print sticky top-3 z-20 mx-3 mt-3 flex items-center justify-between gap-3 rounded-2xl px-5 py-3 lg:mx-4">
            <button type="button" data-drawer-toggle class="btn-outline lg:hidden">☰</button>
            <p class="text-sm text-slate-500">@yield('title', 'Espace')</p>
            @yield('header-actions')
        </header>

        <main class="mx-auto max-w-6xl px-5 py-8">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
</body>
</html>