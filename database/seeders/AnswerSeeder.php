<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $questions = Question::all();
        $answers = [
            // Answers for Question 1
            ['question_id' => $questions[0]->id, 'answer_text' => 'Dimulai dengan pengumpulan bahan baku dari alam untuk menghasilkan produk, dan berakhir pada titik ketika semua bahan dikembalikan ke alam.', 'is_correct' => true],
            ['question_id' => $questions[0]->id, 'answer_text' => 'Dimulai dengan proses produksi di pabrik, dan berakhir ketika produk didaur ulang menjadi bahan baru.', 'is_correct' => false],
            ['question_id' => $questions[0]->id, 'answer_text' => 'Dimulai dengan distribusi produk ke konsumen, dan berakhir ketika produk habis digunakan.', 'is_correct' => false],
            ['question_id' => $questions[0]->id, 'answer_text' => 'Dimulai dengan pembuatan bahan baku sintetis, dan berakhir ketika produk disimpan di tempat pembuangan akhir.', 'is_correct' => false],

            // Answers for Question 2
            ['question_id' => $questions[1]->id, 'answer_text' => 'LCA idealnya mencakup semua aspek lingkungan, seperti bahan baku, ekologis integritas sistem, dan pertimbangan kesehatan manusia.', 'is_correct' => false],
            ['question_id' => $questions[1]->id, 'answer_text' => 'LCA harus dipastikan interpretasinya yang tepat atas hasil karena kompleksitas yang melekat dalam penilaian sistemnya.', 'is_correct' => false],
            ['question_id' => $questions[1]->id, 'answer_text' => 'LCA mempelajari aspek lingkungan dari sistem produk, termasuk aspek ekonomi dan sosial berada di luar penelitian.', 'is_correct' => false],
            ['question_id' => $questions[1]->id, 'answer_text' => 'LCA harus menggunakan metodologi dan studi yang berdasarkan ilm, dari keadaan tertentu pengetahuan pada waktu tertentu.', 'is_correct' => true],
        ];

        // DB::table('answers')->insert($answers);
        foreach ($answers as $answer)
        {
            Answer::create($answer);
        }
    }
}
