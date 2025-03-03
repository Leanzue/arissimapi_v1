<?php

namespace App\Events;

use App\Contrats\IHasTreatment;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TreatmentSucceedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var IHasTreatment
     */
    public $hastreatment;
    /**
     * TreatmentSucceedEvent constructor.
     * @param $hastreatment
     */
    public function __construct($hastreatment)
    {
        $this->hastreatment = $hastreatment;
        Log::info("TreatmentSucceedEvent, " . get_class($hastreatment));

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
