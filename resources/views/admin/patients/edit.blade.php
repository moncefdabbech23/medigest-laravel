{{-- resources/views/admin/patients/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Modifier le patient')
@section('content')
    <h1 class="mb-6 text-2xl font-bold">Modifier : {{ $patient->user->name }}</h1>
    <form method="POST" action="{{ route('admin.patient.update', $patient) }}" class="glass space-y-4
        rounded-2xl p-6">
        @csrf
        @method('PUT')
        @include('admin.patients._form', ['patient' => $patient])
        <button type="submit" class="btn-primary">Mettre à jour</button>
    </form>
@endsection