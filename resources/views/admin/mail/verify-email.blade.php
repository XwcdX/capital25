@extends('admin.mail.layout')

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
            <h1>Email Verification</h1>
            <p>Hello {{ $user->name}},</p>
            <p>Please click the button below to verify your email address..</p>
            <a href="{{$url}}">
                <button class="message-box__button">Verify Email</button>
            </a>
            <p>Thank you.</p>
        </div>
        <div class="closing">
            <p>Regards,</p>
            <p>IT Division <i>CAPITAL 2025</i></p>
        </div>
    </div>
@endsection

