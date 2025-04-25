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
                'question' => 'Pendekatan <i>Life Cycle Assessment</i> (LCA) dikenal sebagai <i>cradle to grave</i>, yaitu metode untuk menilai sistem industri dengan mempertimbangkan semua tahapan dalam siklus hidup produk. Berdasarkan pendekatan cradle to grave, tahapan dimulai dan berakhir pada titik mana?',
                'answers' => [
                    'Dimulai dengan pengumpulan bahan baku dari alam untuk menghasilkan produk, dan berakhir pada titik ketika semua bahan dikembalikan ke alam.*',
                    'Dimulai dengan proses produksi di pabrik, dan berakhir ketika produk didaur ulang menjadi bahan baru.',
                    'Dimulai dengan distribusi produk ke konsumen, dan berakhir ketika produk habis digunakan.',
                    'Dimulai dengan pembuatan bahan baku sintetis, dan berakhir ketika produk disimpan di tempat pembuangan akhir.',
                ],
            ],
            [
                'question' => 'Dalam praktiknya, <i>Lifecycle Assessment</i> LCA dapat dicirikan oleh prinsip-prinsip berikut: Siklus hidup perspektif, kelengkapan, transparansi, fleksibilitas, sifat iteratif, fokus lingkungan, berbasis alam, dan potensi dampak lingkungan. Apa yang dimaksud dengan LCA berbasis sains?',
                'answers' => [
                    'LCA idealnya mencakup semua aspek lingkungan, seperti bahan baku, ekologis integritas sistem, dan pertimbangan kesehatan manusia.',
                    'LCA harus dipastikan interpretasinya yang tepat atas hasil karena kompleksitas yang melekat dalam penilaian sistemnya.',
                    'LCA mempelajari aspek lingkungan dari sistem produk, termasuk aspek ekonomi dan sosial berada di luar penelitian.',
                    'LCA harus menggunakan metodologi dan studi yang berdasarkan ilmu, dari keadaan tertentu pengetahuan pada waktu tertentu.*',
                ],
            ],
            [
                'question' => '<i>Circular Economy</i> (CE) adalah model ekonomi yang bertujuan untuk meminimalkan sampah dan memaksimalkan penggunaan kembali sumber daya. Tidak seperti model  tradisional "<i>take, make, dispose,</i>" CE beroperasi berdasarkan tiga prinsip dasar, kecuali...',
                'answers' => [
                    'Menciptakan produk yang dirancang untuk bertahan lebih lama',
                    'Menggunakan bahan sintetis untuk memenuhi kebutuhan konsumen*',
                    'Optimalisasi penggunaan bahan baku untuk menjaga kelestarian SDA',
                    'Mendaur ulang material bekas supaya dapat digunakan kembali',
                ],
            ],
            [
                'question' => 'Mengintegrasikan <i>Circular Economy</i> (CE) dengan <i>Lifecycle Assessment</i> (LCA) merupakan pendekatan holistik untuk mencapai keberlanjutan. Sementara CE berfokus pada upaya menjaga produk, material, dan sumber daya agar tetap dapat digunakan selama mungkin, LCA memberikan analisis terperinci tentang dampak lingkungan pada setiap tahap siklus hidup produk. Bagaimana konsep LCA dapat mendukung CE?',
                'answers' => [
                    'Identifikasi dampak lingkungan',
                    'Pengembangan produk berkelanjutan',
                    'Pemantauan dan perbaikan berkelanjutan',
                    'Semua jawaban benar*',
                ],
            ],
            [
                'question' => 'El Nino adalah fenomena iklim yang memengaruhi berbagai aspek lingkungan dan kehidupan manusia. Fenomena ini dapat menyebabkan kekeringan parah, peningkatan risiko kebakaran hutan, serta defisit air di waduk, danau, dan sungai. Namun, di balik dampak buruk tersebut, terdapat salah satu dampak positif dari El Nino, yaitu...',
                'answers' => [
                    'Produksi garam meningkat akibat paparan sinar matahari yang berlangsung lebih lama*',
                    'Hasil panen padi meningkat karena berkurangnya hujan yang menghambat pertumbuhan tanaman',
                    'Pengurangan penyakit tropis seperti malaria karena menurunnya populasi nyamuk',
                    'Produksi energi listrik dari tenaga air meningkat karena kenaikan suhu',
                ],
            ],
            [
                'question' => 'Urutkan langkah-langkah pertanian organik dari yang pertama hingga terakhir!<br>
                1) Penanganan Pasca Panen<br> 2) Pemasaran pertanian organik<br> 3) Sertifikasi pertanian organik<br> 4) Penyiapan benih tanaman<br> 5) Penyiapan lahan<br> 6) Pengendalian hama dan penyakit<br> 7) Pupuk dan Penyubur Tanah<br> 8) Kondisi pengairan',
                'answers' => [
                    '5 - 8 - 4 - 6 - 7 - 1 - 2 - 3',
                    '5 - 8 - 4 - 7 - 6 - 3 - 1 - 2',
                    '5 - 8 - 4 - 7 - 6 - 1 - 3 - 2*',
                    '8 - 5 - 4 - 7 - 6 - 1 - 3 - 2',
                ],
            ],
            [
                'question' => 'Seorang petani organik menghadapi masalah di lahannya di mana tanaman mulai terancam oleh hama dan penyakit. Petani tersebut ingin menemukan solusi yang ramah lingkungan tanpa menggunakan pestisida kimia. Apa langkah terbaik yang harus dilakukan petani untuk melindungi tanaman dari hama dan penyakit?',
                'answers' => [
                    'Irigasi hemat air',
                    'Penanaman tumpang sari',
                    'Kompos',
                    'Penanaman tanaman penghalang*',
                ],
            ],
            [
                'question' => 'Pilih jawaban yang paling tepat!<br> Sistem <i>waste-to-energy</i> dapat diterapkan di sektor industri?',
                'answers' => [
                    'Manufaktur',
                    'Pertanian',
                    'Kelistrikan*',
                    'Perkotaan',
                ],
            ],
            [
                'question' => 'Perubahan suhu air dapat memengaruhi industri perikanan secara signifikan, seperti mengganggu habitat ikan, mengurangi populasi spesies, dan menurunkan hasil tangkapan. Dari negara-negara berikut ini, mana yang paling tidak terdampak oleh perubahan suhu air terkait industri perikanan?',
                'answers' => [
                    'Indonesia',
                    'Laos*',
                    'Jepang',
                    'Norwegia',
                ],
            ],
            [
                'question' => '<i>Carbon tax</i> adalah pajak yang dikenakan kepada setiap produk atau barang yang menghasilkan emisi karbon. Apa tujuan utama dari penerapan <i>carbon tax</i> oleh pemerintah Indonesia?',
                'answers' => [
                    'Meningkatkan pendapatan negara dari sektor industri',
                    'Mengurangi emisi gas rumah kaca dengan memberi harga pada karbon*',
                    'Mendorong penggunaan energi terbarukan di sektor industri',
                    'Membatasi impor produk berbasis bahan bakar fosil',
                ],
            ],
            [
                'question' => '<i>Paris Agreement</i> menargetkan netralitas karbon pada 2050, sehingga transisi ke kendaraan listrik (EV) menjadi krusial untuk mengurangi emisi dari sektor transportasi. Negara mana yang perlu melakukan transformasi besar karena sektor otomotifnya yang sangat besar?',
                'answers' => [
                    'Cina*',
                    'Thailand',
                    'Australia',
                    'Turki',
                ],
            ],
            [
                'question' => 'Dengan meningkatnya penggunaan perangkat elektronik dan kendaraan listrik, kebutuhan akan baterai semakin meningkat, menghadirkan tantangan lingkungan baru terkait limbah baterai. Teknologi daur ulang baterai menjadi solusi penting untuk mengatasi masalah ini, memungkinkan pemulihan bahan berharga dan mengurangi dampak lingkungan. Praktik yang dapat diterapkan adalah...',
                'answers' => [
                    '<i>Hydrometallurgy</i>*',
                    '<i>Agroforestry</i>',
                    '<i>Bioremediation</i>',
                    '<i>Recharge pits</i>',
                ],
            ],
            [
                'question' => 'Dalam ilmu manajemen rantai pasok, penerapan rantai pasok dengan memperhatikan isu lingkungan dan <i>sustainability</i> dikenal dengan <i>green supply chain</i>. Pengukuran kinerja <i>green supply chain</i> yang berhubungan dengan tahap <i>delivery</i> di antara pilihan di bawah ini adalah...',
                'answers' => [
                    'Produk retur yang dibuang berbanding produk retur yang didaur ulang',
                    'Biaya disposal sebagai persentase total biaya pengadaan',
                    'Biaya bahan bakar sebagai persentase biaya pengiriman*',
                    'Persentase pemasok yang memiliki sistem EMS atau sertifikasi ISO 14001',
                ],
            ],
            [
                'question' => 'Aktivitas <i>procurement</i> mencakup pengadaan barang, mulai dari pemilihan supplier hingga pembelian. Dengan fokus pada efisiensi biaya bahan baku dan keberlanjutan, <i>green procurement</i> yang efisien dapat mendukung tujuan bisnis sekaligus pelestarian lingkungan. Yang merupakan tindakan <i>green procurement</i> adalah',
                'answers' => [
                    'Menggunakan <i>third party-logistics</i> yang menawarkan solusi <i>green transportation</i>',
                    'Menggunakan alternatif kendaraan listrik',
                    'Memilih sumber bahan baku dengan efek yang kecil terhadap kerusakan lingkungan*',
                    'Melakukan <i>recycle</i> dari limbah yang dihasilkan <i>output</i> produk',
                ],
            ],
            [
                'question' => 'Memperingati Hari Bumi 22 April 2022, Unilever dan Lazada memperkenalkan program <i>Easy Green</i> untuk mengedukasi konsumen agar dapat lebih cermat dalam membeli suatu produk, dengan memperhatikan upaya-upaya pelestarian alam yang diusung. Salah satu kriteria yang harus dipenuhi oleh produk untuk mendapatkan label ini adalah setidaknya 99% dari formulasi produk harus dapat terurai secara alami. Tantangan yang mungkin muncul dalam memenuhi kriteria ini yaitu...',
                'answers' => [
                    'Kesulitan mendapatkan bahan baku yang ramah lingkungan',
                    'Biaya produksi yang lebih tinggi untuk bahan yang dapat terurai*',
                    'Ketidakpastian kualitas produk yang ramah lingkungan',
                    'Kurangnya kesadaran konsumen terhadap produk ramah lingkungan',
                ],
            ],
            [
                'question' => 'Toyota adalah perusahaan otomotif multinasional yang berasal dari Jepang, terkenal sebagai salah satu produsen mobil terbesar di dunia. Sebagai bagian dari komitmen mereka mencapai <i>net zero emission</i>, mereka menggunakan solar panel dalam proses manufaktur, berhasil menekan penggunaan listrik dari 7 megawatt ke 4 megawatt. Selain itu, Toyota juga menciptakan kendaraan yang ramah lingkungan, menyiapkan mobil dengan mesin yang bisa bergerak dengan bahan bakar nabati (bioetanol). Upaya-upaya tersebut merupakan bagian dari tahapan ',
                'answers' => [
                    '<i>Use and Maintenance</i>',
                    '<i>Production</i>*',
                    '<i>Disposal</i>',
                    '<i>Recycling</i>',
                ],
            ],
            [
                'question' => 'Keuntungan dan kerugian dari penggunaan energi alternatif yang tepat secara berturut-turut adalah...',
                'answers' => [
                    'Ketergantungan pada kondisi musim; meningkatkan potensi ekonomi',
                    'Efisiensi yang masih terbatas; kebutuhan sistem penyimpanan yang memadai',
                    'Lebih murah dalam jangka panjang; kompleksitas teknologi lebih tinggi*',
                    'Perawatan yang terjangkau; gratis dan melimpah',
                ],
            ],
            [
                'question' => `<i>Green manufacturing</i> adalah penciptaan produk dengan cara yang mengurangi jejak karbon keseluruhan dari proses manufaktur. Manufaktur hijau meminimalkan dampak negatif terhadap lingkungan sekaligus menghemat energi dan sumber daya alam. Berdasarkan pilihan di bawah ini, manakah yang tidak mencerminkan prinsip <i>green manufacturing</i>?<br>1) Tesla mengembangkan kendaraan listrik dan mengoperasikan Gigafactory yang didukung oleh energi matahari.<br>
                Amazon memiliki pusat data Amazon Web Services (AWS) yang mengonsumsi energi dalam jumlah besar.<br>
                Samsung berkomitmen mengalihkan semua limbah yang dihasilkan oleh fasilitas manufaktur dari tempat pembuangan sampah.<br>
                Nestlé menargetkan kemasannya 100% <i>recyclable</i> atau <i>reusable</i> pada tahun 2025.<br>`,
                'answers' => [
                    'Hanya 1',
                    'Hanya 2',
                    '2 dan 3',
                    '2 dan 4*',
                ],
            ],
            [
                'question' => '<i>Greenwashing</i> terjadi ketika perusahaan membuat klaim yang menyesatkan tentang upaya lingkungan mereka. Sering kali mereka menekankan aspek keberlanjutan dalam pemasaran, sementara gagal menangani dampak lingkungan yang lebih besar dari aktivitas mereka secara keseluruhan. Salah satu perusahaan yang terkena tuduhan ini adalah Starbucks. Starbucks mengklaim bahwa 100% kopinya bersumber dari petani yang mengikuti standar etis di bawah program Coffee and Farmer Equity (C.A.F.E). Namun, terdapat gugatan yang ditujukan terhadap Starbucks, mengutip beberapa laporan jurnalistik dan peraturan, yang menuduh bahwa pelanggaran hak asasi manusia masih terjadi di pertanian pemasok Starbucks termasuk pekerja anak, kerja paksa, dan pelecehan seksual. Kasus ini menggarisbawahi masalah yang muncul pada proses...',
                'answers' => [
                    '<i>Raw material extraction</i>*',
                    '<i>Production</i>',
                    '<i>Use and maintenance</i>',
                    '<i>Disposal</i>',
                ],
            ],
            [
                'question' => 'Menurut prediksi World Economic Forum (WEF) kota yang terancam tenggelam akibat kenaikan permukaan air laut yang dipicu oleh pemanasan global pada tahun 2100 adalah... (Petunjuk: Beban dari gedung pencakar langit dan bangunan besar lainnya yang dianggap terlalu berat di kota ini menjadi salah satu faktor)',
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
