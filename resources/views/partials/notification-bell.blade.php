{{-- resources/views/partials/notification-bell.blade.php
     La personne A l'affiche dans l'en-tête avec @includeIf('partials.notification-bell') (étape A15). --}}
@auth
    @php($unread = auth()->user()->userNotifications()->where('is_read', false)->count())
    <a href="{{ route('notification.index') }}" class="btn-outline relative !px-3" aria-label="Notifications
        ({{ $unread }} non lues)">
        
        @if ($unread > 0)
            <span class="absolute -right-1.5 -top-1.5 flex size-5 items-center justify-center rounded-full
                bg-rose-500 text-[10px] font-bold text-white shadow">
                {{ $unread > 9 ? '9+' : $unread }}
            </span>
        @endif
    </a>
@endauth