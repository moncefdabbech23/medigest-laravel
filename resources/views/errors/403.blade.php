@extends('layouts.app')
@section('title', 'Accès interdit')

@section('content')
    <div class="glass-strong mx-auto max-w-xl rounded-[2rem] p-10 text-center">
        <p class="text-7xl">⛔</p>
        <h1 class="mt-4 text-3xl font-bold">Accès interdit</h1>
        <p class="mt-3 text-slate-600">{{ $exception->getMessage() ?: 'Vous n’avez pas le droit d’ouvrir cette page.' }}</p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ route('home') }}" class="btn-primary">Retour à l’accueil</a>
            @guest
                <a href="{{ route('login') }}" class="btn-outline">Se connecter</a>
            @endguest
        </div>
    </div>
@endsection