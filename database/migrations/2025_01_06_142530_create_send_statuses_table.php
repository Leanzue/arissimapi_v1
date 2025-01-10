<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

return new class extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'send_statuses';
    public $table_comment = 'send statuses of objects in the system.';

    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('status_description');

            $table->baseFields();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table_name);
    }
};
