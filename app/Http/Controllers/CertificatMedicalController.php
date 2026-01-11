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

        $certificats = $user->etudiant->certificatMedicals()->latest('created_at')->get();

        // Load available evaluations for the form. If evaluation table or columns are missing,
        // fallback to distinct values from certificat_medical so the form remains functional.
        $evaluations = collect();
        if (Schema::hasTable('evaluation') && Schema::hasColumn('evaluation', 'matiere') && Schema::hasColumn('evaluation', 'type_evaluation')) {
            $evaluations = \App\Models\Evaluation::orderBy('matiere')->orderBy('type_evaluation')->get();
        } elseif (Schema::hasTable('certificat_medical') && Schema::hasColumn('certificat_medical', 'matiere') && Schema::hasColumn('certificat_medical', 'type_evaluation')) {
            $evaluations = \App\Models\CertificatMedical::select('matiere', 'type_evaluation')
                ->distinct()
                ->orderBy('matiere')
                ->get()
                ->map(function ($row) {
                    // Create lightweight objects compatible with the view
                    return (object) [
                        'id' => null,
                        'matiere' => $row->matiere,
                        'type_evaluation' => $row->type_evaluation,
                    ];
                });
        }

        return view('etudiant.certificat_medical', compact('certificats', 'evaluations'));
    }

    public function create()
    {
        return $this->index(); // Re-use index view which has the form
    }

    public function store(Request $request)
    {
        $request->validate([
            'annee' => 'required|in:L1,L2,L3,M1,M2',
            'evaluation_id' => 'required|integer',
            'date_evaluation' => 'required|date',
            'fichier' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        if (!$user->etudiant) {
            return back()->with('error', 'Profil étudiant non trouvé.');
        }

        // Find evaluation and ensure it exists
        $evaluation = \App\Models\Evaluation::find($request->evaluation_id);
        if (!$evaluation) {
            return back()->withInput()->with('error', 'Évaluation sélectionnée invalide.');
        }

        $path = $request->file('fichier')->store('certificats', 'public');

        CertificatMedical::create([
            'matricule_etudiant' => $user->etudiant->matricule,
            'annee' => $request->annee,
            'type_evaluation' => $evaluation->type_evaluation,
            'matiere' => $evaluation->matiere,
            'date_absence' => $request->date_evaluation, // Mapping date_evaluation from form to date_absence in DB
            'photo_certificat' => $path,
            'statut' => 'EN_ATTENTE',
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
        } else {
            $query->where('statut', 'EN_ATTENTE');
        }

        $certificats = $query->latest()->paginate(10);

        return view('admin.certificats.index', compact('certificats'));
    }

    public function adminShow(CertificatMedical $certificat)
    {
        $certificat->load(['etudiant.utilisateur']);
        $certificats = CertificatMedical::with('etudiant.utilisateur')->latest()->paginate(10);
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
            $message = "Votre certificat médical a été {$statusLabel}.";
            if ($request->remarque_admin) {
                $message .= " Remarque de l'administration : " . $request->remarque_admin;
            }

            \App\Models\Notification::create([
                'id_utilisateur' => $certificat->etudiant->utilisateur->id,
                'matricule_etudiant' => $certificat->etudiant->matricule,
                'message' => "Certificat médical traité : " . $message,
                'lu' => false,
            ]);
        }

        return redirect()->route('admin.certificats.index')->with('success', 'Le certificat a été traité avec succès.');
    }

}
