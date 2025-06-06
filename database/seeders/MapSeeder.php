<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MapSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua Phase yang sudah ada
        $phases = DB::table('phases')->pluck('id')->toArray();
        if (empty($phases)) {
            $this->command->info('No phases found! Please run PhaseSeeder first.');
            return;
        }

        // Ambil ID rally yang baru dibuat
        $rallies = DB::table('rallies')->pluck('id')->toArray();
        $teams = DB::table('teams')->select('id')->limit(3)->get();

        if ($teams->isEmpty()) {
            $this->command->info('No teams found! Please seed teams first.');
            return;
        }

        // Masukkan data rally_histories dengan SQL query langsung
        $query = "INSERT INTO rally_histories (id, rally_id, team_id, phase_id, qr_expired_at, scanned_at, `rank`, `rewart`, created_at, updated_at) VALUES ";
        $values = [];
        $bindings = [];

        foreach ($teams as $team) {
            foreach ($rallies as $rallyId) {
                foreach ($phases as $phaseId) { // Loop untuk setiap phase
                    $values[] = "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $bindings = array_merge($bindings, [
                        Str::uuid(),
                        $rallyId, 
                        $team->id, 
                        $phaseId,
                        (string) Carbon::now()->addHours(2),
                        rand(0, 1) ? Carbon::now()->toDateTimeString() : null, 
                        rand(1, 3), 
                        rand(10, 100),
                        (string) now(), 
                        (string) now()
                    ]);
                }
            }
        }

        if (!empty($values)) {
            $query .= implode(", ", $values);
            
            // Jalankan query
            DB::insert($query, $bindings);
        }
    }
}
