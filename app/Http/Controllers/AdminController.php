<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\Etudiant;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Demande::with('etudiant.utilisateur', 'document');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $demandes = $query->latest('date_demande')->get();
        // Simple counts for now
        $stats = [
            'total' => Demande::count(),
            'pending' => Demande::where('statut', 'en_attente')->count(),
            'pending_certificats' => \App\Models\CertificatMedical::where('statut', 'EN_ATTENTE')->count(),
        ];
        return view('admin.dashboard', compact('demandes', 'stats'));
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
