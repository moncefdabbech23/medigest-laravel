<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class NotificationController extends Controller
{
    // /notifications : les notifications de l'utilisateur connecté (patient, médecin ou admin)
    public function index(Request $request)
    {
        $user = $request->user();
        $notifications = $user->userNotifications()->latest()->paginate(15);
        return view('notifications.index', compact('user', 'notifications'));
    }
    // POST /notifications/read
    public function markAllRead(Request $request)
    {
        $request->user()->userNotifications()->where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Toutes les notifications sont lues.');
    }
}