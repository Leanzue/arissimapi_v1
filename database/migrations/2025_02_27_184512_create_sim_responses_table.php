<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sim_responses', function (Blueprint $table) {
            $table->id();

            $table->string('iccid')->comment('iccid');
            $table->string('status')->comment('status');
            $table->string('status_change_date')->comment('status_change_date');
            $table->string('client_key_request')->nullable()->comment('client_key_request');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sim_responses');
    }
};
