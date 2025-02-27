<?php

namespace Database\Seeders;


use App\Models\Sim\Sim;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sim::updateOrNew("8901234567890123456 ","123456789012345","87654321", "4321");
    }
}
