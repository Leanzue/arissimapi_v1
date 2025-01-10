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
            $table->string('description')->comment('description de la requête');
            $table->string('adresse')->comment('adresse de la Sim');
            $table->date('date')->comment('date de résolution de la requête');
            $table->integer('creation')->comment('création de la requête');
            $table->integer('code')->comment('genération du code requete');

            $table->foreignId('request_status_id')->nullable()
                ->comment('request_status_reference')
                ->constrained('request_statuses')->onDelete('set null');

            $table->foreignId('request_type_id')->nullable()
                ->comment('request_type reference')
                ->constrained('request_types')->onDelete('set null');

            $table->foreignId('sim_id')->nullable()
                ->comment('sim reference')
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
                $table->dropForeign(['request_status_id']);
                $table->dropForeign(['request_type_id']);
                $table->dropForeign(['sim_id']);
                $table->dropBaseForeigns();
            });
            Schema::dropIfExists($this->table_name);
        }
    }
};
