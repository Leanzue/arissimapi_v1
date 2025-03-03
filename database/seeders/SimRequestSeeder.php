<?php

namespace Database\Seeders;

use App\Models\Sim\Sim;
use Illuminate\Database\Seeder;
use App\Models\SimRequest\SimRequest;

class SimRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SimRequest::updateOrNew(Sim::find(1),"192.168.1.1", "http://arissimapi.local/api/simresponses","csv");
    }
}
