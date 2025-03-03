<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\TreatmentDispatchedEvent;
use App\Models\TreatmentAttempt\Treatment;
use App\Models\TreatmentAttempt\TreatmentAttempt;

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
     */
    public function handle(TreatmentDispatchedEvent $event): void
    {
        Log::info("TreatmentDispatchedListener: " . get_class($event->hastreatment));

        $event->hastreatment->setQueueing();

        if ( get_class($event->hastreatment) === Treatment::class ) {
            // Cas de Treatment
            $event->hastreatment->treatmentattempt->subTreatmentDispatched($event->hastreatment);
        } elseif ( get_class($event->hastreatment) === TreatmentAttempt::class ) {
            // Cas de TreatmentAttempt
            $event->hastreatment->simrequest->subTreatmentDispatched($event->hastreatment);
        }
    }
}
