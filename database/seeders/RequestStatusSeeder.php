<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\RequestStatus;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'priority' => '',
                'libellé' => '',

            ],
            [
                'uuid' => (string) Str::uuid(),
                'priority' => '',
                'libellé' => '',

            ],
        ];

        foreach ($data as $entry) {
            RequestStatus::create($entry);
        }
    }
}
