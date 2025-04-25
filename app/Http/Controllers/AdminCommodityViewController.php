<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Commodity;


class AdminCommodityViewController extends Controller
{
    // Buat page yang hanya bisa diakses oleh admin, berisi komoditas untuk setiap phase, dan return rate nya, yang ditampilkan sesuai dengan fase yg sedang berjalan
    //1. ambil id dari phase yg aktif
    //2. compare ke phase_id dari commodities
    //3. yang match ditampilin
    // Tabel 'commodities': id, phase_id, name, image, description, price, return_rate, created_at, updated_at
    // Tabel 'phases': id, phase, end_time, created_at, updated_at.
    // laravel-blade

  
public function index(){
  
    //   $currentPhase = Cache::get('current_phase', 'No Current Phase Have Been Set');
    //cache: yg diambil itu suda berupa object.

    // Hardcode buat check
    $currentPhase = (object) [
        'id' => '9eb4be5a-74bd-4354-9b93-f45ad9dc2e8e',  
        'phase' => 'Fase 2',
        'end_time' => '2025-04-25 18:50:00',
        'created_at' => '2025-01-01 12:00:00',
        'updated_at' => '2025-01-01 12:00:00'
    ];
    

    if ($currentPhase) {
        $commodities = Commodity::where('phase_id', $currentPhase->id)->get();
    } else {
        $commodities = collect(); // kalau phase belum ada, kosongkan komoditasnya
    }

    return view('admin.AdminCommodity.adminCommodityView', 
    ['commodities' => $commodities,
    'currentPhase' => $currentPhase,
    'title' => 'AdminCommodityView']);

}
}

