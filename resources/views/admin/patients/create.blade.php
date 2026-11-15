{{-- resources/views/admin/patients/create.blade.php --}}
@extends('layouts.admin')
@section('title', 'Nouveau patient')
@section('content')
    <h1 class="mb-6 text-2xl font-bold">Nouveau patient</h1>
    <form method="POST" action="{{ route('admin.patient.store') }}" class="glass space-y-4 rounded-2xl p-6">
        @csrf
        @include('admin.patients._form')
        <button type="submit" class="btn-primary">Enregistrer</button>
    </form>
@endsection