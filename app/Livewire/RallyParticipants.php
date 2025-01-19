<?php

namespace App\Livewire;

use App\Models\Rally;
use Livewire\Component;

class RallyParticipants extends Component
{
    public $rallyId;
    public $latestQrExpireAt;
    public $participants = [];

    protected $listeners = ['participantScanned' => 'updateParticipants'];

    public function mount($rallyId)
    {
        $this->rallyId = $rallyId;
        $this->updateQrExpireAt();
        $this->updateParticipants();
    }

    public function updateQrExpireAt()
    {
        $this->latestQrExpireAt = Rally::findOrFail($this->rallyId)
            ->teams()
            ->orderByDesc('qr_expire_at')
            ->value('pivot_qr_expire_at');
    }

    public function updateParticipants()
    {
        if ($this->latestQrExpireAt) {
            $this->participants = Rally::findOrFail($this->rallyId)
                ->teams()
                ->wherePivot('qr_expire_at', $this->latestQrExpireAt)
                ->wherePivotNotNull('scanned_at')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.rally-participants', [
            'participants' => $this->participants,
        ]);
    }
}
