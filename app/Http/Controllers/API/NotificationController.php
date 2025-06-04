<?php
// app/Http/Controllers/Api/NotificationController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('receiver_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return response()->json($notifications);
    }

    public function show(Notification $notification)
    {
        if ($notification->receiver_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Mark the notification as read if not already
        if ($notification->status === 'unread') {
            $notification->update(['status' => 'read']);
        }

        return response()->json($notification);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|string|max:255',
        ]);

        $notification = Notification::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'message'     => $validated['message'],
        ]);

        return response()->json($notification, 201);
    }

    public function destroy(Notification $notification)
    {
        if ($notification->receiver_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->delete();

        return response()->json(['message' => 'Notification deleted']);
    }
}
