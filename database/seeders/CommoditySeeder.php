<?php

namespace Database\Seeders;

use App\Models\Commodity;
use App\Models\Phase;
use Illuminate\Database\Seeder;

class CommoditySeeder extends Seeder
{
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
                    "description" => "Komoditas unggulan India, tahan kekeringan",
                    "price" => 200,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Padi",
                    "image" => "assets/phase1/PADI",
                    "description" => "Komoditas rentan kekeringan",
                    "price" => 250,
                    "return_rate" => 0.0500,
                ],
                [
                    "name" => "Gula",
                    "image" => "assets/phase1/GULA",
                    "description" => "Pemerintah India menghentikan ekspor gula karena curah hujan rendah",
                    "price" => 300,
                    "return_rate" => 0.0500,
                ],
                [
                    "name" => "Bawang Merah",
                    "image" => "assets/phase1/BAWANG_MERAH.png",
                    "description" => "Komoditas unggulan India, tahan kekeringan",
                    "price" => 300,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Kacang Pistachio",
                    "image" => "assets/phase1/KACANG_PISTACHIO.png",
                    "description" => "Bukan komoditas unggulan India, tetapi komoditas tahan kekeringan",
                    "price" => 350,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Pestisida Organik",
                    "image" => "assets/phase1/PESTISIDA_ORGANIK.png",
                    "description" => "Permintaan meningkat seiring berkembangnya masalah lingkungan",
                    "price" => 450,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Pupuk Hayati",
                    "image" => "assets/phase1/PUPUK_HAYATI.png",
                    "description" => "Permintaan meningkat seiring berkembangnya masalah lingkungan",
                    "price" => 500,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Processed Foods",
                    "image" => "assets/phase1/PROCESSED_FOOD.png",
                    "description" => "Tidak terlalu relevan dengan storyline, tetapi apabila kekeringan, bahan makanan menipis",
                    "price" => 400,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Susu Bubuk",
                    "image" => "assets/phase1/SUSU_BUBUK.png",
                    "description" => "Tidak terlalu relevan dengan storyline, tetapi apabila kekeringan, pakan ternak menipis",
                    "price" => 350,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Kain Katun",
                    "image" => "assets/phase1/KAIN_KATUN.png",
                    "description" => "Berasal dari tanaman kapas yang rentan kekeringan",
                    "price" => 250,
                    "return_rate" => 0.0500,
                ],
            ],
            [
                [
                    "name" => "Kerang Remis",
                    "image" => "assets/phase2/KERANG.png",
                    "description" => "Tahan terhadap kenaikan suhu dan dapat berkembang lebih baik.",
                    "price" => 150,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Makroalga (Rumput Laut)",
                    "image" => "assets/phase2/RUMPUT_LAUT.png",
                    "description" => "Sumber makanan alternatif jika plankton menurun.",
                    "price" => 200,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Filter Air",
                    "image" => "assets/phase2/FILTER_AIR.png",
                    "description" => "Mengolah air untuk menyaring polutan tetapi bukan solusi untuk peningkatan suhu air.",
                    "price" => 450,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Obat Ikan",
                    "image" => "assets/phase2/OBAT_IKAN.png",
                    "description" => "Mengatasi peningkatan penyakit pada perikanan.",
                    "price" => 300,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Ikan Kakap Merah",
                    "image" => "assets/phase2/IKAN_KAKAP_MERAH.png",
                    "description" => "Rentan terhadap perubahan suhu dan ketersediaan makanan.",
                    "price" => 250,
                    "return_rate" => 0.0500,
                ],
                [
                    "name" => "Kepiting Salju Norwegia",
                    "image" => "assets/phase2/KEPITING_SALJU_NORWEGIA.png",
                    "description" => "Jumlah tangkapan menurun karena rentan terhadap perubahan suhu tinggi.",
                    "price" => 500,
                    "return_rate" => 0.0500,
                ],
                [
                    "name" => "Ikan Makerel",
                    "image" => "assets/phase2/IKAN_MAKEREL.png",
                    "description" => "Ikan tropis yang bisa bermigrasi ke perairan Norwegia yang lebih hangat, tetapi bukan solusi untuk perairan panas.",
                    "price" => 200,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Udang Pembersih",
                    "image" => "assets/phase2/UDANG_PEMBERSIH.png",
                    "description" => "Membersihkan parasit dari tubuh ikan.",
                    "price" => 300,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Nanobubble Generator",
                    "image" => "assets/phase2/NANOBUBBLE_GENERATOR.png",
                    "description" => "Meningkatkan kelimpahan dan keberagaman fitoplankton, sekaligus kualitas perairan.",
                    "price" => 500,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Cacing Darah",
                    "image" => "assets/phase2/CACING_DARAH.png",
                    "description" => "Pakan ikan alami bernutrisi, tetapi bukan obat dan tidak akan cukup membantu dengan permasalahan storyline.",
                    "price" => 200,
                    "return_rate" => 0.0500,
                ],
            ],
            [
                [
                    "name" => "Lithium",
                    "image" => "assets/phase3/LITHIUM.png",
                    "description" => "Bahan baku utama baterai EV, permintaan global meningkat.",
                    "price" => 500,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Kobalt",
                    "image" => "assets/phase3/KOBALT.png",
                    "description" => "Digunakan dalam katoda baterai EV, rantai pasok rentan dan mahal.",
                    "price" => 350,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Nikel",
                    "image" => "assets/phase3/NIKEL",
                    "description" => "Komponen utama baterai EV tipe NMC (Nickel Manganese Cobalt), namun kurang ramah lingkungan saat proses ekstraksi.",
                    "price" => 450,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Tembaga",
                    "image" => "assets/phase3/TEMBAGA.png",
                    "description" => "Dibutuhkan dalam sistem kelistrikan EV, motor, dan charging. Namun, tidak bertampak langsung terhadap pengurangan emisi atau efisiensi energi.",
                    "price" => 350,
                    "return_rate" => 0.0500,
                ],
                [
                    "name" => "Cat Otomotif",
                    "image" => "assets/phase3/CAT_OTOMOTIF.png",
                    "description" => "Digunakan dalam finishing kendaraan, tapi tidak berdampak langsung terhadap pengurangan emisi atau efisiensi energi.",
                    "price" => 200,
                    "return_rate" => 0.0500,
                ],
                [
                    "name" => "Panel Surya",
                    "image" => "assets/phase3/PANEL_SURYA.png",
                    "description" => "Digunakan untuk proses isi ulang baterai kendaraan EV.",
                    "price" => 300,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "EV Charging Unit",
                    "image" => "assets/phase3/EV_CHARGING_UNIT.png",
                    "description" => "Infrastruktur penting untuk mendukung pertumbuhan EV.",
                    "price" => 500,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Ban Karet Sintetis",
                    "image" => "assets/phase3/BAN_KARET_SINTETIS.png",
                    "description" => "Dipakai di semua kendaraan, tapi tidak spesifik mendukung transisi EV atau target karbon.",
                    "price" => 200,
                    "return_rate" => 0.0500,
                ],
                [
                    "name" => "Hydrogen Fuel Cell",
                    "image" => "assets/phase3/HYDROGEN_FUEL_CELL.png",
                    "description" => "Alternatif teknologi rendah emisi untuk kendaraan berat.",
                    "price" => 450,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Bioplastik Otomotif",
                    "image" => "assets/phase3/BIOPLASTIK_OTOMOTIF.png",
                    "description" => "Material ramah lingkungan untuk interior kendaraan, namun kurang kokoh.",
                    "price" => 350,
                    "return_rate" => 0.0750,
                ],
            ],
            [
                [
                    "name" => "Kemasan Bioplastik",
                    "image" => "assets/phase4/KEMASAN_BIOPLASTIK.png",
                    "description" => "Jenis plastik biodegradable yang mengurangi ketergantungan pada plastik konvensional, tetapi rapuh dengan daya tahan yang rendah.",
                    "price" => 300,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Sumur Resapan",
                    "image" => "assets/phase4/SUMUR_RESAPAN.png",
                    "description" => "Menginvestasi dalam skala yang besar dapat menambah cadangan air tanah negara sekaligus mengurangi laju kota tenggelam dengan mencegah banjir.",
                    "price" => 350,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Edible Packaging",
                    "image" => "assets/phase4/EDIBLE_PACKAGING.png",
                    "description" => "Alternatif kemasan yang ramah lingkungan tetapi memiliki biaya produksi yang tinggi dan umur simpan yang pendek.",
                    "price" => 250,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Green Roof",
                    "image" => "assets/phase4/GREEN_ROOF.png",
                    "description" => "Membantu mengurangi emisi dan polusi perkotaan sekaligus masalah kekurangan air.",
                    "price" => 300,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Batu Bara Berkalori Rendah",
                    "image" => "assets/phase4/BATU_BARA_BERKALORI_RENDAH.png",
                    "description" => "Bahan bakar beremisi tinggi yang kurang efisien dibanding batu bara biasa dan akan terhambat oleh kebijakan transisi energi pemerintah.",
                    "price" => 200,
                    "return_rate" => 0.0500,
                ],
                [
                    "name" => "Resin Plastik Daur Ulang",
                    "image" => "assets/phase4/RESIN_PLASTIK_DAUR_ULANG.png",
                    "description" => "Mengurangi ketergantungan pada plastik baru sehingga dapat menjadi solusi untuk limbah produksi manufaktur plastik.",
                    "price" => 400,
                    "return_rate" => 0.1000,
                ],
                [
                    "name" => "Sedotan Bambu",
                    "image" => "assets/phase4/SEDOTAN_BAMBU.png",
                    "description" => "Alternatif sedotan plastik dan Tiongkok merupakan penghasil bambu terbesar di dunia, namun sedotan bambu mengandung PFAS yang berbahaya bagi satwa liar dan lingkungan.",
                    "price" => 150,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Sensor Kualitas Udara",
                    "image" => "assets/phase4/SENSOR_KUALITAS_UDARA.png",
                    "description" => "Membantu pengawasan langsung di zona manufaktur besar, namun tidak dapat menyelesaikan masalah.",
                    "price" => 350,
                    "return_rate" => 0.0500,
                ],
                [
                    "name" => "Insulasi Serat Kayu",
                    "image" => "assets/phase4/INSULASI_SERAT_KAYU.png",
                    "description" => "Mengurangi energi pendingin atau pemanas sehingga menekan emisi karbon dari bangunan pabrik dan apartemen kota. Namun, rentan terhadap api, serangga, dan dapat menjadi tempat jamur berkembang biak.",
                    "price" => 200,
                    "return_rate" => 0.0750,
                ],
                [
                    "name" => "Mesin Industri Hemat Energi",
                    "image" => "assets/phase4/MESIN_INDUSTRI_HEMAT_ENERGI.png",
                    "description" => "Komoditas penting untuk modernisasi pabrik-pabrik tua agar hemat energi dan kurangi jejak karbon.",
                    "price" => 500,
                    "return_rate" => 0.1000,
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
