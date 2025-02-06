@extends('user.mail.layout')

@section('style')
    <style>
        .greetings {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .content {
            font-weight: bold;
            text-align: center;

            margin-bottom: 3px;
            width: 100%;
        }

        .content>p {
            font-size: 30px;
            text-transform: uppercase;
        }
        .closing {
            margin-top: 20px;
            font-size: 14px;
        }

        p {
            margin: 0;
            color: #000 !important;
        }
        a{
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <div class="">
        <div class="greetings">
            <h1>Password Reset</h1>
            <p>Hello!</p>
            <p>Please click the button below to reset your account's password...</p>
            <p>Ignore this email if this is not you.</p>
            <a href="{{route("reset.password", ['role' => $role, 'token' => $token])}}">
                <button class="message-box__button">Reset Password</button>
            </a>
            <p>Thank you.</p>
        </div>
        <div class="closing">
            <p>Regards,</p>
            <p>IT Division <i>CAPITAL 2025</i></p>
        </div>
    </div>
@endsection

