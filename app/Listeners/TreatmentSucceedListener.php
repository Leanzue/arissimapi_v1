<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\TreatmentSucceedEvent;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\TreatmentAttempt\Treatment;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\TreatmentAttempt\TreatmentAttempt;

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
        Log::info("TreatmentSuccessListener: " . get_class($event->hastreatment));
        $event->hastreatment->setSuccess();

        if (get_class($event->hastreatment) === Treatment::class) {
            // Cas de Treatment
            $event->hastreatment->treatmentattempt->subTreatmentSucceed($event->hastreatment);
        } elseif (get_class($event->hastreatment) === TreatmentAttempt::class) {
            // Cas de TreatmentAttempt
            $event->hastreatment->simrequest->subTreatmentSucceed($event->hastreatment);
        }
    }
}
