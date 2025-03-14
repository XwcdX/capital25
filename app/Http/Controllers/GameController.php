<?php

namespace App\Http\Controllers;

use App\Models\GameSetting;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(){
            $game = new GameSetting([
                'round' => 1, 
                'countdown' => '15:30:00' // Format sesuai database
            ]);
        

        return view('homePage', compact('game'));
    }
    
}

