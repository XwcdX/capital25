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
        // [
        //         'email' => 'c14230191@john.petra.ac.id',
        //         'password' => Hash::make('password'),
        //         'name' => 'Aloysia Jennifer',
        //         'division_id' => Division::whereSlug('it')->first()->id,
        //     ]
            // ['email' => 'c14240152@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Elizabeth Damai', 'division_id' => Division::whereSlug('creative')->first()->id],
            // ['email' => 'c14240078@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Charles Christiano', 'division_id' => Division::whereSlug('it')->first()->id],
            // ['email' => 'c14240067@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Cheryl Wang', 'division_id' => Division::whereSlug('it')->first()->id],
            // ['email' => 'd12240084@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Christy Devina', 'division_id' => Division::whereSlug('transkapman')->first()->id],
            // ['email' => 'd11240343@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Nadine Wijaya', 'division_id' => Division::whereSlug('sekkonkes')->first()->id],
            // ['email' => 'c11240009@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Marcell Nathaniel', 'division_id' => Division::whereSlug('acara')->first()->id],
            ['email' => 'c14240039@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Jericho Sundjaja', 'division_id' => Division::whereSlug('acara')->first()->id],
            ['email' => 'c14240052@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Gretchen Isviandhy', 'division_id' => Division::whereSlug('acara')->first()->id],
            // ['email' => 'd11240260@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Kayleen Hartono', 'division_id' => Division::whereSlug('acara')->first()->id],
            ['email' => 'h14240076@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Chelsey Nathania', 'division_id' => Division::whereSlug('sponsor')->first()->id],
            // ['email' => 'd11230301   @john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Pricilla Chealsea', 'division_id' => Division::whereSlug('bph')->first()->id],
            // ['email' => 'd11230275@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Jessica Renata', 'division_id' => Division::whereSlug('acara')->first()->id],
            ['email' => 'd11230197@john.petra.ac.id', 'password' => Hash::make('password'), 'name' => 'Alyssa Channiago', 'division_id' => Division::whereSlug('acara')->first()->id],
        ];
        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
