@extends('user.mail.layout')

@section('style')
@endsection

@section('content')
    <p><b>Halo {{ $name }},</b></p>
    <p>Terima kasih telah mendaftar CAPITAL 2025! Pendaftaran kalian <b>sudah berhasil kami terima.</b></p>
    <p>Silahkan cek email secara berkala untuk mendapatkan <b>email validasi data</b> yang akan dikirimkan dalam waktu
        maksimal 3 hari kerja.</p>
    <p>Jika ada pertanyaan lebih lanjut, silahkan menghubungi kami di contact person berikut:</p>
    <table role="presentation" style="margin: 10px auto; text-align: center; width: 300px; border-spacing: 0;">
        <tr>
            <td>
                <a href="https://line.me/ti/p/@651ujcmf" target="_blank"
                    style="display: block; background: #4A90E2; color: white; text-decoration: none; border-radius: 25px; width: 300px; height: 50px; line-height: 50px; text-align: center; font-size: 16px; font-weight: bold;">
                    📲 OA LINE : @651ujcmf
                </a>
            </td>
        </tr>
    </table>
    <table role="presentation" style="margin: 10px auto; text-align: center; width: 300px; border-spacing: 0;">
        <tr>
            <td>
                <a href="https://wa.me/6281285583998 " target="_blank"
                    style="display: block; background: #25D366; color: white; text-decoration: none; border-radius: 25px; width: 300px; height: 50px; line-height: 50px; text-align: center; font-size: 16px; font-weight: bold;">
                    📞 WhatsApp : +62 812 8558 3998 (Nadine)
                </a>
            </td>
        </tr>
    </table>
    <p>Can’t wait to see you at CAPITAL 2025! 👋🏻</p>
    <p>Best Regards, <br><b>CAPITAL 2025 🌱</b></p>
@endsection
