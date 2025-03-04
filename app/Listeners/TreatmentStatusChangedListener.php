<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\TreatmentStatusChangedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TreatmentStatusChangedListener
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
     * @param TreatmentStatusChangedEvent $event
     */
    public function handle(TreatmentStatusChangedEvent $event): void
    {
        Log::info("TreatmentStatusChangedListener: " . get_class($event->hastreatment) . " (" . $event->hastreatment->id . "), status: " . $event->hastreatment->treatmentstatus?->code);

        if ($event->hastreatment->uppertreatment) {
            $event->hastreatment->uppertreatment->subTreatmentStatusChanged($event->hastreatment);
        }
    }

}
