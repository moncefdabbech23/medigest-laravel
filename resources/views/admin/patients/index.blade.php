{{-- resources/views/admin/patients/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Patients')
@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold">Patients</h1>
        <a href="{{ route('admin.patient.create') }}" class="btn-primary">Nouveau patient</a>
    </div>
    <div class="glass rounded-2xl p-4">
        <table class="w-full text-sm">
            <tr class="text-left text-slate-500">
                <th class="py-2">Nom</th><th>Email</th><th>Groupe</th><th>Allergies</th><th>Actions</th>
            </tr>
            @forelse ($patients as $patient)
                <tr class="border-t border-white/70">
                    <td class="py-2 font-semibold">{{ $patient->user->name }}</td>
                    <td>{{ $patient->user->email }}</td>
                    <td>{{ $patient->blood_type ?? '—' }}</td>
                    <td>{{ $patient->allergies ?: 'Aucune' }}</td>
                    <td class="flex gap-2 py-2">
                        <a href="{{ route('admin.patient.show', $patient) }}">Voir</a>
                        <a href="{{ route('admin.patient.edit', $patient) }}">Éditer</a>
                        <x-delete-button :action="route('admin.patient.destroy', $patient)" />
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-4 text-slate-500">Aucun patient.</td></tr>
            @endforelse
        </table>
    </div>
    <div class="mt-4">{{ $patients->links() }}</div>
@endsection