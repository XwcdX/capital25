<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            ['question' => 'Pendekatan Life Cycle Assessment (LCA) dikenal sebagai cradle to grave, yaitu metode untuk menilai sistem industri dengan mempertimbangkan semua tahapan dalam siklus hidup produk. Berdasarkan pendekatan cradle to grave, tahapan dimulai dan berakhir pada titik mana?'],
            ['question' => 'Dalam praktiknya, Lifecycle Assessment (LCA) dapat dicirikan oleh prinsip-prinsip berikut: Siklus hidup perspektif, kelengkapan, transparansi, fleksibilitas, sifat iteratif, fokus lingkungan, berbasis alam, dan potensi dampak lingkungan. Apa yang dimaksud dengan LCA berbasis sains?'],
            // ['question' => 'Circular Economy (CE) adalah model ekonomi yang bertujuan untuk meminimalkan sampah dan memaksimalkan penggunaan kembali sumber daya. Tidak seperti model  tradisional "take, make, dispose," CE beroperasi berdasarkan tiga prinsip dasar, kecuali… '],
            // ['question' => 'Mengintegrasikan Circular Economy (CE) dengan Lifecycle Assessment (LCA) merupakan pendekatan holistik untuk mencapai keberlanjutan. Sementara CE berfokus pada upaya menjaga produk, material, dan sumber daya agar tetap dapat digunakan selama mungkin, LCA memberikan analisis terperinci tentang dampak lingkungan pada setiap tahap siklus hidup produk. Bagaimana konsep LCA dapat mendukung CE?'],
            // ['question' => 'El Nino adalah fenomena iklim yang memengaruhi berbagai aspek lingkungan dan kehidupan manusia. Fenomena ini dapat menyebabkan kekeringan parah, peningkatan risiko kebakaran hutan, serta defisit air di waduk, danau, dan sungai. Namun, di balik dampak buruk tersebut, terdapat salah satu dampak positif dari El Nino, yaitu… '],
            // ['question' => 'Urutkan langkah-langkah pertanian organik di bawah ini dari yang pertama hingga terakhir!<br>
            // 1) Penanganan Pasca Panen <br>
            // 2) Pemasaran pertanian organik <br>
            // 3) Sertifikasi pertanian organik <br>
            // 4) Penyiapan benih tanaman <br> 
            // 5) Penyiapan lahan <br>
            // 6) Pengendalian hama dan penyakit <br>
            // 7) Pupuk dan Penyubur tanah <br>
            // 8) Kondisi pengairan'],
            
        ];

        foreach($questions as $question){
            Question::create($question);
        }
    }
}
