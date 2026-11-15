@extends('layouts.admin')
@section('title', 'Médecins')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Médecins</h1>
            <p class="text-sm text-slate-500">{{ $doctors->total() }} médecin(s)</p>
        </div>
        <a href="{{ route('admin.doctor.create') }}" class="btn-primary">+ Nouveau médecin</a>
    </div>

    {{-- Filtre --}}
    <div class="mb-4 flex flex-wrap gap-2">
        @foreach ([null => 'Tous', 'validated' => 'Validés', 'pending' => 'En attente (' . $pendingCount . ')'] as $value => $label)
            <a href="{{ route('admin.doctor.index', $value ? ['status' => $value] : []) }}"
               class="{{ $status == $value ? 'btn-primary' : 'btn-outline' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="glass overflow-x-auto rounded-2xl p-4">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500">
                    <th class="py-2">Médecin</th><th>Spécialité</th><th>Ville</th><th>Tarif</th><th>Statut</th><th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($doctors as $doctor)
                    <tr class="border-t border-white/70">
                        <td class="py-3">
                            <p class="font-semibold">{{ $doctor->user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $doctor->user->email }}</p>
                        </td>
                        <td>{{ $doctor->specialty->icon }} {{ $doctor->specialty->name }}</td>
                        <td>{{ $doctor->city->name }}</td>
                        <td>{{ number_format($doctor->fee, 2, ',', ' ') }} DT</td>
                        <td>
                            @if ($doctor->is_validated)
                                <span class="rounded-full bg-teal-100 px-2.5 py-1 text-xs font-semibold text-teal-700">Validé</span>
                            @else
                                <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">En attente</span>
                            @endif
                        </td>
                        <td class="py-2">
                            <div class="flex justify-end gap-2">
                                <form method="POST" action="{{ route('admin.doctor.validate', $doctor) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="{{ $doctor->is_validated ? 'btn-outline' : 'btn-primary' }}">
                                        {{ $doctor->is_validated ? 'Suspendre' : 'Valider' }}
                                    </button>
                                </form>
                                <a href="{{ route('admin.doctor.show', $doctor) }}" class="btn-outline">Voir</a>
                                <a href="{{ route('admin.doctor.edit', $doctor) }}" class="btn-outline">Éditer</a>
                                <x-delete-button :action="route('admin.doctor.destroy', $doctor)"
                                                 message="Supprimer {{ $doctor->user->name }} et son compte ?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-6 text-center text-slate-500">Aucun médecin.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $doctors->links() }}</div>
@endsection