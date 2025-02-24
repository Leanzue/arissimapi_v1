<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'send_attempts';
    public $table_comment = 'send attempts of objects in the system.';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table_name,
            function (Blueprint $table) {
                $table->id();
                $table->string('response_data')->nullable()->comment('les données de réponses');
                $table->dateTime('response_time')->nullable()->comment('heure');

                $table->foreignId('send_status_id')->nullable()
                    ->comment('send_status_reference')
                    ->constrained('send_statuses')->onDelete('set null');

                $table->foreignId('send_attempt_result_id')->nullable()
                    ->comment('send_attempt_result_reference')
                    ->constrained('send_attempt_results')->onDelete('set null');

                $table->baseFields();

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         {    Schema::table($this->table_name, function (Blueprint $table) {
                $table->dropForeign(['send_status_id']);
                $table->dropForeign(['send_attempt_result_id']);
                $table->dropBaseForeigns();
            });
            Schema::dropIfExists($this->table_name);
        }
    }
};

