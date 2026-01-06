<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CertificatMedical;

class CertificatMedicalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->etudiant) {
             return redirect()->route('etudiant.profil')->with('warning', 'Veuillez compléter votre profil pour gérer vos certificats.');
        }

        $certificats = $user->etudiant->certificatMedicals()->latest('date_upload')->get();
        return view('etudiant.certificat_medical', compact('certificats'));
    }

    public function create()
    {
        return $this->index(); // Re-use index view which has the form
    }

    public function store(Request $request)
    {
        $request->validate([
            'annee' => 'required|in:L1,L2,L3,M1,M2',
            'type_evaluation' => 'required|in:devoir,examen,examen_pratique,tp',
            'matiere' => 'required|string|max:100',
            'date_evaluation' => 'required|date',
            'fichier' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        if (!$user->etudiant) {
            return back()->with('error', 'Profil étudiant non trouvé.');
        }

        $path = $request->file('fichier')->store('certificats', 'public');

        CertificatMedical::create([
            'etudiant_matricule' => $user->etudiant->matricule,
            'annee' => $request->annee,
            'type_evaluation' => $request->type_evaluation,
            'matiere' => $request->matiere,
            'date_evaluation' => $request->date_evaluation,
            'fichier' => $path,
            'statut' => 'EN_ATTENTE',
            'date_upload' => now(),
            'admin_id' => null,
            'remarque_admin' => null,
        ]);

        return back()->with('success', 'Certificat médical déposé avec succès.');
    }

    public function adminIndex(Request $request)
    {
        $query = CertificatMedical::with('etudiant.utilisateur');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $certificats = $query->latest('date_upload')->paginate(15);
        return view('admin.certificats.index', compact('certificats'));
    }

    public function adminShow(CertificatMedical $certificat)
    {
        $certificat->load(['etudiant.utilisateur']);
        return view('admin.certificats.show', compact('certificat'));
    }

    public function adminViewFile(CertificatMedical $certificat)
    {
        $path = storage_path('app/public/' . $certificat->fichier);
        
        if (!file_exists($path)) {
            abort(404, "Le fichier n'existe pas.");
        }

        return response()->file($path);
    }

    public function adminUpdateStatus(Request $request, CertificatMedical $certificat)
    {
        // Prevent modifying already processed certificates
        if ($certificat->statut !== 'EN_ATTENTE') {
            return back()->with('error', 'Ce certificat a déjà été traité.');
        }

        $request->validate([
            'statut' => 'required|in:VALIDE,REFUSE',
            'remarque_admin' => $request->statut === 'REFUSE' ? 'required|string|min:5' : 'nullable|string'
        ], [
            'remarque_admin.required' => 'Une remarque est obligatoire en cas de refus.'
        ]);

        $admin = Auth::user()->admin;

        $certificat->update([
            'statut' => $request->statut,
            'remarque_admin' => $request->remarque_admin,
            'admin_id' => $admin->id_admin, // Should be authenticated admin
        ]);

        // Notification Logic
        if ($certificat->etudiant && $certificat->etudiant->utilisateur) {
            $statusLabel = $request->statut === 'VALIDE' ? 'accepté' : 'rejeté';
            $message = "Votre certificat médical a été {$statusLabel}.";
            if ($request->remarque_admin) {
                $message .= " Remarque de l'administration : " . $request->remarque_admin;
            }

            \App\Models\Notification::create([
                'id_utilisateur' => $certificat->etudiant->utilisateur->id_utilisateur,
                'message' => "Certificat médical traité : " . $message,
                'lu' => false,
                'date_notification' => now(),
            ]);
        }

        return redirect()->route('admin.certificats.index')->with('success', 'Le certificat a été traité avec succès.');
    }
}
