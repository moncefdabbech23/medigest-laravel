<footer class="no-print mt-20 bg-slate-950/90 px-5 py-10 text-slate-400">
    <div class="mx-auto flex max-w-6xl flex-col justify-between gap-6 sm:flex-row sm:items-center">
        <div>
            @include('partials.logo', ['dark' => true])
            <p class="mt-2 text-sm">Votre santé, notre priorité.</p>
        </div>
        <p class="text-xs">© {{ date('Y') }} MediGest · Projet Laravel</p>
    </div>
</footer>