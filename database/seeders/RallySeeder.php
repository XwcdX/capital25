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
        $rallies = [
            [
                "post" => 1,
                "name" => "Natural Resources"
            ],
            [
                "post" => 2,
                "name" => "Raw Material Extraction"
            ],
            [
                "post" => 3,
                "name" => "Production"
            ],
            [
                "post" => 4,
                "name" => "Packing and Distribution"
            ],
            [
                "post" => 5,
                "name" => "Use and Maintenance "
            ],
            [
                "post" => 6,
                "name" => "Disposal"
            ],
            [
                "post" => 7,
                "name" => "Recycling"
            ],
            [
                "post" => 8,
                "name" => "Waste Management"
            ]
        ];

        foreach ($rallies as $rally) {
            Rally::create($rally);
        }
    }
}
