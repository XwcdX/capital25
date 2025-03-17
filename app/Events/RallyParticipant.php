<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RallyParticipant implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rallyHistory;

    public function __construct($rallyHistory)
    {
        $this->rallyHistory = $rallyHistory;
    }

    public function broadcastOn()
    {
        $rallyId = $this->rallyHistory->first()->pivot->rally_id ?? null;
        $phaseId = $this->rallyHistory->first()->pivot->phase_id ?? null;

        return new Channel("rally.{$rallyId}.phase.{$phaseId}");
    }

    public function broadcastAs()
    {
        return 'rally.history.updated';
    }

    public function broadcastWith()
    {
        return [
            'rallyHistory' => $this->rallyHistory
        ];
    }
}
