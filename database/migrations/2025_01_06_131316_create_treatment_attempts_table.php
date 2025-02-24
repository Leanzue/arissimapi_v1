<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{    use BaseMigrationTrait;

    public $table_name = 'treatment_attempts';
    public $table_comment = 'treatmentattempts of objects in the system.';

    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->timestamp('date_debut')->comment('date de debut du traitement');
            $table->timestamp('date_fin')->nullable()->comment('date de fin du traitement');

            $table->string('description')->comment('decrisption du traitement');

            $table->foreignId('attempt_status_id')->nullable()
                ->comment('attempt status reference')
                ->constrained('attempt_statuses')->onDelete('set null');

            $table->foreignId('user_id')->nullable()
                ->comment('user reference')
                ->constrained('users')->onDelete('set null');

            $table->foreignId('sim_request_id')->nullable()
                ->comment('sim request reference')
                ->constrained('sim_requests')->onDelete('set null');

            $table->foreignId('attempt_result_id')->nullable()
                ->comment('treatement result reference')
                ->constrained('attempt_results')->onDelete('set null');

            $table->baseFields();
        });
    }

    public function down(): void
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropForeign(['attempt_status_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['sim_request_id']);
            $table->dropForeign(['attempt_result_id']);

            $table->dropBaseForeigns();
        });
        Schema::dropIfExists($this->table_name);
    }
};
