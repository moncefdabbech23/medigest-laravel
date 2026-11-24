{{-- resources/views/notifications/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Notifications')
@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold">Mes notifications</h1>
        <form method="POST" action="{{ route('notification.read') }}">
            @csrf
            <button type="submit" class="btn-outline">Tout marquer comme lu</button>
        </form>
    </div>
    @forelse ($notifications as $notification)
        <div class="glass mb-2 flex items-start gap-3 rounded-xl p-4 {{ $notification->is_read ? 'opacity-60' :
            '' }}">
            <span class="mt-1.5 size-2.5 shrink-0 rounded-full {{ $notification->is_read ? 'bg-slate-300' :
                'bg-teal-500' }}"></span>
            <div>
                <p class="{{ $notification->is_read ? '' : 'font-semibold' }}">{{ $notification->message }}</p>
                <p class="text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
        </div>
    @empty
        <p class="text-slate-500">Aucune notification.</p>
    @endforelse
    <div class="mt-4">{{ $notifications->links() }}</div>
@endsection