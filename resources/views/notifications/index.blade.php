{{-- resources/views/notifications/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Notifications')
@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold">Notifications — {{ $user->name }}</h1>
        <form method="POST" action="{{ route('notification.read', $user) }}">
            @csrf
            <button type="submit" class="btn-outline">Tout marquer comme lu</button>
        </form>
    </div>
    @forelse ($notifications as $notification)
        <div class="glass mb-2 rounded-xl p-4 {{ $notification->is_read ? 'opacity-60' : 'font-semibold' }}">
            {{ $notification->message }}
            <span class="block text-xs text-slate-500">{{ $notification->created_at->format('d/m/Y H:i')
                }}</span>
        </div>
    @empty
        <p class="text-slate-500">Aucune notification.</p>
    @endforelse
    <div class="mt-4">{{ $notifications->links() }}</div>
@endsection