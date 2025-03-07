<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\Rally;
use App\Models\Commodity;
use Illuminate\Http\Request;
use App\Utils\HttpResponseCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RallyController extends BaseController
{
    protected $teamController;
    protected $commodityController;
    public function __construct(Rally $model)
    {
        parent::__construct($model);
        $this->teamController = new TeamController(new Team());
        $this->commodityController = new CommodityController(new Commodity());
    }

    public function viewScanner(){
        return view('user.scanQR', ['title' => 'QR Scanner']);
    }

    public function viewRallyPost()
    {
        $title = 'Rally Post';
        $rallies = $this->model::get();
        return view('admin.rally-post', compact('title', 'rallies'));
    }

    public function generateRallyQrCode($rallyId)
    {
        $qrExpireAt = now()->addMinutes(5);

        $data = [
            'rally_id' => $rallyId,
            'qr_expired_at' => $qrExpireAt->timestamp,
        ];

        $encryptedData = Crypt::encrypt($data);
        return QrCode::size(500)->generate($encryptedData);
    }

    public function scanQrCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|uuid|exists:teams,id',
            'qr_data' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation failed', HttpResponseCode::HTTP_BAD_REQUEST, $validator->errors());
        }

        $teamId = $request->input('team_id');
        $qrData = $request->input('qr_data');

        try {
            $data = Crypt::decrypt($qrData);
            Log::info($data);

            if (now()->greaterThan(Carbon::createFromTimestamp($data['qr_expired_at']))) {
                return $this->error('QR code has expired.', HttpResponseCode::HTTP_BAD_REQUEST);
            }

            $rallyId = $data['rally_id'];
            $qrExpireAt = Carbon::createFromTimestamp($data['qr_expired_at']);
            $rally = $this->model::findOrFail($rallyId);

            $exists = $rally->teams()
                ->wherePivot('team_id', $teamId)
                ->wherePivot('qr_expired_at', $qrExpireAt)
                ->exists();

            if ($exists) {
                return $this->error('QR code already scanned.', HttpResponseCode::HTTP_BAD_REQUEST);
            }

            $rally->teams()->syncWithoutDetaching([
                $teamId => [
                    'qr_expired_at' => $qrExpireAt,
                    'scanned_at' => now(),
                ]
            ]);

            return $this->success('QR code scanned successfully.');
        } catch (\Exception $e) {
            Log::error('Error during QR code scan', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
            ]);
            return $this->error('Invalid QR code.', HttpResponseCode::HTTP_BAD_REQUEST);
        }
    }

    public function updateRankAndPoint(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|uuid|exists:teams,id',
            'rally_id' => 'required|uuid|exists:rallies,id',
            'rank' => 'required|integer|in:1,2,3',
        ]);

        if ($validator->fails()) {
            Log::warning('Rank and point update validation failed', [
                'errors' => $validator->errors(),
                'input' => $request->all(),
            ]);
            return $this->error('Validation failed', HttpResponseCode::HTTP_BAD_REQUEST, $validator->errors());
        }

        $teamId = $request->input('team_id');
        $rallyId = $request->input('rally_id');
        $rank = $request->input('rank');

        $points = match ($rank) {
            1 => 30,
            2 => 20,
            3 => 10,
            default => null,
        };

        try {
            $rally = $this->model::findOrFail($rallyId);

            $rally->teams()->updateExistingPivot($teamId, [
                'rank' => $rank,
                'point' => $points,
            ]);
            return $this->success('Rank and point updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error during rank and point update', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
            ]);
            return $this->error('Error updating rank and point.', HttpResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function viewTradeZone(){
        //JANLUPA CEK TERBUKA OR NO, IKU BERDASAR PHASE a? 15 menit after phase started bro
        $title = 'Trade Zone';
        $commodities = $this->commodityController->getAllCommodity();
        
        return view('user.tradeZone', compact('title','commodities'));
    }
    public function checkoutTradeZone(Request $request){
        
        return;
    }
}
