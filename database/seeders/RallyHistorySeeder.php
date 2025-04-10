<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Team;
use App\Models\Rally;
use App\Models\Phase;

class RallyHistorySeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rally_histories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $teams = Team::all();
        $rallies = Rally::all();
        $phases = Phase::all();

        if ($teams->isEmpty() || $rallies->isEmpty() || $phases->isEmpty()) {
            $this->command->info('Teams, Rallies, or Phases not found. Please seed them first.');
            return;
        }

        foreach ($teams as $team) {
            foreach ($rallies as $rally) {
                foreach ($phases as $phase) {
                    DB::table('rally_histories')->insert([
                        'rally_id'      => $rally->id,
                        'team_id'       => $team->id,
                        'phase_id'      => $phase->id,
                        'qr_expired_at' => Carbon::now()->addHours(2),
                        'scanned_at'    => (rand(0, 1) ? Carbon::now()->toDateTimeString() : null),
                        'rank'          => rand(1, 3),
                        'reward'         => rand(10, 100),
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);
                }
            }
        }

        $this->command->info('Rally histories seeded successfully.');
    }
}
