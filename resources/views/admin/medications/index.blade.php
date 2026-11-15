@extends('layouts.admin')
@section('title', 'Médicaments')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Médicaments</h1>
            <p class="text-sm text-slate-500">{{ $medications->total() }} médicament(s)</p>
        </div>
        <a href="{{ route('admin.medication.create') }}" class="btn-primary">+ Nouveau médicament</a>
    </div>

    <div class="glass overflow-x-auto rounded-2xl p-4">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500">
                    <th class="py-2">Nom</th><th>Forme</th><th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medications as $medication)
                    <tr class="border-t border-white/70">
                        <td class="py-3 font-semibold">{{ $medication->name }}</td>
                        <td>{{ $medication->form ?? '—' }}</td>
                        <td class="py-2">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.medication.show', $medication) }}" class="btn-outline">Voir</a>
                                <a href="{{ route('admin.medication.edit', $medication) }}" class="btn-outline">Éditer</a>
                                <x-delete-button :action="route('admin.medication.destroy', $medication)"
                                                 message="Supprimer {{ $medication->name }} ?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-6 text-center text-slate-500">Aucun médicament.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $medications->links() }}</div>
@endsection