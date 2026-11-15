@extends('layouts.admin')
@section('title', $medication->name)

@section('content')
    <div class="glass max-w-lg rounded-2xl p-6">
        <h1 class="text-2xl font-bold">{{ $medication->name }}</h1>
        <p class="mt-2 text-slate-500">Forme : {{ $medication->form ?? '—' }}</p>
        <p class="text-slate-500">Ajouté le {{ $medication->created_at->format('d/m/Y') }}</p>
        <div class="mt-6 flex gap-2">
            <a href="{{ route('admin.medication.edit', $medication) }}" class="btn-outline">Éditer</a>
            <a href="{{ route('admin.medication.index') }}" class="btn-outline">← Retour</a>
        </div>
    </div>
@endsection
