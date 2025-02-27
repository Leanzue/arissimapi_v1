<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::updateOrNew("uuid ","name","code","style","1", "description");
        Status::updateOrNew("uuid ","name","code","style","1", "description");
        Status::updateOrNew("uuid ","name","code","style","1", "description");
        Status::updateOrNew("uuid" ,"name","code","style","1", "description");
    }
}
