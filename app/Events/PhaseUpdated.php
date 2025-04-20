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

    public $phase;

    public function __construct($phase)
    {
        $this->phase = $phase;
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
            'phase_id' => $this->phase->id,
            'phase' => $this->phase->phase,
            'end_time' => $this->phase->end_time
        ];
    }
}
