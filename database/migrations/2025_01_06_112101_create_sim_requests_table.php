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
            $table->string('adresse_ip')->comment('adresse de la Sim');
            $table->timestamp('date')->nullable()->comment('date de résolution de la requête');
            $table->string('code')->comment('genération du code requete');
            $table->string('file_prefix')->nullable()->comment('file_prefix');
            $table->string('file_extension')->nullable()->comment('file_extension');

            $table->foreignId('request_status_id')->nullable()
                ->comment('request_status_reference')
                ->constrained('request_statuses')->onDelete('set null');

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
                $table->dropForeign(['request_status_id']);
                $table->dropForeign(['request_type_id']);
                $table->dropForeign(['sim_id']);
                $table->dropBaseForeigns();
            });
            Schema::dropIfExists($this->table_name);
        }
    }
};
