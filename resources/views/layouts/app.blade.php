<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Accueil') · MediGest</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    @include('partials.background')
    @include('partials.navbar')

    <main class="mx-auto max-w-6xl px-5 py-10">
        @include('partials.flash')
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>