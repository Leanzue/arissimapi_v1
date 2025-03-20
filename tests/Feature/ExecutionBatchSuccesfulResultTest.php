<?php

namespace Tests\Feature;

use App\Models\Treatment\Treatment;
use App\Models\SimRequest\SimRequest;
use App\Models\Treatment\TreatmentAttempt;
use Tests\TestCase;


class ExecutionBatchSuccesfulResultTest  extends TestCase
{

    public function test_Execution_batch_a_succesful_resultTest(): void
    {
        $response = $this->get('api/simrequests');
        $response->assertStatus(200);
    }
    /**
     * Création des données nécéssaires
     */
    public function test_createInitialData()
    {
        $simRequest = SimRequest::create([
            'client_ip_address' => '127.0.0.1',
            'url_response' => 'http://example.com',
            'file_extension' => 'json',
            'description' => '',
            'treatment_status_id'=>'',
            'client_key_request' => 'arissimapi.localggg',
        ]);

        $treatment = Treatment::create([
            'sim_request_id' => $simRequest->id,
            'treatment_status' => '1',
        ]);

        $treatmentAttempt = TreatmentAttempt::create([
            'treatment_id' => $treatment->id,
            'treatment_status' => '1',
        ]);

        return [$simRequest, $treatment, $treatmentAttempt];
    }

    /**
     * Simule l'exécution du batch.
     */
    public function test_simulateBatchExecution($simRequest)
    {
        $response = $this->post('/exec_batch_service', [
            'sim_request_id' => $simRequest->id,
        ]);

        $response->assertStatus(200); // Statut attendu après exécution
    }

    /**
     * Met à jour les statuts des entités après exécution.
     */
    public function test_updateStatuses($simRequest, $treatment, $treatmentAttempt)
    {
        $simRequest->update(['treament_status_id' => '5']);
        $treatment->update(['treament_status_id' => '5']);
        $treatmentAttempt->update(['treament_status_id' => '5']);
    }

    /**
     * Vérifie les changements dans la base de données.
     */
    public function test_verifyDatabaseStatuses($simRequest, $treatment, $treatmentAttempt)
    {
        $this->assertDatabaseHas('sim_requests', [
            'id' => $simRequest->id,
            'treatment_status' => '5',
        ]);

        $this->assertDatabaseHas('treatments', [
            'id' => $treatment->id,
            'treatment_status' => '5',
        ]);

        $this->assertDatabaseHas('treatment_attempts', [
            'id' => $treatmentAttempt->id,
            'treatment_status' => '5',
        ]);
    }

}
