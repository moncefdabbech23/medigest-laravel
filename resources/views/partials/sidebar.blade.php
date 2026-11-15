{{-- Un lien n'apparaît que si sa route existe : le menu se complète au fil des étapes --}}
@php
    $sections = [
        'Administration' => [
            ['admin.dashboard', 'Tableau de bord', '▦'],
            ['admin.doctor.index', 'Médecins', '⚕'],
            ['admin.patient.index', 'Patients', '☺'],
            ['admin.city.index', 'Villes', '⌂'],
            ['admin.specialty.index', 'Spécialités', '✚'],
            ['admin.medication.index', 'Médicaments', '℞'],
        ],
        'Site' => [
            ['home', 'Retour au site', '←'],
        ],
    ];
@endphp

<div class="glass-strong flex h-full flex-col rounded-3xl p-5">
    @include('partials.logo')
    @foreach ($sections as $title => $links)
        <p class="mt-7 text-[11px] font-bold uppercase tracking-widest text-teal-600">{{ $title }}</p>
        <nav class="mt-2 flex flex-col gap-1">
            @foreach ($links as [$name, $label, $icon])
                @if (Route::has($name))
                    @php($active = request()->routeIs($name) || request()->routeIs(str_replace('.index', '.*', $name)))
                    <a href="{{ route($name) }}"
                       class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ $active ? 'bg-gradient-to-r from-teal-500/15 to-transparent text-teal-700 shadow-[inset_3px_0_0_#0d9488]' : 'text-slate-500 hover:bg-white/70 hover:text-slate-800' }}">
                        <span class="w-5 text-center">{{ $icon }}</span> {{ $label }}
                    </a>
                @endif
            @endforeach
        </nav>
    @endforeach
    <p class="mt-auto pt-6 text-xs text-slate-400">Mode démo : la connexion arrive en partie 3.</p>
</div>