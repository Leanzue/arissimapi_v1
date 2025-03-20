<?php

namespace Tests\Feature;

use App\Models\Treatment\Treatment;
use App\Models\SimRequest\SimRequest;
use App\Models\Treatment\TreatmentAttempt;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaxfailedExecutionBatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_Maxfailed_execution_batchTest(): void
    {
        $response = $this->get('api/simrequests');

        $response->assertStatus(200);
    }

    /**
     * Test pour le statut de SimRequest après échec.
     */
    public function test_sim_request_status_failed()
    {
        $simRequest = SimRequest::create([
            'client_ip_address' => '127.0.0.1',
            'url_response' => 'http://example.com',
            'file_extension' => 'json',
            'description' => '',
            'treatment_status_id'=>'',
            'client_key_request' => 'arissimapi.localggg',
        ]);

        // Simuler un échec
        $simRequest->update(['treatment_status_id' => '6']);

        // Vérifier les données
        $this->assertDatabaseHas('sim_requests', [
            'id' => $simRequest->id,
            'treatment_status_id' => '6',
        ]);
    }

    /**
     * Test pour le statut de TreatmentAttempt après MaxFailed.
     */
    public function test_treatment_attempt_status_maxfailed()
    {
        $treatmentAttempt = TreatmentAttempt::create([
         // 'treatment_status_id' => '1',
            //'result' => '0 (en cours)',
        ]);

        // Simuler un état MaxFailed
        $treatmentAttempt->update(['treatment_status_id' => '7']);

        // Vérifier les données
        $this->assertDatabaseHas('treatment_attempts', [
            'id' => $treatmentAttempt->id,
            'treatment_status_id' => '7',
        ]);
    }

    /**
     * Test pour le statut de Treatment après échec.
     */
    public function test_treatment_status_failed()
    {
        $treatment = Treatment::create([
         'treatment_status_id' => '1',
            'result' => '0 (en cours)',
            'service_class' => '',
        ]);
        // Simuler un échec
        $treatment->update(['treatment_status_id' => '6']);

        // Vérifier les données
        $this->assertDatabaseHas('treatments', [
            'id' => $treatment->id,
            'treatment_status_id' => '6',
            'service_class' => '',
        ]);
    }
}
