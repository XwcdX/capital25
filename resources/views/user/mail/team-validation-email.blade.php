@extends('user.mail.layout')

@section('style')
@endsection

@section('content')
    <p><b>Halo {{ $name }},</b></p>
    @if (isset($feedback))
        <p>Terima kasih telah mendaftar <b>CAPITAL 2025.</b> Setelah melakukan pengecekan, terdapat beberapa hal yang perlu
            diperbaiki dari data kelompok yang dikirimkan.</p>
        <p style="margin: 14px 0 0">Berikut adalah detail perbaikan yang diperlukan:</p>
        <ul style="margin: 0;">
            <li style="margin-bottom: 3px;">
                <div style="display: inline-block; width: 180px; font-weight: bold;">
                    <p style="margin: 0">Nama Kelompok</p>
                </div>
                <div style="display: inline-block;"><p style="margin: 0">: </p></div>
                <div style="display: inline-block;"><p style="margin: 0">{{ $name }}</p></div>
            </li>
            <li style="margin-bottom: 3px;">
                <div style="display: inline-block; width: 180px; font-weight: bold;">
                    <p style="margin: 0">Perbaikan yang Diperlukan</p>
                </div>
                <div style="display: inline-block;"><p style="margin: 0">:</p></div>
                <p style="margin: 0">{!! $feedback !!}</p>
            </li>
        </ul>
        <p style="margin: 14px 0 0">Mohon untuk segera memperbaiki dan mengirimkan kembali data yang telah diperbaiki dalam jangka waktu <b>2 hari
                sejak
                email ini dikirimkan.</b> Data dapat dikirimkan kembali melalui website CAPITAL dengan langkah berikut:</p>
        <ol style="margin: 0;">
            <li style="margin-bottom: 3px;">
                <p style="margin: 0;">Masuk ke website CAPITAL melalui link berikut: <a
                        href="http://capital.petra.ac.id">capital.petra.ac.id</a>
                </p>
            </li>
            <li style="margin-bottom: 3px;">
                <p style="margin: 0;">Login dengan akun yang telah didaftarkan</p>
            </li>
            <li style="margin-bottom: 3px;">
                <p style="margin: 0;">Pilih Edit Data</p>
            </li>
            <li style="margin-bottom: 3px;">
                <p style="margin: 0;">Lakukan perbaikan yang diperlukan</p>
            </li>
            <li style="margin-bottom: 3px;">
                <p style="margin: 0;">Klik Simpan untuk menyelesaikan perubahan</p>
            </li>
        </ol>
    @else
        <p><b>Congratulations! 🎉</b></p>
        <p>Kami dengan senang hati mengonfirmasi bahwa data yang dikirimkan telah <b>BERHASIL</b> divalidasi.</p>
        <p>Selanjutnya, kami akan mengirimkan informasi lebih lanjut mengenai teknis pelaksanaan dan hal-hal lain yang perlu
            dipersiapkan melalui Grup LINE. <b>Silahkan semua anggota kelompok</b> bergabung melalui link berikut ini:</p>
        <table role="presentation" style="margin: 10px auto; text-align: center; width: 100%; border-spacing: 0;">
            <tr>
                <td>
                    <a href="http://petra.id/GroupPesertaCAPITAL2025" target="_blank"
                        style="display: inline-block; background: #344e41; color: white; text-decoration: none; border-radius: 25px; padding: 12px 0; width: 100%; font-size: 0.8em; max-width: 600px; font-weight: bold;">
                        📢 Group Peserta CAPITAL 2025
                    </a>
                </td>
            </tr>
        </table>
    @endif
    <p>Jika ada pertanyaan lebih lanjut, silahkan menghubungi kami di contact person berikut:</p>
    <table role="presentation" style="margin: 10px auto; text-align: center; width: 100%; border-spacing: 0;">
        <tr>
            <td>
                <a href="https://line.me/ti/p/@651ujcmf" target="_blank"
                    style="display: inline-block; background: #4A90E2; color: white; text-decoration: none; border-radius: 25px; padding: 12px 0; width: 100%; font-size: 0.8em; max-width: 600px; font-weight: bold;">
                    📲 OA LINE : @651ujcmf
                </a>
            </td>
        </tr>
    </table>

    <table role="presentation" style="margin: 10px auto; text-align: center; width: 100%; border-spacing: 0;">
        <tr>
            <td>
                <a href="https://wa.me/6281285583998" target="_blank"
                    style="display: inline-block; background: #25D366; color: white; text-decoration: none; border-radius: 25px; padding: 12px 0; width: 100%; font-size: 0.8em; max-width: 600px; font-weight: bold;">
                    📞 WhatsApp : +62 812 8558 3998 (Nadine)
                </a>
            </td>
        </tr>
    </table>
    @if (isset($feedback))
        <p>Thank you for your cooperation! Can’t wait to see you at CAPITAL 2025 👋.</p>
    @else
        <p>We’re super excited to see you at CAPITAL 2025 🥳!</p>
    @endif
    <p>Best Regards, <br><b>CAPITAL 2025 🌱</b></p>
@endsection
