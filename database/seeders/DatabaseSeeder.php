<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(TeamSeeder::class);
        // $this->call(RallySeeder::class);
        // $this->call(DivisionSeeder::class);
        // $this->call(AdminSeeder::class);
        // $this->call(PhaseSeeder::class);
        $this->call(CommoditySeeder::class);
        // $this->call(QuestionSeeder::class);
        // $this->call(AnswerSeeder::class);
        // $this->call(RallyHistorySeeder::class);
        // $this->call(QnASeeder::class);
    }
}
