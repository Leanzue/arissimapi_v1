<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\TreatmentFailedEvent;
use App\Events\TreatmentDispatchedEvent;
use App\Models\Treatment\Treatment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Treatment\TreatmentAttempt;

class TreatmentFailedListener
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
     * @param TreatmentFailedEvent $event
     */
    public function handle(TreatmentFailedEvent $event): void
    {
        Log::info("TreatmentFailedListener: " . get_class($event->hastreatment) . " (" . $event->hastreatment->id . ")");

        $event->hastreatment->setFailed();
        $event->hastreatment->uppertreatment->subTreatmentStatusChanged($event->hastreatment);
    }
}
