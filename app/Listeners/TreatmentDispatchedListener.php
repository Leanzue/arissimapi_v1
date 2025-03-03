<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\TreatmentDispatchedEvent;

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
        Log::info("TreatmentDispatchedListener: " . get_class($event->hastreatment) . " (" . $event->hastreatment->id . ")");

        $event->hastreatment->setQueueing();
        $event->hastreatment->uppertreatment->subTreatmentStatusChanged($event->hastreatment);
    }
}
