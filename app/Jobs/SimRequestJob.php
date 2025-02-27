<?php

namespace App\Jobs;

use App\Models\TreatmentAttempt\Treatment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;


class SimRequestJob implements ShouldQueue
{
    use Queueable;


    /**
     * @var int
     */
    public $treatment_id;
    public  $value;

    /**
     * Create a new job instance.
     */
    public function __construct($treatment)
    {
        // spécifier la file d'attente
        $this->onQueue(SimRequestJob::$treatment->value);

        // set queueing
          $treatment->setQueueing();
        // assign id
        $this->treatment_id = $treatment->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $treatment = Treatment::getById($this->treatment_id);

        // on instancie le service a executer
        $treatment->service = new $this->service_class();


        // On execute le service
        $result = $this->service->execTreatment($this);

        // Setter le statut en fonction du resultat
        $result->save();
        if ($result->resultat === 0) {
            // aucun traitement
            $this->setWaiting();
        } elseif ($result->resultat === 1) {
            // succes traitement
            $this->setSuccess();
        } elseif ($result->resultat === -1) {
            // échec traitement
            $this->setFailed();
        } elseif ($result->resultat === 2) {
            // traitement suspendu
            $this->setSuspended();
        }
    }
}
