<?php

namespace App\Jobs\Treatment;

use App\Models\Treatment\Treatment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Events\TreatmentStatusChangedEvent;

class TreatmentJob implements ShouldQueue
{
    use Queueable;

    /**
     * @var int
     */
    public $treatment_id;

    /**
     * Create a new job instance.
     * @param Treatment $treatment
     */
    public function __construct($treatment)
    {
        $this->onQueue($treatment->service_class::getQueueName());
        $treatment->setQueueing();
        TreatmentStatusChangedEvent::dispatch($treatment);
        $this->treatment_id = $treatment->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Recuperer le Treatment
        $treatment = Treatment::getById($this->treatment_id);
        if ($treatment) {
            // s'il n'est null, on l'execute
            $treatment->executeTreatment();
        }
    }
}
