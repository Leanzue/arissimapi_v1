<?php

namespace Tests\Feature;

use App\Models\Treatment\Treatment;
use App\Models\SimRequest\SimRequest;
use App\Models\Treatment\TreatmentAttempt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function League\Uri\Idna\description;

class ExecutionBatchFailureTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_execution_batch_a_failureTest(): void
    {
        $response = $this->get('api/simrequests');

        $response->assertStatus(200);
    }
    /**
     * Crée une entrée SimRequest avec des données initiales.
     */
    public function test_createSimRequest(): SimRequest
    {
        return SimRequest::create([
            'client_ip_address' => '127.0.0.1',
            'description' => '',
            'url_response' => 'http://example.com',
            'file_extension' => 'json',
            'client_key_request' => 'arissimapi.localggg',
        ]);
    }

    /**
     * Crée une entrée Treatment associée à un SimRequest.
     */
    public function test_createTreatment(SimRequest $simRequest): Treatment
    {
        return Treatment::create([
            'sim_request_id' => $simRequest->id,
            'treatment_status_id' => 'failed',
            'result' => '-1 (échèc)',
            'date_debut' => now(),
            'date_fin' => now(),
        ]);
    }

    /**
     * Crée une entrée TreatmentAttempt associée à un Treatment.
     */
    public function test_createTreatmentAttempt(Treatment $treatment): TreatmentAttempt
    {
        $treatment = $treatment ?? Treatment::factory()->create();
        return TreatmentAttempt::create([
            'treatment_id' => $treatment->id,
            'treatment_status_id' => 'failed',
            'result' => '0 (en cours)',
            'date_debut' => now(),
            'date_fin' => '',
        ]);
    }

    /**
     * Simule les échecs pour les données de test.
     */
    public function test_simulateFailure(SimRequest $simRequest, Treatment $treatment, TreatmentAttempt $treatmentAttempt): void
    {
        $simRequest->update(['treatment_status_id' => '6', 'result' => '0 (en cours)', 'date_fin' => now()]);
        $treatment->update(['treatment_status_id' => '6', 'result' => '-1 (échèc)', 'date_fin' => now()]);
        $treatmentAttempt->update(['treatment_status_id' => '6', 'result' => '0 (en cours)', 'date_fin' => now()]);
    }

    /**
     * Vérifie les données mises à jour dans la base de données.
     */
    public function test_verifyDatabaseEntries(SimRequest $simRequest, Treatment $treatment, TreatmentAttempt $treatmentAttempt): void
    {
        $this->assertDatabaseHas('sim_requests', [
            'id' => $simRequest->id,
            'treatment_status_id' => '6',
            'result' => '0 (en cours)',
            'date_debut' => $simRequest->date_debut,
            'date_fin' => $simRequest->date_fin,
        ]);

        $this->assertDatabaseHas('treatments', [
            'id' => $treatment->id,
            'treatment_status_id' => '6',
            'result' => '-1 (échèc)',
            'date_debut' => $treatment->date_debut,
            'date_fin' => $treatment->date_fin,
        ]);

        $this->assertDatabaseHas('treatment_attempts', [
            'id' => $treatmentAttempt->id,
            'treatment_status_id' => '6',
            'result' => '0 (en cours)',
            'date_debut' => $treatmentAttempt->date_debut,
            'date_fin' => $treatmentAttempt->date_fin
        ]);
    }
}


