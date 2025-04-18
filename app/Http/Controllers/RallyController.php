<?php

namespace App\Http\Controllers;

use App\Events\RallyParticipant;
use App\Models\Commodity;
use App\Models\Phase;
use App\Models\Rally;
use App\Models\Team;
use App\Utils\HttpResponseCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RallyController extends BaseController
{
    protected $commodityController, $teamController;
    public function __construct(Rally $model)
    {
        parent::__construct($model);
        $this->commodityController = new CommodityController(new Commodity());
        $this->teamController = new TeamController(new Team());
    }

    public function rallyHome()
    {
        $title = "Lifecycle";
        $team = Auth::user();
        $currentPhase = Cache::get('current_phase');
        $storylines = [
            1 => "Pada tahun 2024, India berada di tengah krisis lingkungan, terutama dengan keberadaan kondisi iklim El Nino. 
            Polusi udara telah menjadi salah satu isu paling mendesak, dengan wilayah metropolitan seperti New Delhi mengalami tingkat polusi 
            yang melampaui ambang batas berbahaya. Musim dingin memperburuk keadaan, menciptakan kabut asap tebal akibat pembakaran jerami di wilayah pertanian sekitar. 
            Polusi udara ini tidak hanya merugikan kesehatan masyarakat tetapi juga menurunkan produktivitas pekerja. Terlebih lagi, krisis air bersih semakin memperburuk situasi. 
            Sungai-sungai utama seperti Yamuna dan Ganges menjadi simbol dari kerusakan lingkungan akibat limbah domestik, sisa-sisa pertanian. 
            Sektor agribisnis, yang menjadi tulang punggung masyarakat pedesaan India, terhambat oleh ketergantungan pada air tanah yang semakin menipis dan penurunan kualitas tanah akibat penggunaan pestisida berlebihan.",

            2 => "Perubahan iklim mempengaruhi industri perikanan Norwegia secara signifikan, terutama dengan menurunnya populasi spesies ikan boreal seperti ikan kod Atlantik, 
            halibut Greenland, kakap merah, dan tombak. Jumlah ikan salmon juga diperkirakan akan terpengaruh, karena suhu air yang lebih hangat meningkatkan risiko serangan 
            parasit dan penyakit pada ikan. Di sisi lain, perubahan iklim menyebabkan sebagian wilayah selatan Norwegia menjadi semakin tidak cocok bagi sebagian spesies yang 
            kini cenderung bermigrasi ke wilayah utara. Spesies lain seperti kepiting salju Norwegia juga sensitif terhadap perubahan suhu sehingga jumlah yang bisa ditangkap 
            untuk perikanan komersial semakin berkurang.  Selain itu, perairan yang lebih hangat berdampak pada berkurangnya populasi makanan ikan yang lebih kecil, seperti plankton.",

            3 => "Industri otomotif Jerman, yang dikenal sebagai salah satu pilar ekonomi negara, menghadapi tekanan besar untuk mengurangi emisi karbon sejalan dengan target 
            Uni Eropa untuk mencapai netralitas karbon pada tahun 2050. Target Uni Eropa adalah setidaknya 29% pangsa energi terbarukan pada 2030 atau pengurangan gas rumah 
            kaca sebesar 14,5% dibandingkan dengan emisi yang dihasilkan oleh penggunaan bahan bakar fosil. Produsen besar seperti Volkswagen, BMW, dan Mercedes-Benz pun harus 
            menyesuaikan dengan beralih dari kendaraan bermesin pembakaran internal (ICE) ke kendaraan listrik (EV) dalam skala besar. Salah satu dampak utama perubahan iklim pada 
            sektor ini adalah meningkatnya biaya produksi dan inovasi. Transisi menuju kendaraan listrik membutuhkan investasi besar dalam pengembangan teknologi baterai, infrastruktur pengisian daya, 
            dan rantai pasokan bahan baku seperti lithium dan kobalt, yang diperlukan untuk produksi baterai.",

            4 => "Tiongkok menghadapi berbagai masalah lingkungan serius yang semakin diperparah oleh perubahan iklim. 
            Sebagai negara dengan ekonomi manufaktur dan eksportir barang terkemuka di dunia, Tiongkok juga merupakan 
            salah satu produsen plastik terbesar di dunia dengan produksi plastik bulanan berkisar antara enam hingga 12 juta metrik ton. 
            Selain itu, Tiongkok menempati posisi teratas sebagai penyumbang emisi karbon terbesar di dunia, dengan emisi sebanyak 11.397 juta metrik ton pada 2022. 
            Berbagai faktor yang menyumbang buruknya kondisi lingkungan di Tiongkok menyebabkan hampir separuh dari seluruh kota-kota besarnya tenggelam. 
            Faktor-faktor lain ialah pengambilan air tanah berlebihan dan peningkatan beban ekspansi kota yang pesat. 
            Data menunjukkan satu dari enam kota di China mengalami penurunan tanah melebihi 10 mm per tahun."
        ];

        $rallies = $this->model::all();
        $phases = Phase::orderBy('phase')->get();
        $activePhases = Phase::whereNotNull('end_time')->orderBy('phase')->get();
        $visitedRalliesByPhase = DB::table('rally_histories')
            ->where('team_id', $team->id)
            ->whereIn('phase_id', $activePhases->pluck('id')->toArray())
            ->whereNotNull('scanned_at')
            ->get()
            ->groupBy('phase_id')
            ->map(function ($items) {
                return $items->pluck('rally_id')->unique()->values()->toArray();
            })
            ->toArray();

        $transactionsGreenPoint = $this->teamController->getGreenpointTransactions();
        $transactionsCoin = $this->teamController->getCoinTransactions();
        $inventories = $team->commodities()->get();
        $commodities = $this->commodityController->getCurrentCommodities($currentPhase->id);
        return view('user.rally.home', compact('title', 'team', 'transactionsGreenPoint', 'transactionsCoin', 'currentPhase', 'storylines', 'inventories', 'commodities', 'rallies', 'phases', 'activePhases', 'visitedRalliesByPhase'));

    }


    public function viewScanner()
    {
        return view('user.scanQR', ['title' => 'QR Scanner', 'currentPhase' => Cache::get('current_phase')]);
    }

    public function viewRallyPost()
    {
        $title = 'Rally Post';
        $currentPhase = Cache::get('current_phase');
        $rallies = $this->model::with([
            'teams' => function ($query) use ($currentPhase) {
                $query->wherePivot('phase_id', $currentPhase->id)->withPivot(['qr_expired_at'])->orderBy('qr_expired_at');
            }
        ])->get();
        foreach ($rallies as $rally) {
            $maxExpires = $rally->teams
                ->pluck('pivot.qr_expired_at')
                ->max();

            $filtered = $rally->teams
                ->filter(fn($team) => $team->pivot->qr_expired_at === $maxExpires)
                ->values();

            $rally->setRelation('teams', $filtered);
        }
        $rewardMapping = [
            1 => [
                'teams_range' => '4-5',
                'reward' => [60, 50, 45, 40, 35]
            ],
            2 => [
                'teams_range' => '5',
                'reward' => [55, 45, 40, 30, 20]
            ],
            3 => [
                'teams_range' => '4-7',
                'reward' => [55, 50, 45, 40, 35, 30, 25]
            ],
            4 => [
                'teams_range' => '4-7',
                'reward' => [65, 60, 55, 50, 45, 40, 35]
            ],
            5 => [
                'teams_range' => '4-7',
                'reward' => [60, 50, 45, 40, 35, 30, 25]
            ],
            6 => [
                'teams_range' => '4',
                'reward' => [50, 40, 35, 30]
            ],
            7 => [
                'teams_range' => '4',
                'reward' => [60, 50, 40, 35]
            ],
            8 => [
                'teams_range' => '4',
                'reward' => [55, 45, 35, 30]
            ],
        ];

        return view('admin.rally.rally-post', compact('title', 'rallies', 'currentPhase', 'rewardMapping'));
    }

    public function generateRallyQrCode($rallyId)
    {
        $qrExpireAt = now()->addMinutes(10)->timestamp;
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
        ], [
            'team_id.required' => 'Team ID is required',
            'team_id.uuid' => 'Team ID must be a valid UUID',
            'team_id.exists' => 'Team ID not found',
            'qr_data.required' => 'QR data is required',
            'qr_data.string' => 'QR data must be a string',
            'phase_id.required' => "Please wait, the phase hasn't started yet.",
            'phase_id.uuid' => 'Phase ID must be a valid UUID',
            'phase_id.exists' => 'Phase ID not found',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), HttpResponseCode::HTTP_BAD_REQUEST);
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
            $qrExpireAtCarbon = Carbon::createFromTimestamp($qrExpireAt, 'Asia/Bangkok');

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

            $allowedRanges = [
                1 => [4, 5],
                2 => [5, 5],
                3 => [4, 7],
                4 => [4, 7],
                5 => [4, 7],
                6 => [4, 4],
                7 => [4, 4],
                8 => [4, 4],
            ];
            $post = $rally->post;
            $allowed = isset($allowedRanges[$post]) ? $allowedRanges[$post] : [0, PHP_INT_MAX];

            $currentCount = $rally->teams()
                ->wherePivot('phase_id', $phaseId)
                ->wherePivot('qr_expired_at', $qrExpireAtCarbon)
                ->count();

            if ($currentCount >= $allowed[1]) {
                return $this->error(
                    "The number of scanned teams for rally post {$post} has reached the maximum allowed ({$allowed[1]}).",
                    HttpResponseCode::HTTP_BAD_REQUEST
                );
            }

            if ($rally->teams()->wherePivot('team_id', $teamId)->exists()) {
                $rally->teams()->attach($teamId, [
                    'phase_id' => $phaseId,
                    'qr_expired_at' => $qrExpireAtCarbon,
                    'scanned_at' => now(),
                ]);
            } else {
                $rally->teams()->syncWithoutDetaching([
                    $teamId => [
                        'phase_id' => $phaseId,
                        'qr_expired_at' => $qrExpireAtCarbon,
                        'scanned_at' => now(),
                    ]
                ]);
            }

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
}
