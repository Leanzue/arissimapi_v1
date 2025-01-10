<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{    use BaseMigrationTrait;

    public $table_name = 'treatement_attempts';
    public $table_comment = 'treatementattempts of objects in the system.';

    public function up(): void
    {    {
            Schema::create($this->table_name, function (Blueprint $table) {
                $table->id();

                $table->date('date_debut')->comment('date de debut du traitement');
                $table->date('date_fin')->nullable()->comment('date de fin du traitement');
                $table->string('resultat')->comment('le resultat');
                $table->string('description')->comment('decrisption du traitement');

                $table->foreignId('attemptstatus_id')->nullable()
                ->comment('attempt status reference')
                ->constrained('attempt_statuses')
                ->onDelete('set null');

                /*$table->foreignId('attemptstatus_id')
                ->comment('attempt status reference')
                ->constrained(
                    table: 'attempt_statuses', indexName: $this->table_name . '_attemptstatus_id'
                )
                ->onDelete('set null')
                ;*/

                $table->foreignId('treatement_result_id')->nullable()
                ->comment('treatement_result_reference')
                ->constrained('treatement_results')->onDelete('set null');

                $table->baseFields();
            });

        }
    }

    public function down(): void
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropForeign(['attemptstatus_id']);
            $table->dropForeign(['treatement_result_id']);

            $table->dropBaseForeigns();
        });
        Schema::dropIfExists($this->table_name);
    }
};
