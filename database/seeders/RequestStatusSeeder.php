<?php

namespace Database\Seeders;


use App\Models\SimRequest\RequestStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;



class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RequestStatus::updateOrNew("waiting", "En Attente","-1",-1);
        RequestStatus::updateOrNew("running", "En Cours","2",2);
        RequestStatus::updateOrNew("ended", "Terminé","1",1);
        RequestStatus::updateOrNew("suspended", "Suspendu","0",0);
    }

}
