<?php

namespace App\Http\Controllers;

use App\Models\User;

class NotificationController extends Controller
{
    // Liste des notifications d'un utilisateur
    public function index(User $user)
    {
        $notifications = $user->userNotifications()->latest()->paginate(10);
        return view('notifications.index', compact('user', 'notifications'));
    }

    // Marque toutes les notifications comme lues
    public function markAllRead(User $user)
    {
        $user->userNotifications()->where('is_read', false)->update(['is_read' => true]);
        return to_route('notification.index', $user)->with('success', 'Notifications marquées comme lues.');
    }
}