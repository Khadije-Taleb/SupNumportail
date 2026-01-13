<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\CertificatMedical;

class CertificatMedicalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->etudiant) {
             return redirect()->route('etudiant.profil')->with('warning', 'Veuillez compléter votre profil pour gérer vos certificats.');
        }

        $certificats = $user->etudiant->certificatMedicals()->with('evaluation')->latest('created_at')->get();

        // Load available evaluations for the form
        $evaluations = \App\Models\Evaluation::orderBy('nom_matiere')->orderBy('type_evaluation')->get();

        $etudiant = $user->etudiant;
        return view('etudiant.certificat_medical', compact('certificats', 'evaluations', 'user', 'etudiant'));
    }

    public function create()
    {
        return $this->index(); // Re-use index view which has the form
    }

    public function store(Request $request)
    {
        $request->validate([
            'annee' => 'required|in:L1,L2,L3,M1,M2',
            'nom_matiere' => 'required|string|max:100',
            'type_evaluation' => 'required|in:devoir_ecrit,devoir_pratique,tp_note,examen_final',
            'date_evaluation' => 'required|date',
            'fichier' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        if (!$user->etudiant) {
            return back()->with('error', 'Profil étudiant non trouvé.');
        }

        // Find or create the evaluation based on user input
        $evaluation = \App\Models\Evaluation::firstOrCreate(
            [
                'nom_matiere' => $request->nom_matiere,
                'type_evaluation' => $request->type_evaluation
            ]
        );

        $path = $request->file('fichier')->store('certificats', 'public');

        $certificat = CertificatMedical::create([
            'matricule_etudiant' => $user->etudiant->matricule,
            'annee' => $request->annee,
            'evaluation_id' => $evaluation->id,
            'date_absence' => $request->date_evaluation,
            'photo_certificat' => $path,
            'statut' => 'EN_ATTENTE',
            'admin_id' => null,
            'remarque_admin' => null,
        ]);

        // Notify Admin
        \App\Http\Controllers\NotificationController::storeForAdmin(
            "Nouveau certificat médical",
            "Un nouveau certificat médical pour la matière " . $request->nom_matiere . " a été envoyé par l'étudiant " . $user->full_name,
            "certificat",
            $user->etudiant->matricule,
            route('admin.certificats.show', $certificat->id)
        );

        return back()->with('success', 'Certificat médical déposé avec succès.');
    }

    public function adminIndex(Request $request)
    {
        $query = CertificatMedical::with(['etudiant.utilisateur', 'evaluation']);

        // Filter by status
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        } else {
            $query->where('statut', 'EN_ATTENTE');
        }

        // Filter by matiere (via evaluation table)
        if ($request->filled('matiere')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('nom_matiere', $request->matiere);
            });
        }

        // Filter by type_evaluation (via evaluation table)
        if ($request->filled('type_evaluation')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('type_evaluation', $request->type_evaluation);
            });
        }

        $certificats = $query->latest()->paginate(10);

        // Get distinct matieres and types for filter dropdowns
        $matieres = \App\Models\Evaluation::distinct()->pluck('nom_matiere')->sort();
        $typesEvaluation = \App\Models\Evaluation::distinct()->pluck('type_evaluation')->sort();

        return view('admin.certificats.index', compact('certificats', 'matieres', 'typesEvaluation'));
    }

    public function adminShow(CertificatMedical $certificat)
    {
        $certificat->load(['etudiant.utilisateur', 'evaluation']);
        $certificats = CertificatMedical::with(['etudiant.utilisateur', 'evaluation'])->latest()->paginate(10);
        return view('admin.certificats.index', compact('certificat', 'certificats'));
    }

    public function adminViewFile(CertificatMedical $certificat)
    {
        $path = storage_path('app/public/' . $certificat->photo_certificat);

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
            $message = "Votre certificat médical pour la matière " . ($certificat->evaluation->nom_matiere ?? '') . " a été {$statusLabel}.";
            if ($request->remarque_admin) {
                $message .= " Remarque : " . $request->remarque_admin;
            }

            \App\Http\Controllers\NotificationController::storeForStudent(
                $certificat->etudiant->utilisateur->id,
                "Mise à jour de votre certificat",
                $message,
                "certificat",
                $certificat->etudiant->matricule,
                route('etudiant.certificats.index')
            );
        }

        return redirect()->route('admin.certificats.index')->with('success', 'Le certificat a été traité avec succès.');
    }

}
