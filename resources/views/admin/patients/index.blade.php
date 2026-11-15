{{-- resources/views/admin/patients/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Patients')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Patients</h1>
            <p class="text-sm text-slate-500">{{ $patients->total() }} patient(s)</p>
        </div>
        <a href="{{ route('admin.patient.create') }}" class="btn-primary">+ Nouveau patient</a>
    </div>

    <div class="glass overflow-x-auto rounded-2xl p-4">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500">
                    <th class="py-2">Nom</th>
                    <th>Email</th>
                    <th>Groupe</th>
                    <th>Allergies</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $patient)
                    <tr class="border-t border-white/70">
                        <td class="py-3 font-semibold">{{ $patient->user->name }}</td>
                        <td>{{ $patient->user->email }}</td>
                        <td>
                            @if ($patient->blood_type)
                                <span class="rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">{{ $patient->blood_type }}</span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="{{ $patient->allergies ? 'text-rose-600' : 'text-slate-400' }}">
                            {{ $patient->allergies ?: 'Aucune' }}
                        </td>
                        <td class="py-2">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.patient.show', $patient) }}" class="btn-outline">Voir</a>
                                <a href="{{ route('admin.patient.edit', $patient) }}" class="btn-outline">Éditer</a>
                                <x-delete-button :action="route('admin.patient.destroy', $patient)"
                                                 message="Supprimer {{ $patient->user->name }} et son compte ?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-slate-500">Aucun patient.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $patients->links() }}</div>
@endsection