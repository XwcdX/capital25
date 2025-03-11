<?php

namespace Database\Seeders;

use App\Models\Rally;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RallySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rallies = [
            ['name' => 'pos 1'],
            ['name' => 'pos 2'],
            ['name' => 'pos 3'],
            ['name' => 'pos 4'],
            ['name' => 'pos 5'],
            ['name' => 'pos 6'],
            ['name' => 'pos 7'],
            ['name' => 'pos 8'],
        ];

        foreach ($rallies as $rally)
        {
            Rally::create($rally);
        }
    }
}
