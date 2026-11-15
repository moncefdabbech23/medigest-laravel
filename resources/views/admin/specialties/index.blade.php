@extends('layouts.admin')
@section('title', 'Spécialités')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Spécialités</h1>
            <p class="text-sm text-slate-500">{{ $specialties->total() }} spécialité(s)</p>
        </div>
        <a href="{{ route('admin.specialty.create') }}" class="btn-primary">+ Nouvelle spécialité</a>
    </div>

    <div class="glass overflow-x-auto rounded-2xl p-4">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500">
                    <th class="py-2">Icône</th><th>Nom</th><th>Médecins</th><th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($specialties as $specialty)
                    <tr class="border-t border-white/70">
                        <td class="py-3 text-2xl">{{ $specialty->icon }}</td>
                        <td class="font-semibold">{{ $specialty->name }}</td>
                        <td>{{ $specialty->doctors_count }}</td>
                        <td class="py-2">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.specialty.show', $specialty) }}" class="btn-outline">Voir</a>
                                <a href="{{ route('admin.specialty.edit', $specialty) }}" class="btn-outline">Éditer</a>
                                <x-delete-button :action="route('admin.specialty.destroy', $specialty)"
                                                 message="Supprimer {{ $specialty->name }} ?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-6 text-center text-slate-500">Aucune spécialité.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $specialties->links() }}</div>
@endsection