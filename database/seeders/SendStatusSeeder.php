<?php

namespace Database\Seeders;

use App\Models\SendStatus;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SendStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'priority' => 'haute',
                'libellé' => 'En cours de traitement',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'priority' => 'basse',
                'libellé' => 'En attente',
            ],

        ];

        foreach ($data as $entry) {
            SendStatus::create($entry);
        }
    }
}
