<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->limit(20)->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Notification::unread()->count(),
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        Notification::unread()->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}