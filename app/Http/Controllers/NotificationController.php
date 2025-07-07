<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10);
        
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->markAsRead();

            return redirect()->back()->with('success', 'Notification marked as read');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to mark notification as read');
        }
    }

    public function markAllAsRead()
    {
        try {
            Auth::user()->unreadNotifications->markAsRead();

            return redirect()->back()->with('success', 'All notifications marked as read');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to mark all notifications as read');
        }
    }

    public function destroy($id)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->delete();

            return redirect()->back()->with('success', 'Notification deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to delete notification');
        }
    }

    public function destroyAll()
    {
        try {
            Auth::user()->notifications()->delete();

            return redirect()->back()->with('success', 'All notifications cleared');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to clear notifications');
        }
    }
}