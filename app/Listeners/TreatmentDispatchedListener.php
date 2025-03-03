<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Models\Treatment\Treatment;
use App\Events\TreatmentDispatchedEvent;
use App\Models\Treatment\TreatmentAttempt;

class TreatmentDispatchedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * @param TreatmentDispatchedEvent $event
     */
    public function handle(TreatmentDispatchedEvent $event): void
    {
        Log::info("TreatmentDispatchedListener: " . get_class($event->hastreatment));

        $event->hastreatment->setQueueing();
        $event->hastreatment->uppertreatment->subTreatmentDispatched($event->hastreatment);
    }
}
