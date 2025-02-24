<?php

namespace Database\Seeders;

use App\Models\SimRequest;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SimRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'description' => 'Demande de validation',
                'adresse_ip' => '192.168.1.1',
                'date' => '2025-01-21',
                'code' => 'SIM2025001',
                'file_prefix'=>'f866d0a0',
                'file_extension'=>'csv',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'description' => 'rejet de demande ',
                'adresse_ip' => '192.168.1.2',
                'date' => '2025-01-21',
                'code' => 'SIM2025002',
                'file_prefix'=>'9e4206fa',
                'file_extension'=>'csv',
            ],

        ];

        foreach ($data as $entry) {
            SimRequest::create($entry);
        }
        SimRequest::updateOrNew("demande de validation ","192.168.1.1","2025-01-21", "sims 2025001","f866d0a0","csv");
    }
}
