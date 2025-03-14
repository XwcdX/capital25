@extends('user.layout')

@section('style')
    <style>
        .modal {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            position: relative;
            width: 50vw;
            /* Menggunakan viewport width */
            max-width: 800px;
            /* Maksimum ukuran untuk layar besar */
            min-width: 300px;
            /* Batas minimum agar tidak terlalu kecil */
            background: #f8f5f0;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease-in-out;
        }

        .modal-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .modal-body {
            font-size: 16px;
            color: #555;
            max-height: 300px;
            overflow-y: auto;
            text-align: left;
            padding: 10px 15px;
        }

        .modal-body p {
            margin-bottom: 15px;
            /* Jarak antar nomor diperbesar */
            line-height: 1.6;
        }

        .modal-footer {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-button {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .start-btn {
            background-color: #2d4a3e;
            color: white;
        }

        .start-btn:hover {
            background-color: #1e352b;
        }

        .back-btn {
            background-color: #ddd;
            color: #333;
        }

        .back-btn:hover {
            background-color: #bbb;
        }

        /* Responsiveness */
        @media (max-width: 800px) {
            .modal-content {
                width: 95%;
                max-width: 500px;
                padding: 20px;
            }

            .modal-body {
                font-size: 14px;
            }

            .modal-button {
                font-size: 12px;
                padding: 8px 15px;
            }
        }

        /* Jika layar besar, modal lebih besar */
        @media (min-width: 1200px) {
            .modal-content {
                width: 60vw;
                max-width: 900px;
                padding: 30px;
            }
        }

        /* Jika layar kecil, modal lebih kecil */
        @media (max-width: 768px) {
            .modal-content {
                width: 80vw;
                max-width: 500px;
                padding: 20px;
            }

            .modal-body {
                font-size: 14px;
            }

            .modal-button {
                font-size: 12px;
                padding: 8px 15px;
            }
        }

        /* Modal di layar HP (super kecil) */
        @media (max-width: 480px) {
            .modal-content {
                width: 90vw;
                max-width: 350px;
                padding: 15px;
            }

            .modal-title {
                font-size: 20px;
            }

            .modal-body {
                font-size: 12px;
            }

            .modal-button {
                font-size: 10px;
                padding: 6px 12px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="modal" id="exampleModalComponents">
        <div class="modal-content">
            <h5 class="modal-title">PERATURAN</h5>
            <div class="modal-body">
                <p>1. Tes akan berlangsung selama 30 menit dan dapat diakses melalui Website CAPITAL 2025.</p>
                <p>2. Tim wajib menggunakan laptop untuk mengerjakan tes dan memastikan device memiliki koneksi internet
                    yang stabil.</p>
                <p>3. Peserta tidak diperkenankan untuk membuka aplikasi atau tab lain selama tes berlangsung.</p>
                <p>4. Peserta dilarang berdiskusi dengan tim lain untuk menentukan jawaban.</p>
                <p>5. Tes terdiri dari 20 soal pilihan ganda.</p>
                <p>6. Peserta dapat mengakses soal secara acak (tidak harus berurutan) dan mengganti jawaban selama waktu
                    masih ada.</p>
                <p>7. Setelah waktu habis, jika peserta belum menekan tombol "Submit", sistem akan menyimpan jawaban tes
                    secara otomatis.</p>
                <p>8. Jika peserta mengalami masalah teknis, segera hubungi pengawas tes untuk bantuan.</p>
                <p>9. Setiap jawaban benar dalam tes akan menambahkan … Green Points yang akan berpengaruh pada akumulasi
                    koin akhir dalam penentuan pemenang.</p>
            </div>
            <div class="modal-footer">
                <button class="modal-button start-btn" onclick="startQuiz()">START</button>
                <button class="modal-button back-btn" onclick="back()">BACK</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function startQuiz() {
            window.location.href = "{{ route('quiz') }}";
        }

        function back() {
            window.location.href = "{{ route('home') }}";
        }
    </script>
@endsection
