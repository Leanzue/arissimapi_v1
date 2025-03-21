<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SimRequest\SimRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BatchServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');

        // on tronque la table du modèle simrequest dans la base de données
        Schema::disableForeignKeyConstraints();
        Log::info("SimRequest::getTableName(): " . SimRequest::getTableName());
        DB::statement("TRUNCATE TABLE " . SimRequest::getTableName() . "");
        //DB::statement("TRUNCATE TABLE sim_requests");
        //SimRequest::query()->truncate();
        // db::table('SimRequest')->truncate();
        //SimRequest::truncate();
        Schema::enableForeignKeyConstraints();

    }

    public function test_an_SimRequest_can_be_stored_to_the_database()
    {
        // $user = $this->authenticated_user_admin();

        $response = $this->add_new_simrequest("new  iccid", "new client_key_request", "new url_response");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, SimRequest::all());
    }

      public function test_simrequest_required_fields_must_be_validated_before_creation()
    {

       // $user = $this->authenticated_user_admin();

        $response = $this->add_new_simrequest("","","");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['iccid','url_response']);
    }

    public function test_simrequest_can_be_updated()
    {
       // $user = $this->authenticated_user_admin();


        $response = $this->add_new_simrequest("new iccid", "new url_response", "new client_key_request");

        $newsimrequest = SimRequest::first();

        $this->update_existing_simrequest($newsimrequest, "new iccid upd", "new url_response upd", "new client_key_request upd");

        $newsimrequest->refresh();


        $this->assertEquals('new iccid upd', $newsimrequest->iccid);
        $this->assertEquals('new url_response upd', $newsimrequest->url_response);
        $this->assertEquals('new client_key_request upd', $newsimrequest->client_key_request);
    }
/*
    public function test_simrequest_can_be_deleted()
    {
        $response = $this->add_new_simrequest("new iccid", "new url_response", "new client_key_request");

        // Récupérer la première SimRequest
        $newsimrequest = SimRequest::first();


        $this->delete('api/simrequests/' . $newsimrequest->uuid);
        $this->assertCount(0, SimRequest::all());
    }*/


    private function add_new_SimRequest($iccid, $url_response, $client_key_request)
    {
        $new_data = [
            'iccid' => $iccid,
            'url_response' => $url_response,
            'client_key_request' => $client_key_request,
        ];

        return $this->post('api/simrequests', $new_data);
    }
   private function update_existing_simrequest($existing_simrequest,$iccid, $url_response, $client_key_request)
    {
        $new_data = [
            'iccid' => $iccid,
            'client_key_request' => $client_key_request,
            'url_response' => $url_response,
        ];

        return $this->put('api/simrequests/' . $existing_simrequest->uuid, $new_data);
    }
}
