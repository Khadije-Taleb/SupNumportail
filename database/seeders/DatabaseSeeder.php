<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $adminUser = User::create([
            'email' => 'admin@supnum.ne',
            'mot_de_passe' => Hash::make('password123'),
            'role' => 'admin',
            'actif' => true,
        ]);

        Admin::create([
            'nom' => 'Admin',
            'prenom' => 'Principal',
            'id_utilisateur' => $adminUser->id_utilisateur,
        ]);

        // Create Student User
        $etudiantUser = User::create([
            'email' => 'etudiant@supnum.ne',
            'mot_de_passe' => Hash::make('password123'),
            'role' => 'etudiant',
            'actif' => true,
        ]);

        Etudiant::create([
            'matricule' => 'ETU2025001',
            'nom' => 'Bah',
            'prenom' => 'Mamadou',
            'filiere' => 'Genie Logiciel',
            'niveau' => 'L3',
            'id_utilisateur' => $etudiantUser->id_utilisateur,
        ]);
    }
}
