<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Demande;
use App\Models\Document;
use App\Models\Etudiant;

class DemandeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->etudiant) {
            return redirect()->route('etudiant.profil')->with('warning', 'Veuillez compléter votre profil pour voir vos demandes.');
        }

        $demandes = $user->etudiant->demandes()->with('document')->latest('created_at')->paginate(10);
        $documents = Document::where('actif', true)->get();
        return view('etudiant.mes_demandes', compact('demandes', 'documents'));
    }

    public function create()
    {
        $documents = Document::where('actif', true)->get();
        return view('etudiant.nouvelle_demande', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('document', 'id')->where(function ($query) {
                    $query->where('actif', true);
                }),
            ],
            'commentaire' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        if (!$user->etudiant) {
            return redirect()->route('etudiant.profil')->with('error', 'Vous devez compléter votre profil étudiant avant de faire une demande.');
        }

        $path = null;
        if ($request->hasFile('justificatif')) {
            $path = $request->file('justificatif')->store('justificatifs', 'public');
        }

        Demande::create([
            'matricule_etudiant' => $user->etudiant->matricule,
            'document_id' => $request->document_id,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('etudiant.demandes.index')->with('success', 'Votre demande a été enregistrée avec succès.');
    }

    // Admin methods
    public function adminShow(Demande $demande)
    {
        $demande->load(['etudiant.utilisateur', 'document']);
        return view('admin.demandes.show', compact('demande'));
    }

    public function updateStatus(Request $request, Demande $demande)
    {
        if ($demande->statut !== 'EN_ATTENTE') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $request->validate([
            'statut' => 'required|in:ACCEPTEE,REJETEE',
            'remarque_admin' => $request->statut === 'REJETEE' ? 'required|string|min:5' : 'nullable|string',
        ], [
            'remarque_admin.required' => 'Une remarque est obligatoire en cas de refus.'
        ]);

        $admin = Auth::user()->admin;

        $demande->update([
            'statut' => $request->statut,
            'remarque_admin' => $request->remarque_admin,
            'id_admin' => $admin->id_admin,
        ]);

        // Notification Logic
        if ($demande->etudiant && $demande->etudiant->utilisateur) {
            $statusLabel = $request->statut === 'ACCEPTEE' ? 'acceptée' : 'rejetée';
            $message = "Votre demande pour le document : {$demande->document->type_document} a été {$statusLabel}.";
            if ($request->remarque_admin) {
                $message .= " Remarque : " . $request->remarque_admin;
            }

            \App\Models\Notification::create([
                'id_utilisateur' => $demande->etudiant->utilisateur->id,
                'matricule_etudiant' => $demande->etudiant->matricule,
                'message' => "Demande administrative traitée : " . $message,
                'lu' => false,
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'La demande a été traitée avec succès.');
    }
}
