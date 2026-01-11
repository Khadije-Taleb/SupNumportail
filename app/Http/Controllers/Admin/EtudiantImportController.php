<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\EtudiantsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EtudiantImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.etudiants.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'fichier_excel' => 'required|mimes:xlsx,xls'
        ]);

        $import = new EtudiantsImport;
        Excel::import($import, $request->file('fichier_excel'));

        return back()->with('success', "Importation réussie! " . $import->importedCount . " étudiants ajoutés, " . $import->skippedCount . " ignorés (doublons).");
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="modele_import_etudiants.csv"',
        ];

        $columns = ['matricule', 'nom', 'prenom', 'email', 'password', 'annee', 'filiere'];
        $sample = ['SUP001', 'Doe', 'John', 'john.doe@supnum.mr', 'Pass123', 'L1', 'Informatique'];

        $callback = function() use ($columns, $sample) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, $sample);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
