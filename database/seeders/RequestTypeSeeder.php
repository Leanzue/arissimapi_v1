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
                  'code'=>'',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'action' => 'refuser',
                'libellé' => 'Demande de refus',
                'code'=>'',
            ],
        ];

        foreach ($data as $entry) {
            RequestType::create($entry);
        }
        RequestType::updateOrNew("approuver","Demande d\'approbation","kkk");
    }
}
