@extends('layouts.admin')
@section('title', 'Nouveau médecin')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Nouveau médecin</h1>

    <form method="POST" action="{{ route('admin.doctor.store') }}" class="glass max-w-3xl space-y-5 rounded-2xl p-6">
        @csrf
        @include('admin.doctors._form')
        <p class="text-xs text-slate-500">Horaires créés par défaut : lundi à vendredi, 9 h – 17 h (modifiables à l’étape A10).</p>
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Enregistrer</button>
            <a href="{{ route('admin.doctor.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection