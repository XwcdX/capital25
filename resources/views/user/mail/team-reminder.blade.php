@extends('user.mail.layout')

@section('content')
    <p>Hello Team {{ $teamName }}👋🏻🌱,</p>
    
    <p>Terima kasih telah mendaftar di CAPITAL 2025! Kami ingin mengingatkan agar kalian dapat segera melengkapi data yang diperlukan supaya pendaftaran dapat diproses sepenuhnya.</p>
    
    <p>Silakan melengkapi data tersebut melalui <a href="http://capital.petra.ac.id" target="_blank">capital.petra.ac.id</a> sebelum tanggal 12 April 2025!</p>
    
    <p>Berikut merupakan tutorial step by step agar pendaftaran kalian dapat divalidasi oleh kami:</p>
    
    <p>
        <a href="https://drive.google.com/file/d/1ofL0oWFUoe0Pf1WLhT6F0kVQqOHsbOxP/view?usp=drivesdk" target="_blank">
            Klik disini untuk melihat tutorial
        </a>
    </p>
    
    <p>Jika ada pertanyaan atau kendala dalam pengisian, silahkan untuk menghubungi kami di:</p>
    
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
