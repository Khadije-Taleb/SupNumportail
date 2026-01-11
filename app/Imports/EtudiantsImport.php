<?php

namespace App\Imports;

use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EtudiantsImport implements ToCollection, WithHeadingRow
{
    public $importedCount = 0;
    public $skippedCount = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Ensure required keys exist
            if (!isset($row['matricule']) || !isset($row['email'])) {
                continue;
            }

            // Check if matricule or email already exists
            if (Etudiant::where('matricule', $row['matricule'])->exists() || 
                User::where('email', $row['email'])->exists()) {
                $this->skippedCount++;
                continue;
            }

            try {
                // Create User
                $user = User::create([
                    'email' => $row['email'],
                    'password' => Hash::make($row['password'] ?? 'default'), // Use default or random if missing? Better to require it.
                    'role' => 'etudiant',
                    'premiere_connexion' => true,
                ]);

                // Create Etudiant
                Etudiant::create([
                    'matricule' => $row['matricule'],
                    'utilisateur_id' => $user->id,
                    'nom' => $row['nom'] ?? '',
                    'prenom' => $row['prenom'] ?? '',
                    'email' => $row['email'],
                    'annee' => $row['annee'] ?? '',
                    'filiere' => $row['filiere'] ?? '',
                ]);

                $this->importedCount++;
            } catch (\Exception $e) {
                // Log error if needed, or just count as skipped if insertion fails for other reasons
                Log::error('Import error for ' . ($row['email'] ?? 'unknown') . ': ' . $e->getMessage());
                $this->skippedCount++;
            }
        }
    }
}
