<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            // [
            //     'email' => 'c14230074@john.petra.ac.id',
            //     'password' => Hash::make('password'),
            //     'name' => 'Terry Clement',
            //     'division_id' => Division::whereSlug('it')->first()->id,
            // ],        
            // [
            //     'email' => 'c14230257@john.petra.ac.id',
            //     'password' => Hash::make('password'),
            //     'name' => 'Shelly Oei',
            //     'division_id' => Division::whereSlug('it')->first()->id,
            // ]
        [
                'email' => 'c14230191@john.petra.ac.id',
                'password' => Hash::make('password'),
                'name' => 'Aloysia Jennifer',
                'division_id' => Division::whereSlug('it')->first()->id,
            ]
        ];
        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
