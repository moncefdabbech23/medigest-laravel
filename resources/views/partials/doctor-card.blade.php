<a href="{{ route('doctor.show', $doctor) }}" data-tilt="8" class="glass block rounded-2xl p-5 transition hover:shadow-2xl">
    <div class="flex items-center gap-4">
        <span class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-teal-400 to-sky-500 text-xl font-bold text-white shadow-lg">
            {{ mb_substr(str_replace('Dr ', '', $doctor->user->name), 0, 1) }}
        </span>
        <div class="min-w-0">
            <h3 class="truncate font-bold">{{ $doctor->user->name }}</h3>
            <p class="text-sm text-teal-600">{{ $doctor->specialty->icon }} {{ $doctor->specialty->name }}</p>
            <p class="text-xs text-slate-500">📍 {{ $doctor->city->name }}</p>
        </div>
    </div>
    <div class="mt-4 flex items-center justify-between border-t border-white/70 pt-3 text-sm">
        <span class="font-semibold">{{ number_format($doctor->fee, 0) }} DT</span>
        <span class="font-semibold text-teal-700">Voir la fiche →</span>
    </div>
</a>