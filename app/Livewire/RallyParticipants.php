<?php

namespace App\Livewire;

use App\Models\Rally;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;

class RallyParticipants extends Component
{
    public $rallyId;
    public $latestQrExpireAt;
    public $participants = [];

    protected $listeners = ['participantScanned' => 'updateParticipants'];

    public function mount($rallyId = null)
    {
        $this->rallyId = $rallyId;
        $this->updateQrExpireAt();
        $this->updateParticipants();
    }

    #[On('rallyIdUpdated')]
    public function updateRallyId($rallyId)
    {
        $this->rallyId = $rallyId;
        $this->updateQrExpireAt();
        $this->updateParticipants();
    }

    public function updateQrExpireAt()
    {
        if (!$this->rallyId) {
            Log::error("Rally ID is null, skipping QR expiration check.");
            return;
        }

        $rally = Rally::find($this->rallyId);

        if (!$rally) {
            Log::error("Rally ID {$this->rallyId} not found.");
            return;
        }

        Log::info("Fetching latest QR expiration for rally ID: {$this->rallyId}");

        $this->latestQrExpireAt = $rally->teams()
            ->orderByDesc('rally_histories.qr_expired_at')
            ->pluck('rally_histories.qr_expired_at')
            ->first();

        Log::info("Latest QR Expire At: " . ($this->latestQrExpireAt ?? 'NULL'));
    }


    public function updateParticipants()
    {
        if (!$this->rallyId) {
            Log::error("Rally ID is null, skipping participant update.");
            return;
        }

        $rally = Rally::find($this->rallyId);
        if (!$rally) {
            Log::error("Rally ID {$this->rallyId} not found.");
            return;
        }

        if ($this->latestQrExpireAt) {
            $this->participants = $rally->teams()
                ->wherePivot('qr_expired_at', $this->latestQrExpireAt)
                ->wherePivotNotNull('scanned_at')
                ->withPivot('scanned_at')
                ->get()
                ->map(fn($team) => [
                    'name' => $team->name,
                    'scanned_at' => $team->pivot->scanned_at,
                ])
                ->toArray();

            Log::info("Participants updated:", $this->participants);
        }
    }

    public function render()
    {
        return view('livewire.rally-participants', [
            'participants' => $this->participants,
            'latestQrExpireAt' => $this->latestQrExpireAt,
        ]);
    }
}
