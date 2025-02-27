<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'sim_request_response_files';
    public $table_comment = 'fichiers reponse generes par le batch';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('iccid')->nullable()->comment('les données de réponses');
            $table->string('status')->nullable()->comment('les données de réponses');
            $table->string('status_change_date_str')->nullable()->comment('les données de réponses');
            $table->timestamp('status_change_date')->nullable()->comment('les données de réponses');

            $table->foreignId('sim_request_id')->nullable()
                ->comment('sim_request reference')
                ->constrained('sim_requests')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropForeign(['sim_request_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
};
