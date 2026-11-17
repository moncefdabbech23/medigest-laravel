{{-- Menu latéral : une section selon le rôle. Un lien n'apparaît que si sa route existe. --}}
@php
    $user = auth()->user();
    $params = ['doctor' => $user->doctor?->id, 'patient' => $user->patient?->id, 'user' => $user->id];

    $sections = match ($user->role) {
        'admin' => ['Administration' => [
            [['admin.dashboard'], 'Tableau de bord', '▦'],
            [['admin.doctor.index'], 'Médecins', '⚕'],
            [['admin.patient.index'], 'Patients', '☺'],
            [['admin.city.index'], 'Villes', '⌂'],
            [['admin.specialty.index'], 'Spécialités', '✚'],
            [['admin.medication.index'], 'Médicaments', '℞'],
        ]],
        'doctor' => ['Espace médecin' => [
            [['doctor.appointment.index'], 'Mes rendez-vous', '📅'],
            [['doctor.availability.edit'], 'Mes horaires', '🕒'],
            [['doctor.profile.edit'], 'Mon profil', '👤'],
        ]],
        default => ['Espace patient' => [
            [['my.appointment.index', 'patient.appointment.index'], 'Mes rendez-vous', '📅'],
            [['doctor.index'], 'Prendre rendez-vous', '➕'],
            [['my.record', 'patient.record'], 'Mon dossier médical', '📋'],
            [['my.profile.edit'], 'Mon profil', '👤'],
        ]],
    };
    $sections['Compte'] = [
        [['notification.index'], 'Notifications', '🔔'],
        [['home'], 'Retour au site', '←'],
    ];

    $link = function (array $names) use ($params) {
        foreach ($names as $name) {
            if (Route::has($name)) {
                $needed = Route::getRoutes()->getByName($name)->parameterNames();
                return [$name, route($name, array_intersect_key($params, array_flip($needed)))];
            }
        }
        return [null, null];
    };
@endphp

<div class="glass-strong flex h-full flex-col overflow-y-auto rounded-3xl p-5">
    @include('partials.logo')

    @foreach ($sections as $title => $items)
        <p class="mt-7 text-[11px] font-bold uppercase tracking-widest text-teal-600">{{ $title }}</p>
        <nav class="mt-2 flex flex-col gap-1">
            @foreach ($items as [$names, $label, $icon])
                @php([$name, $url] = $link($names))
                @if ($url)
                    @php($active = request()->routeIs($name) || request()->routeIs(str_replace('.index', '.*', $name)))
                    <a href="{{ $url }}"
                       class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ $active ? 'bg-gradient-to-r from-teal-500/15 to-transparent text-teal-700 shadow-[inset_3px_0_0_#0d9488]' : 'text-slate-500 hover:bg-white/70 hover:text-slate-800' }}">
                        <span class="w-5 text-center">{{ $icon }}</span> {{ $label }}
                    </a>
                @endif
            @endforeach
        </nav>
    @endforeach

    <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-6">
        @csrf
        <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50">
            <span class="w-5 text-center">⎋</span> Déconnexion
        </button>
    </form>
</div>