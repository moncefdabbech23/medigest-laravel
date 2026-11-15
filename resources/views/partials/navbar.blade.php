<nav class="glass no-print sticky top-3 z-30 mx-3 mt-3 rounded-2xl sm:mx-auto sm:max-w-6xl">
    <div class="flex items-center justify-between px-5 py-3">
        @include('partials.logo')
        <div class="hidden items-center gap-7 text-sm font-medium text-slate-600 md:flex">
            <a href="{{ route('home') }}" class="hover:text-teal-600">Accueil</a>
            <a href="{{ route('home') }}#fonctionnement" class="hover:text-teal-600">Comment ça marche</a>
            @if (Route::has('doctor.index'))
                <a href="{{ route('doctor.index') }}" class="hover:text-teal-600">Nos médecins</a>
            @endif
            @if (Route::has('admin.dashboard'))
                <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600">Administration</a>
            @endif
        </div>
        <a href="{{ Route::has('doctor.index') ? route('doctor.index') : route('home') }}" class="btn-primary">Prendre rendez-vous</a>
    </div>
</nav>
