<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\Notification;
use App\Models\Admin;
use App\Models\Etudiant;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    /**
     * Display a listing of the demands.
     */
    public function index(Request $request)
    {
        $query = Demande::with(['etudiant', 'document']);

        // Filters
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $demandes = $query->latest()->paginate(10);
        $is_certificat = false; 

        return view('admin.demandes.index', compact('demandes', 'is_certificat'));
    }

    /**
     * Display the specified demand.
     */
    public function show($id)
    {
        $demande = Demande::with(['etudiant.utilisateur', 'document', 'admin'])->findOrFail($id);
        $demandes = Demande::with(['etudiant', 'document'])->latest()->paginate(10);
        return view('admin.demandes.index', compact('demande', 'demandes'));
    }

    /**
     * Update the status of the specified demand.
     */
    public function updateStatus(Request $request, $id)
    {
        $demande = Demande::findOrFail($id);

        $request->validate([
            'statut' => 'required|in:rejetee,en_cours_traitement,fin',
            'remarque_admin' => $request->statut === 'rejetee' ? 'required|string|min:5' : 'nullable|string',
        ], [
            'remarque_admin.required' => 'Une remarque est obligatoire en cas de rejet.'
        ]);

        $admin = Auth::user()->admin;
        if (!$admin) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $oldStatus = $demande->statut;
        $newStatus = $request->statut;

        $demande->update([
            'statut' => $newStatus,
            'remarque_admin' => $request->remarque_admin,
            'admin_id' => $admin->id,
        ]);

        // Notification Logic
        if ($demande->etudiant && $demande->etudiant->utilisateur) {
            $statusLabel = $request->statut === 'rejetee' ? 'rejetée' : ($request->statut === 'fin' ? 'terminée' : 'en cours');
            $message = "Votre demande pour le document : {$demande->document->type_document} est désormais {$statusLabel}.";
            if ($request->remarque_admin) {
                $message .= " Remarque : " . $request->remarque_admin;
            }

            \App\Http\Controllers\NotificationController::storeForStudent(
                $demande->etudiant->utilisateur->id,
                "Mise à jour de votre demande",
                $message,
                "demande",
                $demande->etudiant->matricule,
                route('etudiant.demandes.index')
            );
        }

        return redirect()->route('admin.dashboard')->with('success', 'Le statut de la demande a été mis à jour avec succès.');
    }

}
