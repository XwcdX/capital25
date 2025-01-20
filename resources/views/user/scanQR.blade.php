@extends('user.layout')

@section('style')
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: #000;
            color: #fff;
        }

        #reader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 1;
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            position: absolute;
            top: 5%;
            width: 100%;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #ff00ff, 0 0 40px #ff00ff, 0 0 50px #ff00ff, 0 0 60px #ff00ff, 0 0 70px #ff00ff;
            color: #fff;
            z-index: 2;
        }

        #scanned-result {
            position: absolute;
            bottom: 10%;
            width: 100%;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            z-index: 2;
        }

        #qr-box {
            position: absolute;
            width: 250px;
            height: 250px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

        form {
            display: none;
        }

        video {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }
    </style>
@endsection

@section('content')
    <div id="reader"></div>
    <div id="qr-box"></div>
    <h1>Scan Rally QR Code</h1>
    <p id="scanned-result"></p>

    <form id="scan-form" action="{{ route('scanQR') }}" method="POST">
        @csrf
        <input type="hidden" name="team_id" id="team_id" value="YOUR_TEAM_ID">
        <input type="hidden" name="qr_data" id="qr_data">
    </form>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const html5QrCode = new Html5Qrcode("reader");

            function onScanSuccess(decodedText) {
                document.getElementById('scanned-result').innerText = `Scanned: ${decodedText}`;
                document.getElementById('qr_data').value = decodedText;
                document.getElementById('scan-form').submit();
            }

            function onScanError(errorMessage) {
                console.error(errorMessage);
            }

            const qrBoxSize = 250;

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: {
                        width: qrBoxSize,
                        height: qrBoxSize
                    },
                },
                onScanSuccess,
                onScanError
            ).catch((err) => {
                console.error("Back camera initialization failed:", err);
                html5QrCode
                    .start({
                            facingMode: "user"
                        }, {
                            fps: 10,
                            qrbox: {
                                width: qrBoxSize,
                                height: qrBoxSize
                            },
                        },
                        onScanSuccess,
                        onScanError
                    )
                    .catch((err) => {
                        console.error("Error accessing any camera:", err);
                    });
            });
        });
    </script>
@endsection
