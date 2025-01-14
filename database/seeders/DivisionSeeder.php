<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('divisions')->truncate();
        Schema::enableForeignKeyConstraints();
        $divisions = [
            [
                "name" => "Badan Pengurus Harian",
                "slug" => "bph"
            ],
            [
                "name" => "Acara",
                "slug" => "acara"
            ],
            [
                "name" => "Creative",
                "slug" => "creative"
            ],
            [
                "name" => "Information Technology",
                "slug" => "it"
            ],
            [
                "name" => "Transportasi, Perlengkapan, dan Keamanan",
                "slug" => "transkapman"
            ],
            [
                "name" => "Sekretariat, Konsumsi, dan Kesehatan",
                "slug" => "sekkonkes"
            ],
            [
                "name" => "Sponsor",
                "slug" => "sponsor"
            ]
        ];
        foreach($divisions as $division){
            Division::create($division);
        }
    }
}
