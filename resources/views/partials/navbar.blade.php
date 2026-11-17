<nav class="glass no-print sticky top-3 z-30 mx-3 mt-3 rounded-2xl sm:mx-auto sm:max-w-6xl">
    <div class="flex items-center justify-between gap-3 px-5 py-3">
        @include('partials.logo')

        <div class="hidden items-center gap-7 text-sm font-medium text-slate-600 md:flex">
            <a href="{{ route('home') }}" class="hover:text-teal-600">Accueil</a>
            <a href="{{ route('home') }}#fonctionnement" class="hover:text-teal-600">Comment ça marche</a>
            <a href="{{ route('doctor.index') }}" class="hover:text-teal-600">Nos médecins</a>
        </div>

        <div class="flex items-center gap-2">
            @auth
                <a href="{{ auth()->user()->homeUrl() }}" class="btn-primary">
                    Mon espace <span class="hidden sm:inline">· {{ auth()->user()->roleLabel() }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-outline" title="Déconnexion">⎋</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-outline">Se connecter</a>
                <a href="{{ route('register') }}" class="btn-primary hidden sm:inline-flex">Créer un compte</a>
            @endauth
        </div>
    </div>
</nav>