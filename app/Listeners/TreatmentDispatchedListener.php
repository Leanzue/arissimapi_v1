<?php

namespace App\Listeners;

use App\Events\TreatmentDispatchedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        //
    }
}
