<?php

namespace App\Events;

use App\Contrats\IHasTreatment;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TreatmentFailedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var IHasTreatment
     */
    public $hastreatment;

    /**
     * Create a new event instance.
     * @param IHasTreatment $hastreatment
     */
    public function __construct($hastreatment) {
        $this->hastreatment = $hastreatment;
        Log::info("TreatmentFailedEvent, " . get_class($hastreatment));
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
