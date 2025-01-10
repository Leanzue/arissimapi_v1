<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'send_attempt_results';
    public $table_comment = 'sendattemptresults of objects in the system.';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->date('date_of_sending_result')->comment('indique la date d\'envoi');
            $table->string('details')->comment('description de l\'envoi');
            $table->integer('error_code')->comment('indique le code d\'erreur');
            $table->integer('nombre_de_tentative')->comment('détermine le nombre de tentatives');

            $table->baseFields();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropBaseForeigns();
        });
        Schema::dropIfExists($this->table_name);
    }
};
