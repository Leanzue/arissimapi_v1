<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'sim_requests';
    public $table_comment = 'Sim_requests of objects in the system.';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('genération du code requete');
            $table->string('description')->comment('description de la requête');
            $table->string('client_ip_address')->comment('adresse du client');
            $table->integer('client_id_request')->comment('id de requete du client');
            $table->string('url_response')->comment('url pour envoie du resultat');
            $table->string('file_prefix')->nullable()->comment('file_prefix');
            $table->string('file_extension')->nullable()->comment('file_extension');

            $table->foreignId('treatment_status_id')->nullable()
                ->comment('attempt status reference')
                ->constrained('treatment_statuses')->onDelete('set null');

            $table->foreignId('request_type_id')->nullable()
                ->comment('request_type reference')
                ->constrained('request_types')->onDelete('set null');

            $table->foreignId('sim_id')->nullable()
                ->comment('sims reference')
                ->constrained('sims')->onDelete('set null');

            $table->baseFields();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         {    Schema::table($this->table_name, function (Blueprint $table) {
                $table->dropForeign(['treatment_status_id']);
                $table->dropForeign(['request_type_id']);
                $table->dropForeign(['sim_id']);
                $table->dropBaseForeigns();
            });
            Schema::dropIfExists($this->table_name);
        }
    }
};
