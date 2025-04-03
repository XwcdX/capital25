<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LifecycleHomepageController extends Controller
{
    //cheryl - transacrion history (greenpoint, coin)
    public function index()
    {
        $title = "Lifecycle";

        //$teamId = 1; //buat testing aj karena ga pake login team/user
        
        //hardcode testing
        $greenpoint = 100000;
        $coin = 1000000;
        $transactionsGreenPoint = [
            (object)['created_at' => '26/12/25 11:50', 'rank' => 1, 'greenpoint' => 10000],
            (object)['created_at' => '26/12/25 11:55', 'rank' => 2, 'greenpoint' => 8000],
            (object)['created_at' => '26/12/25 12:00', 'rank' => 5, 'greenpoint' => -1000],
            (object)['created_at' => '27/12/25 11:50', 'rank' => 1, 'greenpoint' => 10000],
            (object)['created_at' => '27/12/25 11:55', 'rank' => 2, 'greenpoint' => 8000],
            (object)['created_at' => '27/12/25 12:00', 'rank' => 5, 'greenpoint' => -10000],
            (object)['created_at' => '28/12/25 11:50', 'rank' => 1, 'greenpoint' => 10000],
            (object)['created_at' => '28/12/25 11:55', 'rank' => 2, 'greenpoint' => 8000],
            (object)['created_at' => '26/12/25 12:00', 'rank' => 5, 'greenpoint' => -10000]
        ];
        $transactionsCoin = [
            (object)['created_at' => '26/12/25 11:50', 'rank' => 1, 'coin' => 10000],
            (object)['created_at' => '26/12/25 11:55', 'rank' => 2, 'coin' => 8000],
            (object)['created_at' => '26/12/25 12:00', 'rank' => 5, 'coin' => -10000],
            (object)['created_at' => '27/12/25 11:50', 'rank' => 1, 'coin' => 10000],
            (object)['created_at' => '27/12/25 11:55', 'rank' => 2, 'coin' => 8000],
            (object)['created_at' => '27/12/25 12:00', 'rank' => 5, 'coin' => -1000],
            (object)['created_at' => '28/12/25 11:50', 'rank' => 1, 'coin' => 10000],
            (object)['created_at' => '28/12/25 11:55', 'rank' => 2, 'coin' => 8000],
            (object)['created_at' => '26/12/25 12:00', 'rank' => 5, 'coin' => -10000]
        ];
        
        // ambil team id 
        //$teamId = Auth::user()->team_id;
        //$team = DB::table('teams')->where('team_id', $teamId)->first();
        
        // ambil jumlah greenpoint sm coins ny
        // $greenpoint = $team->green_points ?? 0;
        // $coin = $team->coin ?? 0;

        return view('LifecycleHomepage.LifecycleHomepage', compact('title', 'greenpoint', 'coin', 'transactionsGreenPoint', 'transactionsCoin'));
    
}

}