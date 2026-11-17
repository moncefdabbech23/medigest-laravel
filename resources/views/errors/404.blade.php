@extends('layouts.app')
@section('title', 'Page introuvable')

@section('content')
    <div class="glass-strong mx-auto max-w-xl rounded-[2rem] p-10 text-center">
        <p class="text-7xl">🔎</p>
        <h1 class="mt-4 text-3xl font-bold">Page introuvable</h1>
        <p class="mt-3 text-slate-600">Cette page n’existe pas ou a été déplacée.</p>
        <a href="{{ route('home') }}" class="btn-primary mt-8">Retour à l’accueil</a>
    </div>
@endsection