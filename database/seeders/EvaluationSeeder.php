<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluation;

class EvaluationSeeder extends Seeder
{
    public function run(): void
    {
        $evaluations = [
            ['nom_matiere' => 'Mathématiques', 'type_evaluation' => 'devoir_ecrit'],
            ['nom_matiere' => 'Mathématiques', 'type_evaluation' => 'examen_final'],
            ['nom_matiere' => 'Algorithmes', 'type_evaluation' => 'tp_note'],
            ['nom_matiere' => 'Algorithmes', 'type_evaluation' => 'devoir_pratique'],
            ['nom_matiere' => 'Base de données', 'type_evaluation' => 'devoir_ecrit'],
            ['nom_matiere' => 'Base de données', 'type_evaluation' => 'examen_final'],
            ['nom_matiere' => 'Réseaux', 'type_evaluation' => 'tp_note'],
            ['nom_matiere' => 'Programmation Web', 'type_evaluation' => 'devoir_pratique'],
            ['nom_matiere' => 'Programmation Web', 'type_evaluation' => 'examen_final'],
            ['nom_matiere' => 'Systèmes d\'exploitation', 'type_evaluation' => 'devoir_ecrit'],
        ];

        foreach ($evaluations as $evaluation) {
            Evaluation::firstOrCreate($evaluation);
        }
    }
}
