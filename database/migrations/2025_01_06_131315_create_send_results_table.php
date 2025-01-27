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
            $table->integer('nombre_tentative')->comment('le nombre de tentative');
            $table->date('date_envoi')->comment('la date envoie');
            $table->string('error_code')->comment('code erreur');

            $table->foreignId('treatement_result_id')->nullable()
            ->comment('treatement_result_reference')
            ->constrained('treatement_results')->onDelete('set null');

            $table->baseFields();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropForeign(['treatement_result_id']);
            $table->dropBaseForeigns();
        });
        Schema::dropIfExists($this->table_name);
    }
};
