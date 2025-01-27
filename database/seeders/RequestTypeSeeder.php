<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\RequestType;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'action' => 'approuver',
                'libellé' => 'Demande d\'approbation',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'action' => 'refuser',
                'libellé' => 'Demande de refus',
            ],
        ];

        foreach ($data as $entry)
            RequestType::create($entry);
    }
}
