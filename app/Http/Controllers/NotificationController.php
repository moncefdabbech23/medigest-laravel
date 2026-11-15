<?php
namespace App\Http\Controllers;
use App\Models\User;
class NotificationController extends Controller
{
    // /users/{user}/notifications
    public function index(User $user)
    {
        $notifications = $user->userNotifications()->latest()->paginate(15);
        return view('notifications.index', compact('user', 'notifications'));
    }
    // POST /users/{user}/notifications/read
    public function markAllRead(User $user)
    {
        $user->userNotifications()->where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Toutes les notifications sont lues.');
    }
}