<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Rally;
use App\Models\Phase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MapController extends Controller
{
    public function showMap(Request $request)
    {
        $teamId = Session::get('team_id');

        // jika tidak ada team_id di session, redirect ke login
        if (!$teamId) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        // ambil semua rallies dan phases
        $rallies = Rally::all();
        $phases = Phase::orderBy('phase')->get();

        // posisi pos rally di map
        $rallyPositions = [
            'Rally 1' => ['x' => 30, 'y' => 40],
            'Rally 2' => ['x' => 50, 'y' => 60],
            'Rally 3' => ['x' => 70, 'y' => 75],
        ];

        $currentPhase = $phases->firstWhere('status', 1) ?? $phases->last();

        // ambil data pos yang dikunjungi per fase
        $activePhases = $phases->where('phase', '<=', optional($currentPhase)->phase ?? 0)->pluck('id')->toArray();
        $visitedRalliesByPhase = [];


        foreach ($activePhases as $phaseId) {
            $visitedRalliesByPhase[$phaseId] = DB::table('rally_histories')
                ->where('phase_id', $phaseId)
                ->where('team_id', $teamId)
                ->whereNotNull('scanned_at')
                ->pluck('rally_id')
                ->toArray();
        }

        $title = 'Map';
        return view('user.map', compact('title', 'phases', 'currentPhase', 'rallies', 'visitedRalliesByPhase', 'rallyPositions'));
    }
}
