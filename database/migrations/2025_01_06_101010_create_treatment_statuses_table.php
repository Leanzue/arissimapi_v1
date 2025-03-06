<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{     use BaseMigrationTrait;

    public $table_name = 'treatment_statuses';
    public $table_comment = 'les statuts des Traitemenst du Systeme.';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('code')->comment('le code du statut');
            $table->string('libelle')->comment('le libelle du statut');
            $table->string('description')->nullable()->comment('la description du statut');

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
