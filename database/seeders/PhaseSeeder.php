<?php

namespace Database\Seeders;

use App\Models\Phase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phases = 4;
        for ($i = 1; $i <= $phases; $i++) {
            Phase::create([
                'id' => Str::uuid(),
                'phase' => $i,
                // 'status' => false,
            ]);
        }
    }
}
