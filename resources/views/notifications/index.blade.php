{{-- Notifications d'un utilisateur --}}
@extends('layouts.admin')
@section('title', 'Notifications')
@section('content')
    <h1 class="mb-6 text-2xl font-bold">Notifications de {{ $user->name }}</h1>

    @if (session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <form method="POST" action="{{ route('notification.read', $user) }}" class="mb-4">
        @csrf
        <button type="submit" class="btn-outline">Tout marquer comme lu</button>
    </form>

    <div class="glass space-y-3 rounded-2xl p-6">
        @forelse ($notifications as $notification)
            <div class="flex items-center justify-between border-b border-white/40 pb-2">
                <p class="{{ $notification->is_read ? 'text-slate-500' : 'font-semibold' }}">
                    {{ $notification->message }}
                </p>
                <span class="text-sm text-slate-500">{{ $notification->created_at->format('d/m/Y H:i') }}</span>
            </div>
        @empty
            <p>Aucune notification.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $notifications->links() }}</div>
@endsection