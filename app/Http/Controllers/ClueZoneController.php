<?php

namespace App\Http\Controllers;

use App\Models\ClueZone;
use App\Models\Phase;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ClueZoneController extends BaseController
{
    protected $teamController;
    public function __construct(ClueZone $zone)
    {
        parent::__construct($zone);
        $this->teamController = new TeamController(new Team());
    }
    public function buyTicket(Request $request)
    {
        $team = Auth::user();
        $currentPhaseInt = Cache::get("current_phase")->phase;
        $phase = Phase::where('phase', $currentPhaseInt)->first();
        if (!$phase) {
            return redirect()->back()->with('error', 'Current phase not found.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:4'
        ]);
        $quantityToBuy = (int) $request->input('quantity');

        $existingTicket = $this->model::where('team_id', $team->id)
            ->where('phase_id', $phase->id)
            ->first();

        $existingQuantity = $existingTicket ? $existingTicket->quantity : 0;
        if (($existingQuantity + $quantityToBuy) > 4) {
            return redirect()->back()->with('error', 'You can only buy up to 4 tickets in this phase.');
        }

        switch ($currentPhaseInt) {
            case 1:
                $ticketPrice = 1000;
                break;
            case 2:
                $ticketPrice = 2000;
                break;
            case 3:
                $ticketPrice = 4000;
                break;
            case 4:
                $ticketPrice = 8000;
                break;
            default:
                return redirect()->back()->with('error', 'Invalid phase.');
        }

        $totalPrice = $ticketPrice * $quantityToBuy;

        $reqs = new Request([
            'team_id' => $team->id,
            'transaction_type' => 'coin',
            'action' => 'debit',
            'amount' => $totalPrice,
            'description' => "Bought {$quantityToBuy} ticket(s) in phase {$currentPhaseInt}",
        ]);
        $resp = $this->teamController->updateBalance($reqs);
        $status = $resp->getStatusCode();
        $payload = $resp->getData(true);

        if ($status === 422 || empty($payload['success'] ?? null)) {
            $error = $payload['error'] ?? $payload['errors'] ?? 'Failed to update balance';
            return redirect()->back()->with('error', $error);
        }

        if ($existingTicket) {
            $existingTicket->quantity += $quantityToBuy;
            $existingTicket->price += $totalPrice;
            $existingTicket->save();
        } else {
            $this->model::create([
                'team_id' => $team->id,
                'phase_id' => $phase->id,
                'quantity' => $quantityToBuy,
                'price' => $totalPrice,
            ]);
        }

        return redirect()->back()->with('success', 'Ticket(s) purchased successfully!');
    }

    public function getCurrentTeamTicket($teamId, $phaseId)
    {
        return $this->model->with('phase')->where('team_id', $teamId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
