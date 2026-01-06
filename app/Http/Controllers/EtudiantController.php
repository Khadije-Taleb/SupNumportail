<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Demande;
use App\Models\CertificatMedical;
use App\Models\Notification;

class EtudiantController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        $stats = [
            'total' => $etudiant ? $etudiant->demandes()->count() : 0,
            'en_attente' => $etudiant ? $etudiant->demandes()->where('statut', 'en_attente')->count() : 0,
            'acceptees' => $etudiant ? $etudiant->demandes()->where('statut', 'acceptee')->count() : 0,
            'rejetees' => $etudiant ? $etudiant->demandes()->where('statut', 'rejetee')->count() : 0,
        ];

        $notifications = $user->getAllNotifications()->latest('date_notification')->take(5)->get();

        return view('etudiant.dashboard', compact('user', 'etudiant', 'stats', 'notifications'));
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->getAllNotifications()->latest('date_notification')->paginate(10);
        return view('etudiant.notifications', compact('notifications'));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('etudiant.profil', compact('user'));
    }
}
