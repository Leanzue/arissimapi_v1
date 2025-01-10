<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

use function Laravel\Prompts\table;

return new class extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'statuses';
    public $table_comment = 'statuses of objects in the system.';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');

            $table->string('name')->comment('status name');
            $table->string('code', 100)->unique()->comment('status code');

            $table->string('style')->default('success')->comment('status style');
            $table->boolean('is_default')->default(false)->comment('determine whether is the default one.');
            $table->string('description', 500)->nullable()->comment('status description');

            $table->timestamps();
        });
        $this->setTableComment($this->table_name,$this->table_comment);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table_name);
    }
};
