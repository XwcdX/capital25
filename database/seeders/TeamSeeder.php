<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Team A',
                'email' => 'test1@example.com',
                'school' => 'Petra',
                'domicile' => 'Surabaya-Jawa Timur',
                'password' => Hash::make('password')
            ],
            [
                'name' => 'Team B',
                'email' => 'test2@example.com',
                'school' => 'Petra',
                'domicile' => 'Surabaya-Jawa Barat',
                'password' => Hash::make('password')
            ],
            [
                'name' => 'Team C',
                'email' => 'test3@example.com',
                'school' => 'Petra',
                'domicile' => 'Surabaya-Jawa Tengah',
                'password' => Hash::make('password')
            ],
        ];
        foreach($teams as $team){
            Team::create($team);
        }
    }
}
