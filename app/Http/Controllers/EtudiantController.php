<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
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

        $notifications = $user->notifications()->where('role', 'etudiant')->latest('created_at')->take(5)->get();
        return view('etudiant.dashboard', compact('user', 'etudiant', 'stats', 'notifications'));
    }

    public function notifications()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;
        $notifications = $user->notifications()->where('role', 'etudiant')->latest('created_at')->paginate(10);
        return view('etudiant.notifications', compact('notifications', 'user', 'etudiant'));
    }

    public function profil()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;
        return view('etudiant.profil', compact('user', 'etudiant'));
    }

    public function editPassword()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;
        return view('etudiant.password-edit', compact('user', 'etudiant'));
    }

    public function updatePassword(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('etudiant.profil')->with('success', 'Votre mot de passe a été mis à jour avec succès.');
    }
}
