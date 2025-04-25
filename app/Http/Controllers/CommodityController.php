<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\Team;
use App\Utils\HttpResponseCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommodityController extends BaseController
{
    protected $teamController;
    public function __construct(Commodity $commodity)
    {
        parent::__construct($commodity);
        $this->teamController = new TeamController(new Team());
    }

    public function getCurrentCommodities($phaseId)
    {
        return $this->model->where("phase_id", $phaseId)->get();
    }

    public function buyMultipleCommodities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.commodity_id' => 'required|uuid|exists:commodities,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), HttpResponseCode::HTTP_BAD_REQUEST);
        }

        $items = $validator->validated()['items'];
        $team = Auth::user();
        $totalPrice = 0;

        foreach ($items as $item) {
            $commodity = $this->model::findOrFail($item['commodity_id']);
            $totalPrice += $commodity->price * $item['quantity'];
        }

        if ($team->coin < $totalPrice) {
            return $this->error('Sorry, you cannot complete the purchase because your balance is insufficient.', HttpResponseCode::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();
        try {
            foreach ($items as $item) {
                $commodity = $this->model::findOrFail($item['commodity_id']);
                $currentPhase = $commodity->phase_id;

                $existingRecord = $commodity->teams()
                    ->where('team_id', $team->id)
                    ->wherePivot('return_rate', $commodity->return_rate)
                    ->first();

                if ($existingRecord) {
                    $newQuantity = $existingRecord->pivot->quantity + $item['quantity'];
                    DB::table('commodity_histories')
                        ->where('team_id', $team->id)
                        ->where('commodity_id', $commodity->id)
                        ->where('return_rate', $commodity->return_rate)
                        ->update(['quantity' => $newQuantity]);
                } else {
                    $existsCommodity = DB::table('commodity_histories')
                        ->where('team_id', $team->id)
                        ->where('phase_id', $currentPhase)
                        ->where('commodity_id', $commodity->id)
                        ->exists();

                    if (!$existsCommodity) {
                        $uniqueCount = DB::table('commodity_histories')
                            ->where('team_id', $team->id)
                            ->where('phase_id', $currentPhase)
                            ->distinct()
                            ->count('commodity_id');

                        if ($uniqueCount >= 3) {
                            DB::rollBack();
                            return $this->error('Already reached maximum unique commodity purchase in this phase for commodity: ' . $commodity->name);
                        }
                    }
                    $commodity->teams()->attach($team->id, [
                        'phase_id' => $currentPhase,
                        'quantity' => $item['quantity'],
                        'return_rate' => $commodity->return_rate,
                    ]);
                }
                $itemPrice = $commodity->price * $item['quantity'];

                $transactionData = [
                    'transaction_type' => 'coin',
                    'action' => 'debit',
                    'amount' => $itemPrice,
                    'commodity_id' => $commodity->id,
                    'description' => "Purchased {$item['quantity']} x {$commodity->name}",
                ];

                $transRequest = new Request($transactionData);
                $response = $this->teamController->updateBalance($transRequest);
                $responseData = $response->getData();

                if (isset($responseData->error)) {
                    DB::rollBack();
                    return $this->error($responseData->error);
                }
            }

            DB::commit();
            return $this->success('Commodity(ies) purchased successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    public function adminBuyCommodity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|uuid|exists:teams,id',
            'commodity_id' => 'required|uuid|exists:commodities,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first(),
                HttpResponseCode::HTTP_BAD_REQUEST
            );
        }

        $phase =  Cache::get("current_phase", "No Phase Set");
        $validated = $validator->validated();
        $team = $this->teamController->getTeam($validated['team_id']);
        $commodity = $this->model::findOrFail($validated['commodity_id']);
        $qty = $validated['quantity'];
        $totalPrice = $commodity->price * $qty;

        // $existingRecord = $commodity->teams()
        //     ->where('team_id', $team->id)
        //     ->first();

        // if (!$existingRecord) {
        //     return $this->error(
        //         'This commodity is not available for this team.',
        //         HttpResponseCode::HTTP_BAD_REQUEST
        //     );
        // }

        if ($team->coin < $totalPrice) {
            return $this->error(
                'The team does not have enough coin for this purchase.',
                HttpResponseCode::HTTP_BAD_REQUEST
            );
        }

        DB::beginTransaction();
        try {
            $historyRow = DB::table('commodity_histories')
                ->where('team_id', $team->id)
                ->where('commodity_id', $commodity->id)
                ->where('return_rate', $commodity->return_rate)
                ->where('phase_id', $phase->id)
                ->first();

            if ($historyRow) {
                DB::table('commodity_histories')
                    ->where('id', $historyRow->id)
                    ->update([
                        'quantity' => DB::raw("quantity + {$qty}"),
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('commodity_histories')->insert([
                    'team_id' => $team->id,
                    'commodity_id' => $commodity->id,
                    'phase_id' => $phase->id,
                    'return_rate' => $commodity->return_rate,
                    'quantity' => $qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $transactionData = [
                'team_id' => $team->id,
                'transaction_type' => 'coin',
                'action' => 'debit',
                'amount' => $totalPrice,
                'commodity_id' => $commodity->id,
                'description' => "Purchased {$qty} x {$commodity->name}",
            ];

            $transRequest = new Request($transactionData);
            $response = $this->teamController->updateBalance($transRequest);
            $respBody = $response->getData();

            if (isset($respBody->error)) {
                throw new \Exception($respBody->error);
            }

            DB::commit();
            return $this->success('Commodity purchased successfully for the team.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error(
                $e->getMessage(),
                HttpResponseCode::HTTP_BAD_REQUEST
            );
        }
    }



    public function reduceAllCommodityReturnRates(string $phaseId)
    {
        DB::beginTransaction();
        try {
            $currentPhase = Cache::get('current_phase');
            if($currentPhase){
                if($currentPhase->hasReduced == 0){
                    DB::statement("
                        UPDATE commodities
                        SET return_rate = CASE 
                            WHEN return_rate = 0.10 THEN 0.075 
                            WHEN return_rate = 0.075 THEN 0.05 
                            WHEN return_rate = 0.05 THEN 0.0375 
                            ELSE return_rate 
                        END
                        WHERE phase_id = :phaseId
                        AND return_rate IN (0.10, 0.075, 0.05)
                    ", ['phaseId' => $phaseId]);

                    $currentPhase->hasReduced = 1;
                    $currentPhase->save();

                    Cache::forever('current_phase', $currentPhase);
        
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Return rates are changing!']);
                } else {
                    return response()->json(['success' => true, 'message' => 'Return rates have already been reduced.']);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error reducing rates',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
