<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Admin;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $adminUser = User::create([
            'email' => 'admin@portail.com',
            'mot_de_passe' => Hash::make('password'),
            'role' => 'admin',
            'actif' => 1,
        ]);

        Admin::create([
            'id_utilisateur' => $adminUser->id_utilisateur,
            'nom' => 'Principal',
            'prenom' => 'Admin',
        ]);

        // Create Student User
        $etudiantUser = User::create([
            'email' => 'etudiant@portail.com',
            'mot_de_passe' => Hash::make('password'),
            'role' => 'etudiant',
            'actif' => 1,
        ]);

        Etudiant::create([
            'id_utilisateur' => $etudiantUser->id_utilisateur,
            'matricule' => 'ETU2024001',
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'filiere' => 'Informatique',
            'niveau' => 'Licence 3',
        ]);

        // Create another student
        $etudiantUser2 = User::create([
            'email' => 'marie@portail.com',
            'mot_de_passe' => Hash::make('password'),
            'role' => 'etudiant',
            'actif' => 1,
        ]);

        Etudiant::create([
            'id_utilisateur' => $etudiantUser2->id_utilisateur,
            'matricule' => 'ETU2024002',
            'nom' => 'Martin',
            'prenom' => 'Marie',
            'filiere' => 'Gestion',
            'niveau' => 'Master 1',
        ]);
    }
}
