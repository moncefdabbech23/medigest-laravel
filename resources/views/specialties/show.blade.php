@extends('layouts.app')
@section('title', $specialty->name)

@section('content')
    <a href="{{ route('home') }}" class="text-sm font-semibold text-teal-700 hover:underline">← Accueil</a>

    <div class="mt-6 flex items-center gap-4">
        <span class="glass flex size-16 items-center justify-center rounded-2xl text-4xl">{{ $specialty->icon }}</span>
        <div>
            <h1 class="text-3xl font-bold">{{ $specialty->name }}</h1>
            <p class="text-slate-500">{{ $doctors->total() }} médecin(s)</p>
        </div>
    </div>

    <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($doctors as $doctor)
            @include('partials.doctor-card', ['doctor' => $doctor])
        @empty
            <div class="glass col-span-full rounded-2xl p-10 text-center text-slate-500">Aucun médecin pour cette spécialité.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $doctors->links() }}</div>
@endsection