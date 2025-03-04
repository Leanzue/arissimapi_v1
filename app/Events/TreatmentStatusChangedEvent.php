<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Contrats\Treatment\IHasTreatment;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TreatmentStatusChangedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var IHasTreatment
     */
     public $hastreatment;
    /**
     * TreatmentStatusChangedEvent constructor.
     * @param $hastreatment
     */
    public function __construct($hastreatment)
    {
        $this->hastreatment = $hastreatment;
        Log::info("TreatmentStatusChangedEvent, " . get_class($hastreatment) . " (" . $hastreatment->id . ")");
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
