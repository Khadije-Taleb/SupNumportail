<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications for the current user.
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest('created_at')->paginate(10);
        
        $view = strtolower($user->role) === 'admin' ? 'admin.notifications' : 'etudiant.notifications';
        
        return view($view, compact('notifications'));
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, $notificationId)
    {
        try {
            $user = Auth::user();
            
            // Find notification that belongs to the authenticated user
            $notification = $user->notifications()->findOrFail($notificationId);

            $notification->update(['lu' => true]);

            if ($request->ajax() || $request->expectsJson() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Notification marquée comme lue.']);
            }

            return back()->with('success', 'Notification marquée comme lue.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Notification not found: ' . $notificationId . ' for user: ' . Auth::id());
            if ($request->ajax() || $request->expectsJson() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Notification introuvable.'], 404);
            }
            abort(404, 'Notification introuvable.');
        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            if ($request->ajax() || $request->expectsJson() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Erreur lors de la mise à jour.');
        }
    }

    /**
     * Mark all notifications as read for the current user.
     */
    public function markAllRead(Request $request)
    {
        try {
            Auth::user()->notifications()->where('lu', false)->update(['lu' => true]);

            if ($request->ajax() || $request->expectsJson() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Toutes les notifications ont été marquées comme lues.']);
            }

            return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
            if ($request->ajax() || $request->expectsJson() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour.'], 500);
            }
            return back()->with('error', 'Erreur lors de la mise à jour.');
        }
    }
}
