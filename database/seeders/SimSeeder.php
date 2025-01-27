<?php

namespace Database\Seeders;

use App\Models\Sim;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'iccid' => '8901234567890123456',
                'imsi' => '123456789012345',
                'puk' => '12345678',
                'pin' => '1234',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'iccid' => '8901234567890123457',
                'imsi' => '123456789012346',
                'puk' => '87654321',
                'pin' => '4321',
            ],

        ];

        foreach ($data as $entry) {
            Sim::create($entry);
        }
    }
}
