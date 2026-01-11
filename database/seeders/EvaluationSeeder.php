<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvaluationSeeder extends Seeder
{
    public function run()
    {
        $now = now();
        DB::table('evaluation')->insertOrIgnore([
            ['matiere' => 'Algorithmique', 'type_evaluation' => 'examen',],
            ['matiere' => 'Mathematiques', 'type_evaluation' => 'devoir',],
            ['matiere' => 'Programmation', 'type_evaluation' => 'tp',],
            ['matiere' => 'Systèmes', 'type_evaluation' => 'examen_pratique',],
        ]);
    }
}
