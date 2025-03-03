<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Models\Treatment\Treatment;
use App\Events\TreatmentSucceedEvent;
use App\Models\Treatment\TreatmentAttempt;

class TreatmentSucceedListener
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
     * @param TreatmentSucceedEvent $event
     */
    public function handle(TreatmentSucceedEvent $event): void
    {
        Log::info("TreatmentSuccessListener: " . get_class($event->hastreatment) . " (" . $event->hastreatment->id . ")");

        $event->hastreatment->setSuccess();
        $event->hastreatment->uppertreatment->subTreatmentStatusChanged($event->hastreatment);
    }
}
