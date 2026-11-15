@extends('layouts.admin')
@section('title', 'Villes')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Villes</h1>
            <p class="text-sm text-slate-500">{{ $cities->total() }} ville(s)</p>
        </div>
        <a href="{{ route('admin.city.create') }}" class="btn-primary">+ Nouvelle ville</a>
    </div>

    <div class="glass overflow-x-auto rounded-2xl p-4">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500">
                    <th class="py-2">Nom</th>
                    <th>Médecins</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cities as $city)
                    <tr class="border-t border-white/70">
                        <td class="py-3 font-semibold">{{ $city->name }}</td>
                        <td>{{ $city->doctors_count }}</td>
                        <td class="py-2">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.city.show', $city) }}" class="btn-outline">Voir</a>
                                <a href="{{ route('admin.city.edit', $city) }}" class="btn-outline">Éditer</a>
                                <x-delete-button :action="route('admin.city.destroy', $city)"
                                                 message="Supprimer la ville {{ $city->name }} ?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-6 text-center text-slate-500">Aucune ville.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $cities->links() }}</div>
@endsection