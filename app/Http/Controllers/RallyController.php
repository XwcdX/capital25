<?php

namespace App\Http\Controllers;

use App\Events\RallyParticipant;
use App\Models\Rally;
use App\Utils\HttpResponseCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RallyController extends BaseController
{
    public function __construct(Rally $model)
    {
        parent::__construct($model);
    }

    public function viewScanner()
    {
        return view('user.scanQR', ['title' => 'QR Scanner']);
    }

    public function viewRallyPost()
    {
        $title = 'Rally Post';
        $rallies = $this->model::with(['teams' => function ($query) {
            $query->withPivot(['qr_expired_at'])->orderBy('qr_expired_at');
        }])->get();
        return view('admin.rally-post', compact('title', 'rallies'));
    }

    public function generateRallyQrCode($rallyId)
    {
        $qrExpireAt = now()->addMinutes(5)->timestamp;
        $data = "$rallyId|$qrExpireAt";
        $signature = hash_hmac('sha256', $data, env('QR_SECRET_KEY'));
        $qrData = base64_encode("$data|$signature");
        return QrCode::size(200)->generate($qrData);
    }

    public function scanQrCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|uuid|exists:teams,id',
            'qr_data' => 'required|string',
            'phase_id' => 'required|uuid|exists:phases,id'
        ]);

        if ($validator->fails()) {
            return $this->error('Validation failed', HttpResponseCode::HTTP_BAD_REQUEST, $validator->errors());
        }

        $teamId = $request->input('team_id');
        $qrData = $request->input('qr_data');
        $phaseId = $request->input('phase_id');

        try {
            $decodedData = base64_decode($qrData);
            if (!$decodedData) {
                throw new \Exception('Invalid QR code format');
            }
            list($rallyId, $qrExpireAt, $signature) = explode('|', $decodedData);

            $expectedSignature = hash_hmac('sha256', "$rallyId|$qrExpireAt", env('QR_SECRET_KEY'));
            if (!hash_equals($expectedSignature, $signature)) {
                throw new \Exception('Invalid QR code signature');
            }

            if (now()->timestamp > $qrExpireAt) {
                return $this->error('QR code has expired.', HttpResponseCode::HTTP_BAD_REQUEST);
            }

            $rally = $this->model::findOrFail($rallyId);
            $qrExpireAtCarbon = Carbon::createFromTimestamp($qrExpireAt);

            $alreadyScanned = $rally->teams()
                ->wherePivot('team_id', $teamId)
                ->wherePivot('qr_expired_at', $qrExpireAtCarbon)
                ->exists();

            if ($alreadyScanned) {
                return $this->error('QR code already scanned.', HttpResponseCode::HTTP_BAD_REQUEST);
            }
            
            $alreadyPlayedInPhase = $rally->teams()
                ->wherePivot('team_id', $teamId)
                ->wherePivot('phase_id', $phaseId)
                ->exists();

            if ($alreadyPlayedInPhase) {
                return $this->error(
                    'Your team has already participated in this rally during this phase. Please try another rally.',
                    HttpResponseCode::HTTP_BAD_REQUEST
                );
            }

            $rally->teams()->syncWithoutDetaching([
                $teamId => [
                    'phase_id' => $phaseId,
                    'qr_expired_at' => $qrExpireAtCarbon,
                    'scanned_at' => now(),
                ]
            ]);

            $rallyHistory = $rally->teams()
                ->wherePivot('phase_id', $phaseId)
                ->wherePivot('qr_expired_at', $qrExpireAtCarbon)
                ->get();

            event(new RallyParticipant($rallyHistory));

            return $this->success('QR code scanned successfully.', ['rally_id' => $rally->id]);
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
}
