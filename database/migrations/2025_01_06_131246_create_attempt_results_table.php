<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;
use Egulias\EmailValidator\Parser\Comment;

return new class extends Migration
{   use BaseMigrationTrait;

    public $table_name = 'attempt_results';
    public $table_comment = 'attempt_results of objects in the system.';

    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->integer('resultat')->default(0)->Comment('le resultat: 0 = aucun, 1 = succeès, -1 = echec');
            $table->string('libelle')->default("aucun")->Comment('libelle du resultat');
            $table->string('details')->comment('string description du resultat de traitement');

            $table->baseFields();
        });
        $this->setTableComment($this->table_name,$this->table_comment);
    }

    public function down(): void
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropBaseForeigns();
        });
        Schema::dropIfExists($this->table_name);
    ;}
};

