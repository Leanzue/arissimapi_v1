<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{     use BaseMigrationTrait;

    public $table_name = 'attempt_statuses';
    public $table_comment = 'attempt_statuses of objects in the system.';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->integer('nombre_essais')->comment('le nombre des essais');
            $table->string('error_code')->comment('le code erreur');
            $table->string('details')->comment('détails de la tentative');
            $table->string('statut')->comment('statut de la tentative');
            $table->string('comment')->nullable()->comment('les commentaires sur la tentative');

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
