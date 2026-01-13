<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\Etudiant;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');
        $statut = $request->get('statut');

        if ($type === 'certificat') {
            $query = \App\Models\CertificatMedical::with('etudiant.utilisateur');
            if ($statut) {
                $query->where('statut', $statut);
            }
            $items = $query->latest('created_at')->get();
        } else {
            $query = Demande::with('etudiant.utilisateur', 'document');
            if ($statut) {
                $query->where('statut', $statut);
            }
            if ($type) {
                $query->whereHas('document', function($q) use ($type) {
                    $q->where('id', $type);
                });
            }
            $items = $query->latest('created_at')->get();
        }
        
        // Comprehensive stats
        $stats = [
            'total' => Demande::count() + \App\Models\CertificatMedical::count(),
            'pending' => Demande::where('statut', 'en_attente')->count() + \App\Models\CertificatMedical::where('statut', 'EN_ATTENTE')->count(),
            'in_progress' => Demande::where('statut', 'en_cours_traitement')->count(),
            'completed_month' => (Demande::where('statut', 'fin')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count()) + (\App\Models\CertificatMedical::where('statut', 'VALIDE')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count()),
        ];

        $documents = \App\Models\Document::all();

        return view('admin.dashboard', [
            'demandes' => $items, 
            'stats' => $stats,
            'documents' => $documents,
            'is_certificat' => ($type === 'certificat')
        ]);
    }

    public function showImportForm()
    {
        return view('admin.import_students');
    }

    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\UsersImport, $request->file('file'));
            return redirect()->route('admin.import')->with('success', 'Importation réussie avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'importation : ' . $e->getMessage());
        }
    }
}
