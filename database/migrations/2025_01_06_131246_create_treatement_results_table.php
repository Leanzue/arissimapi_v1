<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;
use Egulias\EmailValidator\Parser\Comment;

return new class extends Migration
{   use BaseMigrationTrait;

    public $table_name = 'treatement_results';
    public $table_comment = 'treatement_results of objects in the system.';

    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('date_tentative');
            $table->string('details')->comment('description du resultat de traitement');
            $table->string('resultat')->Comment('le resultat');
            $table->string('comment')->nullable()->comment('commentaire');

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
    }
};

