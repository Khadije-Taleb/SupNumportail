<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Document::updateOrCreate(
            ['type_document' => 'Attestation de scolarité'],
            ['description' => 'Document officiel prouvant votre inscription pour l\'année académique en cours.']
        );
        
        Document::updateOrCreate(
            ['type_document' => 'Relevé de notes'],
            ['description' => 'Document détaillant les notes et crédits obtenus pour un semestre ou une année.']
        );

        Document::updateOrCreate(
            ['type_document' => 'Certificat de scolarité'],
            ['description' => 'Justificatif de votre statut d\'étudiant auprès d\'organismes tiers.']
        );

        Document::updateOrCreate(
            ['type_document' => 'Diplôme / Attestation de réussite'],
            ['description' => 'Document certifiant la validation finale de votre cursus.']
        );
    }
}
