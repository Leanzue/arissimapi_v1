<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\TreatmentFailedEvent;
use App\Events\TreatmentDispatchedEvent;
use App\Models\TreatmentAttempt\Treatment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\TreatmentAttempt\TreatmentAttempt;

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
     */
    public function handle(TreatmentFailedEvent $event): void
    {
        Log::info("TreatmentFailedListener: " . get_class($event->hastreatment));
        $event->hastreatment;

        $event->hastreatment->setFailed();

        if ( get_class($event->hastreatment) === Treatment::class ) {
            // Cas de Treatment
            TreatmentFailedEvent::dispatch($event->hastreatment->treatmentattempt);
        } elseif ( get_class($event->hastreatment) === TreatmentAttempt::class ) {
            // Cas de TreatmentAttempt
            $event->hastreatment->simrequest->setFailed();
        }
    }
}
