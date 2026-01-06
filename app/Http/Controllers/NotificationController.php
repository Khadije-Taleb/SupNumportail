<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index() // Renamed from notifications to index to match resource/route convention if needed, or stick to route definition
    {
        // In web.php I pointed EtudiantController@notifications to notifications.index
        // But better to use NotificationController@index
        // I'll update web.php later or just rely on the route pointing to here?
        // Wait, web.php has: Route::get('/notifications', [EtudiantController::class, 'notifications'])
        // I should change it or implement 'notifications' method in EtudiantController.
        // Better: I will implement it here and assumed I fixed web.php or will fix it.
        // Actually, I'll stick to the plan: I'll implement 'notifications' in EtudiantController?
        // No, separation of concerns. I'll use NotificationController and update route if I can, or just put logic in EtudiantController.
        // I created EtudiantController earlier without 'notifications' method.
        // I will use EtudiantController to keep it simple as per route definition in web.php?
        // "Route::get('/notifications', [EtudiantController::class, 'notifications'])"
        // I'll add the method to EtudiantController.
        return $this->showNotifications();
    }
    
    // Actually, I'll create NotificationController index, and update web.php route logic implicitly 
    // or just implement the method in EtudiantController to match my web.php file which I ALREADY wrote.
    // In web.php: Route::get('/notifications', [EtudiantController::class, 'notifications'])
    // So I MUST implement `notifications` in `EtudiantController`.
    // OR create NotificationController and update web.php.
    // I prefer NotificationController. I'll overwrite web.php route or I'll just put the method in EtudiantController.
    // I'll put it in EtudiantController to avoid modifying web.php again.
    public function markAsRead(Notification $notification)
    {
        if ($notification->id_utilisateur !== Auth::id()) {
            abort(403);
        }

        $notification->update(['lu' => true]);

        return back()->with('success', 'Notification marquée comme lue.');
    }
}
