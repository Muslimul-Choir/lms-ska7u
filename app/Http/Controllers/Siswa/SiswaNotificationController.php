<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaNotificationController extends Controller
{
    /**
     * Get recent notifications and unread count for AJAX polling.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notifications = $user->notifications()->latest()->take(15)->get();
        $unreadCount = $user->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Mark a single notification as read and redirect to its target URL.
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        $redirectUrl = $notification->data['url'] ?? route('siswa.dashboard');

        return redirect($redirectUrl);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Delete a single notification.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Check for real-time content updates for the student's class.
     */
    public function checkUpdates()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $siswa = $user->siswa;
        if (!$siswa) {
            return response()->json(['updated' => false, 'updates' => []]);
        }

        $cacheKey = "content_updates_{$siswa->id_kelas}";
        $updates = \Illuminate\Support\Facades\Cache::get($cacheKey, []);

        // Clear the updates after reading them (one-time retrieval)
        if (!empty($updates)) {
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
        }

        return response()->json([
            'updated' => !empty($updates),
            'updates' => $updates,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}

