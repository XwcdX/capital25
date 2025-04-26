<?php

namespace App\Enums;

use PhpParser\Node\Expr\Cast\String_;

enum QuizRules : String
{
    case QUIZ_TIME_LIMIT = 'Tes akan berlangsung selama 30 menit dan dapat diakses melalui <i>Website</i> CAPITAL 2025.';
    case LAPTOP = 'Tim wajib menggunakan <i>laptop</i> untuk mengerjakan tes dan memastikan <i>device</i> memiliki koneksi internet yang stabil.';
    case NO_CHEATING = 'Peserta tidak diperkenankan untuk membuka aplikasi atau tab lain selama tes berlangsung';
    case NO_DISCUSSION = 'Peserta dilarang berdiskusi dengan tim lain untuk menentukan jawaban.';
    case TOTAL_QUESTIONS = 'Tes terdiri dari 20 soal pilihan ganda';
    case RANDOM_ANSWER = 'Peserta dapat mengakses soal secara acak (tidak harus berurutan) dan mengganti jawaban selama waktu masih ada.';
    case STORE_ANSWER = 'Setelah waktu habis, jika peserta belum menekan tombol "<i>Submit</i>", sistem akan menyimpan jawaban tes secara otomatis.';
    case TECHNICAL_PROBLEM = 'Jika peserta mengalami masalah teknis, segera hubungi pengawas tes untuk bantuan.';
    case GREEN_POINTS = 'Setiap jawaban benar dalam tes akan menambahkan 2500 <i>Green Points</i> yang akan berpengaruh pada akumulasi koin akhir dalam penentuan pemenang.';
}


