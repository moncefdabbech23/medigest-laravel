@props(['type' => 'success'])

@php
    $styles = [
        'success' => 'border-l-teal-500 text-teal-800',
        'danger'  => 'border-l-rose-500 text-rose-800',
        'warning' => 'border-l-amber-500 text-amber-800',
        'info'    => 'border-l-sky-500 text-sky-800',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'glass rounded-xl border-l-4 px-4 py-3 text-sm font-semibold ' . ($styles[$type] ?? $styles['info'])]) }}>
    {{ $slot }}
</div>