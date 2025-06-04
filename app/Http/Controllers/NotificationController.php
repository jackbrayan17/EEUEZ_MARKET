<?php
// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Fetch all notifications for the authenticated user (receiver)
    public function index()
    {
        $notifications = Notification::where('receiver_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('notifications'));
    }

    // Show a specific notification
    public function show(Notification $notification)
    {
        // Mark the notification as read if not already
        if ($notification->status === 'unread') {
            $notification->update(['status' => 'read']);
        }

        return view('notifications.show', compact('notification'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|string|max:255',
        ]);

        Notification::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'message'     => $validated['message'],
        ]);

        return redirect()->back()->with('success', 'Notification sent successfully!');
    }

    // Delete a notification
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification deleted.');
    }
}
