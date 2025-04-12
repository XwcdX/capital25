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
        $activePhases = Phase::whereNotNull('end_time')->orderBy('phase')->get();
        $currentPhase = $phases->whereNotNull('end_time')->sortByDesc('end_time')->first();

        // $activePhases = $phases->where('phase', '<=', optional($currentPhase)->phase ?? 0)->pluck('id')->toArray();

        $visitedRalliesByPhase = DB::table('rally_histories')
        ->where('team_id', $teamId)
        ->whereIn('phase_id', $activePhases->pluck('id')->toArray())
        ->whereNotNull('scanned_at')
        ->get()
        ->groupBy('phase_id')
        ->map(function ($items) {
            return $items->pluck('rally_id')->unique()->values()->toArray();
        })
        ->toArray();

        $title = 'Map';
        return view('user.map', compact('title', 'phases','currentPhase', 'rallies', 'visitedRalliesByPhase'));
    }
}
