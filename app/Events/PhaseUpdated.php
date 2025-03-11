<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PhaseUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $phaseId;

    public function __construct($phaseId)
    {
        $this->phaseId = $phaseId;
    }

    public function broadcastOn()
    {
        return new Channel("phase-updates");
    }

    public function broadcastAs()
    {
        return "PhaseUpdated";
    }

    public function broadcastWith()
    {
        return [
            'phase_id' => $this->phaseId
        ];
    }
}
