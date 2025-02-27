<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'treatments';
    public $table_comment = 'treatments élémentaire (exécution d\'un service)';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('service_class')->comment('classe service de la tentative (qui s execute)');
            $table->string('libelle_service')->comment('libelle du service de la tentative (qui s execute)');
            $table->timestamp('date_debut')->comment('date de debut du traitement');
            $table->timestamp('date_fin')->nullable()->comment('date de fin du traitement');
            $table->string('description')->nullable()->comment('decrisption de la tentative');

            $table->foreignId('treatment_attempt_id')->nullable()
                ->comment('treatement attempt reference')
                ->constrained('treatment_attempts')->onDelete('set null');

            $table->foreignId('treatment_status_id')->nullable()
                ->comment('attempt status reference')
                ->constrained('treatment_statuses')->onDelete('set null');

            $table->baseFields();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropForeign(['treatment_attempt_id']);
            $table->dropForeign(['treatment_status_id']);

            $table->dropBaseForeigns();
        });
        Schema::dropIfExists($this->table_name);

    }
};
