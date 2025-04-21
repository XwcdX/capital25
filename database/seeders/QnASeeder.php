<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QnASeeder extends Seeder
{

    public function run(): void
    {
        $questions = [
            [
                'question' => 'Pendekatan <i>Life Cycle Assessment</i> (LCA) dikenal sebagai cradle to grave...',
                'answers' => [
                    'Dimulai dengan pengumpulan bahan baku dari alam untuk menghasilkan produk, dan berakhir pada titik ketika semua bahan dikembalikan ke alam.*',
                    'Dimulai dengan proses produksi di pabrik, dan berakhir ketika produk didaur ulang menjadi bahan baru.',
                    'Dimulai dengan distribusi produk ke konsumen, dan berakhir ketika produk habis digunakan.',
                    'Dimulai dengan pembuatan bahan baku sintetis, dan berakhir ketika produk disimpan di tempat pembuangan akhir.',
                ],
            ],
            [
                'question' => 'Dalam praktiknya, LCA dapat dicirikan oleh prinsip-prinsip berikut... Apa yang dimaksud dengan LCA berbasis sains?',
                'answers' => [
                    'LCA idealnya mencakup semua aspek lingkungan...',
                    'LCA harus dipastikan interpretasinya yang tepat...',
                    'LCA mempelajari aspek lingkungan dari sistem produk...',
                    'LCA harus menggunakan metodologi dan studi yang berdasarkan ilmu, dari keadaan tertentu pengetahuan pada waktu tertentu.*',
                ],
            ],
            [
                'question' => 'Circular Economy (CE) adalah model ekonomi... CE beroperasi berdasarkan tiga prinsip dasar, kecuali…',
                'answers' => [
                    'Menciptakan produk yang dirancang untuk bertahan lebih lama',
                    'Menggunakan bahan sintetis untuk memenuhi kebutuhan konsumen*',
                    'Optimalisasi penggunaan bahan baku untuk menjaga kelestarian SDA',
                    'Mendaur ulang material bekas supaya dapat digunakan kembali',
                ],
            ],
            [
                'question' => 'Bagaimana konsep LCA dapat mendukung CE?',
                'answers' => [
                    'Identifikasi dampak lingkungan',
                    'Pengembangan produk berkelanjutan',
                    'Pemantauan dan perbaikan berkelanjutan',
                    'Semua jawaban benar*',
                ],
            ],
            [
                'question' => 'Salah satu dampak positif dari El Nino adalah…',
                'answers' => [
                    'Produksi garam meningkat akibat paparan sinar matahari yang berlangsung lebih lama*',
                    'Hasil panen padi meningkat...',
                    'Pengurangan penyakit tropis seperti malaria...',
                    'Produksi energi listrik dari tenaga air meningkat...',
                ],
            ],
            [
                'question' => 'Urutkan langkah-langkah pertanian organik dari yang pertama hingga terakhir!',
                'answers' => [
                    '5 - 8 - 4 - 6 - 7 - 1 - 2 - 3',
                    '5 - 8 - 4 - 7 - 6 - 3 - 1 - 2',
                    '5 - 8 - 4 - 7 - 6 - 1 - 3 - 2*',
                    '8 - 5 - 4 - 7 - 6 - 1 - 3 - 2',
                ],
            ],
            [
                'question' => 'Langkah terbaik petani organik untuk melindungi tanaman dari hama dan penyakit adalah...',
                'answers' => [
                    'Irigasi hemat air',
                    'Penanaman tumpang sari',
                    'Kompos',
                    'Penanaman tanaman penghalang*',
                ],
            ],
            [
                'question' => 'Sistem waste-to-energy dapat diterapkan di sektor industri?',
                'answers' => [
                    'Manufaktur',
                    'Pertanian',
                    'Kelistrikan*',
                    'Perkotaan',
                ],
            ],
            [
                'question' => 'Negara yang paling tidak terdampak oleh perubahan suhu air terkait industri perikanan?',
                'answers' => [
                    'Indonesia',
                    'Laos*',
                    'Jepang',
                    'Norwegia',
                ],
            ],
            [
                'question' => 'Tujuan utama dari penerapan carbon tax oleh pemerintah Indonesia adalah...',
                'answers' => [
                    'Meningkatkan pendapatan negara dari sektor industri',
                    'Mengurangi emisi gas rumah kaca dengan memberi harga pada karbon*',
                    'Mendorong penggunaan energi terbarukan di sektor industri',
                    'Membatasi impor produk berbasis bahan bakar fosil',
                ],
            ],
            [
                'question' => 'Negara mana yang perlu transformasi besar karena sektor otomotifnya sangat besar?',
                'answers' => [
                    'Cina*',
                    'Thailand',
                    'Australia',
                    'Turki',
                ],
            ],
            [
                'question' => 'Praktik daur ulang baterai yang dapat diterapkan adalah...',
                'answers' => [
                    'Hydrometallurgy*',
                    'Agroforestry',
                    'Bioremediation',
                    'Recharge pits',
                ],
            ],
            [
                'question' => 'Pengukuran kinerja green supply chain yang berhubungan dengan tahap delivery adalah...',
                'answers' => [
                    'Produk retur yang dibuang berbanding produk retur yang didaur ulang',
                    'Biaya disposal sebagai persentase total biaya pengadaan',
                    'Biaya bahan bakar sebagai persentase biaya pengiriman*',
                    'Persentase pemasok yang memiliki sistem EMS atau sertifikasi ISO 14001',
                ],
            ],
            [
                'question' => 'Yang merupakan tindakan green procurement adalah…',
                'answers' => [
                    'Menggunakan third party-logistics yang menawarkan solusi green transportation',
                    'Menggunakan alternatif kendaraan listrik',
                    'Memilih sumber bahan baku dengan efek yang kecil terhadap kerusakan lingkungan*',
                    'Melakukan recycle dari limbah yang dihasilkan output produk',
                ],
            ],
            [
                'question' => 'Tantangan yang mungkin muncul dalam memenuhi label Easy Green adalah…',
                'answers' => [
                    'Kesulitan mendapatkan bahan baku yang ramah lingkungan',
                    'Biaya produksi yang lebih tinggi untuk bahan yang dapat terurai*',
                    'Ketidakpastian kualitas produk yang ramah lingkungan',
                    'Kurangnya kesadaran konsumen terhadap produk ramah lingkungan',
                ],
            ],
            [
                'question' => 'Upaya Toyota merupakan bagian dari tahapan … dalam LCA.',
                'answers' => [
                    'Use and Maintenance',
                    'Production*',
                    'Disposal',
                    'Recycling',
                ],
            ],
            [
                'question' => 'Keuntungan dan kerugian energi alternatif secara berturut-turut adalah…',
                'answers' => [
                    'Ketergantungan pada kondisi musim; meningkatkan potensi ekonomi',
                    'Efisiensi yang masih terbatas; kebutuhan sistem penyimpanan yang memadai',
                    'Lebih murah dalam jangka panjang; kompleksitas teknologi lebih tinggi*',
                    'Perawatan yang terjangkau; gratis dan melimpah',
                ],
            ],
            [
                'question' => 'Manakah yang tidak mencerminkan prinsip green manufacturing?',
                'answers' => [
                    'Tesla mengembangkan kendaraan listrik...',
                    'Amazon memiliki pusat data Amazon Web Services (AWS) yang mengonsumsi energi dalam jumlah besar.*',
                    'Samsung berkomitmen mengalihkan semua limbah...',
                    'Nestlé menargetkan kemasannya 100% recyclable...',
                ],
            ],
            [
                'question' => 'Kasus Starbucks menggarisbawahi masalah pada proses…',
                'answers' => [
                    'Raw material extraction*',
                    'Production',
                    'Use and maintenance',
                    'Disposal',
                ],
            ],
            [
                'question' => 'Kota yang terancam tenggelam akibat kenaikan permukaan laut karena gedung terlalu berat?',
                'answers' => [
                    'Osaka',
                    'Pattaya',
                    'New York*',
                    'Kuala Lumpur',
                ],
            ],
        ];

        foreach ($questions as $q) {
            $question = Question::create(['question' => $q['question']]);
        
            foreach ($q['answers'] as $index => $answer) {
                $isCorrect = Str::endsWith($answer, '*');
                $answerText = rtrim($answer, '*');
        
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answerText,
                    'is_correct' => $isCorrect,
                    'sort_order' => $index + 1,
                ]);
            }
        }
        
    }
}
