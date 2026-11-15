@extends('layouts.admin')
@section('title', 'Modifier le médecin')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Modifier : {{ $doctor->user->name }}</h1>

    <form method="POST" action="{{ route('admin.doctor.update', $doctor) }}" class="glass max-w-3xl space-y-5 rounded-2xl p-6">
        @csrf
        @method('PUT')
        @include('admin.doctors._form', ['doctor' => $doctor])
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.doctor.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
