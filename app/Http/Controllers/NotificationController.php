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
        $role = strtolower($user->role);
        
        $notifications = Notification::where('id_utilisateur', $user->id)
            ->where('role', $role)
            ->latest('created_at')
            ->paginate(10);

        // Si c'est un étudiant, on marque toutes ses notifications comme lues
        if ($role === 'etudiant') {
            Notification::where('id_utilisateur', $user->id)
                ->where('role', $role)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
        
        $view = $role === 'admin' ? 'admin.notifications' : 'etudiant.notifications';
        
        return view($view, compact('notifications'));
    }

    /**
     * Helper to store notification for all admins.
     */
    public static function storeForAdmin($title, $message, $type, $student_matricule = null, $link = null)
    {
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'id_utilisateur' => $admin->id,
                'role' => 'admin',
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'matricule_etudiant' => $student_matricule,
                'link' => $link,
                'is_read' => false,
            ]);
        }
    }

    /**
     * Helper to store notification for a specific student.
     */
    public static function storeForStudent($userId, $title, $message, $type, $student_matricule = null, $link = null)
    {
        Notification::create([
            'id_utilisateur' => $userId,
            'role' => 'etudiant',
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'matricule_etudiant' => $student_matricule,
            'link' => $link,
            'is_read' => false,
        ]);
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

            $notification->update(['is_read' => true]);

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
            Auth::user()->notifications()->where('is_read', false)->update(['is_read' => true]);

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
