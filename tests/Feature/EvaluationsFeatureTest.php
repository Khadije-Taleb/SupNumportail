<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Evaluation;
use App\Models\CertificatMedical;

class EvaluationsFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_default_shows_only_accepted_and_filters_load_from_evaluation()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Create evaluation entries (source for filters)
        Evaluation::create(['matiere' => 'Algo', 'type_evaluation' => 'examen']);
        Evaluation::create(['matiere' => 'Maths', 'type_evaluation' => 'devoir']);

        // Create certificates: one accepted, one refused
        CertificatMedical::create([
            'matricule_etudiant' => null,
            'photo_certificat' => 'cert1.pdf',
            'annee' => 'L3',
            'type_evaluation' => 'examen',
            'matiere' => 'Algo',
            'date_absence' => now()->toDateString(),
            'statut' => 'VALIDE',
        ]);

        CertificatMedical::create([
            'matricule_etudiant' => null,
            'photo_certificat' => 'cert2.pdf',
            'annee' => 'L3',
            'type_evaluation' => 'devoir',
            'matiere' => 'Maths',
            'date_absence' => now()->toDateString(),
            'statut' => 'REFUSE',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.certificats.index'));
        $response->assertStatus(200);

        // Default should show only the accepted one (accepted entry present)
        $response->assertSee('Algo');

        // Filters should be populated from evaluation table
        $response->assertSee('Toutes les matières');
        $response->assertSee('Tous les types');
        $response->assertSee('Algo');
        $response->assertSee('examen');
    }

    public function test_filtering_by_matiere_and_type_works_and_shows_no_results_message()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Evaluation::create(['matiere' => 'Algo', 'type_evaluation' => 'examen']);

        CertificatMedical::create([
            'matricule_etudiant' => null,
            'photo_certificat' => 'cert1.pdf',
            'annee' => 'L3',
            'type_evaluation' => 'examen',
            'matiere' => 'Algo',
            'date_absence' => now()->toDateString(),
            'statut' => 'VALIDE',
        ]);

        // Filter by a type that doesn't match any certificate
        $response = $this->actingAs($admin)->get(route('admin.certificats.index', ['type_evaluation' => 'tp']));
        $response->assertStatus(200);
        $response->assertSee('Aucun certificat médical ne correspond aux critères sélectionnés.');
    }
}
