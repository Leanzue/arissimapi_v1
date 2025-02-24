<?php

namespace App\Console\Commands\SimRequest;

use Illuminate\Console\Command;

class SimRequestParseResponse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simrequest:parse-response';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Traitement des Reponses provenant du Batch';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //1. Chemin de fichier de log
    }
}
