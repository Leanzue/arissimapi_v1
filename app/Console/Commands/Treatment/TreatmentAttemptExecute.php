<?php

namespace App\Console\Commands\Treatment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Treatment\TreatmentAttempt;

class TreatmentAttemptExecute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'treatment:attempt-exec';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("Exec TreatmentAttemptExecute.");
        // 1. Recuperer les tentatives en attente
        $attempts = TreatmentAttempt::getTreatmentsToBeExecuted();
        //dd(count($waiting_requests));
        if (count($attempts) === 0) {
            // retourner un message pour signifier
            $this->info("aucune tentative en attente");
            Log::info("Aucune Tentative en attente !");
        } else {
            // 2. Parcour des requetes en vue de:
            foreach ($attempts as $waiting_attempt){
                $waiting_attempt->execAttempt();
                // Ajouter un message de confirmation pour la fin du traitement
                $this->info("TreatmentAttempt exécutée avec succès.");
                Log::info("TreatmentAttempt exécutée avec succès pour toutes les tentatives en attente.");
            }
        }
    }
}
