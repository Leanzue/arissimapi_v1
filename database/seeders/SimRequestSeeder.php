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
                'adresse ip' => '192.168.1.1',
                'date' => '2025-01-21',
                'code' => 'SIM2025001',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'description' => 'rejet de demande ',
                'adresse ip' => '192.168.1.2',
                'date' => '2025-01-21',
                'code' => 'SIM2025002',
            ],

        ];

        foreach ($data as $entry) {
            SimRequest::create($entry);
        }
    }
}
