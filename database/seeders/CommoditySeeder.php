<?php

namespace Database\Seeders;

use App\Models\Commodity;
use App\Models\Phase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phase1 = Phase::where('phase', 1)->first()->id;
        $phase2 = Phase::where('phase', 2)->first()->id;
        $phase3 = Phase::where('phase', 3)->first()->id;
        $phase4 = Phase::where('phase', 4)->first()->id;
        $commodities = [
            [
                [
                    "name" => "Kacang Tanah",
                    "image" => "assets/phase1/KACANG_TANAH.png",
                    "description" => "Kacang Tanah adalah tanaman polong-polongan yang banyak dibudidayakan di Indonesia. Kacang ini memiliki banyak manfaat, antara lain sebagai sumber protein nabati, lemak sehat, dan vitamin.",
                    "price" => 0,
                    "return_rate" => 0,
                ],
                [
                    "name" => "Padi",
                    "image" => "assets/phase1/PADI",
                    "description" => "Padi adalah tanaman serealia yang menjadi makanan pokok bagi sebagian besar penduduk dunia, terutama di Asia. Padi memiliki banyak manfaat, antara lain sebagai sumber karbohidrat, serat, dan vitamin.",
                    "price" => 0,
                    "return_rate" => 0,
                ],
                [
                    "name" => "Gula",
                    "image" => "assets/phase1/GULA",
                    "description" => "Gula adalah bahan makanan yang digunakan sebagai pemanis. Gula memiliki banyak manfaat, antara lain sebagai sumber energi, meningkatkan rasa makanan, dan memberikan rasa manis pada minuman.",
                    "price" => 0,
                    "return_rate" => 0,
                ],
                [
                    "name" => "Bawang Merah",
                    "image" => "assets/phase1/BAWANG_MERAH.png",
                    "description" => "Bawang Merah adalah tanaman umbi-umbian yang banyak dibudidayakan di Indonesia. Bawang Merah memiliki banyak manfaat, antara lain sebagai bumbu masakan, sumber antioksidan, dan meningkatkan sistem kekebalan tubuh.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Kacang Polong",
                    "image" => "assets/phase1/KACANG_POLONG.png",
                    "description" => "Kacang Polong adalah tanaman polong-polongan yang banyak dibudidayakan di Indonesia. Kacang Polong memiliki banyak manfaat, antara lain sebagai sumber protein nabati, serat, dan vitamin.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Pestisida Organik",
                    "image" => "assets/phase1/PESTISIDA_ORGANIK.png",
                    "description"=> "Pestisida Organik adalah pestisida yang terbuat dari bahan-bahan alami dan tidak mengandung bahan kimia berbahaya. Pestisida Organik memiliki banyak manfaat, antara lain sebagai pengendali hama dan penyakit tanaman, ramah lingkungan, dan aman bagi kesehatan.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Pupuk Hayati",
                    "image" => "assets/phase1/PUPUK_HAYATI.png",
                    "description"=> "Pupuk Hayati adalah pupuk yang terbuat dari bahan-bahan alami dan mengandung mikroorganisme yang bermanfaat bagi tanaman. Pupuk Hayati memiliki banyak manfaat, antara lain meningkatkan kesuburan tanah, memperbaiki struktur tanah, dan meningkatkan hasil pertanian.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Processed Food",
                    "image" => "assets/phase1/PROCESSED_FOOD.png",
                    "description"=> "Processed Food adalah makanan yang telah diolah dan dikemas untuk memudahkan penyimpanan dan konsumsi. Processed Food memiliki banyak manfaat, antara lain praktis, tahan lama, dan mudah disajikan.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Susu Bubuk",
                    "image" => "assets/phase1/SUSU_BUBUK.png",
                    "description"=> "Susu Bubuk adalah susu yang telah dikeringkan menjadi bubuk untuk memudahkan penyimpanan dan konsumsi. Susu Bubuk memiliki banyak manfaat, antara lain sebagai sumber kalsium, protein, dan vitamin.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Kain Katun",
                    "image" => "assets/phase1/KAIN_KATUN.png",
                    "description"=> "Kain Katun adalah kain yang terbuat dari serat kapas dan banyak digunakan untuk pakaian. Kain Katun memiliki banyak manfaat, antara lain nyaman dipakai, menyerap keringat, dan mudah dicuci.",
                    "price" => 0,
                    "return_rate" => 0
                ],
            ],
            [
                [
                    "name" => "Kerang",
                    "image" => "assets/phase2/KERANG.png",
                    "description"=> "Kerang adalah hewan laut yang memiliki cangkang keras dan banyak dibudidayakan di Indonesia. Kerang memiliki banyak manfaat, antara lain sebagai sumber protein, omega-3, dan mineral.",
                    "price" => 0,
                    "return_rate" => 0,
                ],
                [
                    "name" => "Rumput Laut",
                    "image" => "assets/phase2/RUMPUT_LAUT.png",
                    "description"=> "Rumput Laut adalah tanaman laut yang banyak dibudidayakan di Indonesia. Rumput Laut memiliki banyak manfaat, antara lain sebagai sumber serat, vitamin, dan mineral.",
                    "price" => 0,
                    "return_rate" => 0,
                ],
                [
                    "name" => "Filter Air",
                    "image" => "assets/phase2/FILTER_AIR.png",
                    "description"=> "Filter Air adalah alat yang digunakan untuk menyaring air agar bersih dan aman untuk dikonsumsi. Filter Air memiliki banyak manfaat, antara lain menghilangkan kotoran, bakteri, dan zat berbahaya dari air.",
                    "price" => 0,
                    "return_rate" => 0,
                ],
                [
                    "name" => "Obat Ikan",
                    "image" => "assets/phase2/OBAT_IKAN.png",
                    "description"=> "Obat Ikan adalah obat yang digunakan untuk mengobati penyakit pada ikan. Obat Ikan memiliki banyak manfaat, antara lain mengobati infeksi, meningkatkan kesehatan ikan, dan mencegah penyebaran penyakit.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Ikan Kakap Merah",
                    "image" => "assets/phase2/IKAN_KAKAP_MERAH.png",
                    "description"=> "Ikan Kakap Merah adalah ikan laut yang banyak dibudidayakan di Indonesia. Ikan Kakap Merah memiliki banyak manfaat, antara lain sebagai sumber protein, omega-3, dan vitamin.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Kepiting Salju Norwegia",
                    "image" => "assets/phase2/KEPITING_SALJU_NORWEGIA.png",
                    "description"=> "Kepiting Salju Norwegia adalah jenis kepiting yang banyak dibudidayakan di Norwegia. Kepiting Salju Norwegia memiliki banyak manfaat, antara lain sebagai sumber protein, omega-3, dan mineral.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Ikan Makerel",
                    "image" => "assets/phase2/IKAN_MAKEREL.png",
                    "description"=>"Ikan Makerel adalah ikan laut yang banyak dibudidayakan di Indonesia. Ikan Makerel memiliki banyak manfaat, antara lain sebagai sumber protein, omega-3, dan vitamin.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Udang Pembersih",
                    "image" => "assets/phase2/UDANG_PEMBERSIH.png",
                    "description"=> "Udang Pembersih adalah jenis udang yang banyak dibudidayakan di Indonesia. Udang Pembersih memiliki banyak manfaat, antara lain sebagai sumber protein, omega-3, dan vitamin.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Nanobubble Generator",
                    "image" => "assets/phase2/NANOBUBBLE_GENERATOR.png",
                    "description"=> "Nanobubble Generator adalah alat yang digunakan untuk menghasilkan gelembung nanometer dalam air. Nanobubble Generator memiliki banyak manfaat, antara lain meningkatkan kualitas air, meningkatkan oksigen terlarut, dan mengurangi zat berbahaya dalam air.",
                    "price" => 0,
                    "return_rate" => 0
                ],
                [
                    "name" => "Cacing Darah",
                    "image" => "assets/phase2/CACING_DARAH.png",
                    "description"=> "Cacing Darah adalah jenis cacing yang banyak dibudidayakan di Indonesia. Cacing Darah memiliki banyak manfaat, antara lain sebagai sumber protein, omega-3, dan vitamin.",
                    "price" => 0,
                    "return_rate" => 0
                ],
            ],
        ];

        $phases = [
            0 => $phase1,
            1 => $phase2,
            2 => $phase3,
            3 => $phase4,
        ];

        foreach ($commodities as $groupIndex => $commodityGroup) {
            $phaseId = $phases[$groupIndex] ?? null;
            if (!$phaseId) {
                continue;
            }
            foreach ($commodityGroup as $commodityData) {
                $commodityData['phase_id'] = $phaseId;
                Commodity::create($commodityData);
            }
        }
    }
}
