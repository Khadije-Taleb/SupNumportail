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
            'email' => 'admin@supnum.mr',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        Admin::create([
            'nom' => 'Admin',
            'prenom' => 'Principal',
            'utilisateur_id' => $adminUser->id,
        ]);

        // Create Student User
        $etudiantUser = User::create([
            'email' => 'etudiant@supnum.ne',
            'password' => Hash::make('password123'),
            'role' => 'etudiant',
        ]);

        Etudiant::create([
            'matricule' => 'ETU2025001',
            'nom' => 'Bah',
            'prenom' => 'Mamadou',
            'filiere' => 'Genie Logiciel',
            'annee' => 'L3',
            'email' => 'etudiant@supnum.ne',
            'utilisateur_id' => $etudiantUser->id,
        ]);

        $this->call([
            DocumentSeeder::class,
            \Database\Seeders\EvaluationSeeder::class,
        ]);
    }
}
