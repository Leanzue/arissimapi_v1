<?php

namespace Tests\Feature;

use App\Models\Treatment\Treatment;
use App\Models\SimRequest\SimRequest;
use App\Models\Treatment\TreatmentAttempt;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaxfailedRequeteExecutionBatchTest extends TestCase
{

    use RefreshDatabase;

    public function test_Maxfailed_requete_execution_batchTest(): void
    {
        $response = $this->get('api/simrequests');
        $response->assertStatus(200);
    }

    /**
     * Crée les données initiales nécessaires pour le test.
     */
    public function test_createInitialData()
    {
        $simRequest = SimRequest::create([
            'client_ip_address' => '127.0.0.1',
            'description' => '',
            'url_response' => 'http://example.com',
            'file_extension' => 'json',
            'treatment_status_id'=>'',
            'client_key_request' => 'arissimapi.localggg'
        ]);

        $treatment = Treatment::create([
            'sim_request_id' => $simRequest->id,
            'treatment_status_id' => '1',
        ]);

        $treatmentAttempt = TreatmentAttempt::create([
            'treatment_id' => $treatment->id,
            'treatment_status_id' => '1',
        ]);

        return [$simRequest, $treatment, $treatmentAttempt];
    }

    /**
     * Simule une exécution échouée et met à jour les statuts pour "MaxFailed".
     */
    public function test_simulateMaxFailed($simRequest, $treatment, $treatmentAttempt)
    {
        // Mise à jour des statuts pour MaxFailed
        $simRequest->update(['treatment_status_id' => '7', 'result' => '-1 (échec)']);
        $treatment->update(['treatment_status_id' => '6', 'result' => '-1 (échec)']);
        $treatmentAttempt->update(['treatment_status_id' => '7', 'result' => '-1 (échec)']);
    }

    /**
     * Vérifie les statuts mis à jour dans la base de données après l'échec.
     */
    public function test_verifyDatabaseStatuses($simRequest, $treatment, $treatmentAttempt)
    {
        $this->assertDatabaseHas('sim_requests', [
            'id' => $simRequest->id,
            'treatment_status' => '7',
            'result' => '-1 (échec)',
        ]);

        $this->assertDatabaseHas('treatment_attempts', [
            'id' => $treatmentAttempt->id,
            'treatment_status_id' => '7',
            'result' => '-1 (échec)',
        ]);

        $this->assertDatabaseHas('treatments', [
            'id' => $treatment->id,
            'treatment_status_id' => '6',
            'result' => '-1 (échec)',
        ]);
    }
}
