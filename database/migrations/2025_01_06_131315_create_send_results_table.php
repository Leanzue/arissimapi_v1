<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'send_results';
    public $table_comment = 'send results of objects in the system.';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('result_description')->comment('description des résultats');
            $table->string('nombre_tentative')->comment('le nombre de tentative');
            $table->date('date_envoi')->comment('la date envoie');
            $table->string('error_code')->comment('code erreur');

            $table->foreignId('attempt_result_id')->nullable()
            ->comment('attempt_result_reference')
            ->constrained('attempt_results')->onDelete('set null');

            $table->baseFields();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropForeign(['attempt_result_id']);
            $table->dropBaseForeigns();
        });
        Schema::dropIfExists($this->table_name);
    }
};
