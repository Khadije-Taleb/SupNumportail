<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Etudiant;

class UsersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip if mandatory fields missing
            if (!isset($row['matricule']) || !isset($row['email']) || !isset($row['password'])) {
                continue;
            }

            // Check duplicate matricule or email to prevent errors or overwrite
            if (Etudiant::where('matricule', $row['matricule'])->exists()) {
                continue; 
            }
            if (User::where('email', $row['email'])->exists()) {
                continue;
            }

            DB::transaction(function () use ($row) {
                // Create User
                $user = User::create([
                    'email' => $row['email'],
                    'password' => Hash::make($row['password']),
                    'role' => 'etudiant',
                    'premiere_connexion' => true,
                ]);

                // Create Etudiant
                Etudiant::create([
                    'matricule' => $row['matricule'],
                    'nom' => $row['nom'],
                    'prenom' => $row['prenom'],
                    'annee' => $row['annee'],
                    'filiere' => $row['filiere'],
                    'email' => $row['email'],
                    'utilisateur_id' => $user->id,
                ]);
            });
        }
    }
}
