<?php

namespace Database\Seeders;

use App\Models\Team;
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
            ['name' => 'Dummy 1', 'email' => 'red.dragons@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Timur', 'password' => Hash::make('password')],
            ['name' => 'Dummy 2', 'email' => 'blue.phoenix@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Barat', 'password' => Hash::make('password')],
            ['name' => 'Dummy 3', 'email' => 'golden.tigers@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Tengah', 'password' => Hash::make('password')],
            ['name' => 'Dummy 4', 'email' => 'silver.wolves@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Timur', 'password' => Hash::make('password')],
            ['name' => 'Dummy 5', 'email' => 'emerald.eagles@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Barat', 'password' => Hash::make('password')],
            ['name' => 'Dummy 6', 'email' => 'crimson.hawks@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Tengah', 'password' => Hash::make('password')],
            ['name' => 'Dummy 7', 'email' => 'sapphire.sharks@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Timur', 'password' => Hash::make('password')],
            ['name' => 'Dummy 8', 'email' => 'ruby.rhinos@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Barat', 'password' => Hash::make('password')],
            ['name' => 'Dummy 9', 'email' => 'top.cats@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Tengah', 'password' => Hash::make('password')],
            ['name' => 'Dummy 10', 'email' => 'lightning.lions@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Timur', 'password' => Hash::make('password')],
            ['name' => 'Dummy 11', 'email' => 'fierce.falcons@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Barat', 'password' => Hash::make('password')],
            ['name' => 'Dummy 12', 'email' => 'mighty.mustangs@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Tengah', 'password' => Hash::make('password')],
            ['name' => 'Dummy 13', 'email' => 'brave.bears@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Timur', 'password' => Hash::make('password')],
            ['name' => 'Dummy 14', 'email' => 'noble.knights@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Barat', 'password' => Hash::make('password')],
            ['name' => 'Dummy 15', 'email' => 'rapid.rabbits@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Tengah', 'password' => Hash::make('password')],
            ['name' => 'Dummy 16', 'email' => 'swift.swans@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Timur', 'password' => Hash::make('password')],
            ['name' => 'Dummy 17', 'email' => 'happy.hippos@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Barat', 'password' => Hash::make('password')],
            ['name' => 'Dummy 18', 'email' => 'jolly.jaguars@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Tengah', 'password' => Hash::make('password')],
            ['name' => 'Dummy 19', 'email' => 'polite.penguins@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Timur', 'password' => Hash::make('password')],
            ['name' => 'Dummy 20', 'email' => 'agile.alpacas@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Barat', 'password' => Hash::make('password')],
            ['name' => 'Dummy 21', 'email' => 'clever.cheetahs@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Tengah', 'password' => Hash::make('password')],
            ['name' => 'Dummy 22', 'email' => 'bold.bison@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Timur', 'password' => Hash::make('password')],
            ['name' => 'Dummy 23', 'email' => 'smart.squirrels@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Barat', 'password' => Hash::make('password')],
            ['name' => 'Dummy 24', 'email' => 'power.pythons@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Tengah', 'password' => Hash::make('password')],
            ['name' => 'Dummy 25', 'email' => 'elegant.elephants@example.com', 'school' => 'Petra', 'domicile' => 'Surabaya-Jawa Timur', 'password' => Hash::make('password')],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
