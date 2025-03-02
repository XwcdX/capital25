<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.1.6/html5-qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ Auth::user()->id }}">
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
</head>

<body>

    <h1>Scan Rally QR Code</h1>
    <div id="reader"></div>
    <p id="scanned-result"></p>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const html5QrCode = new Html5Qrcode("reader");
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const teamId = document.querySelector('meta[name="user-id"]').getAttribute('content');

            function onScanSuccess(decodedText) {
                console.log("Decoded:", decodedText);
                document.getElementById('scanned-result').innerText = `Scanned: ${decodedText}`;

                html5QrCode.stop().then(() => {
                    fetch('{{ route('scanQR') }}', {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                team_id: teamId,
                                qr_data: decodedText
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                swal("Success", "Scan successful: " + decodedText, "success");
                            } else {
                                swal("Error", data.message, "error");
                            }
                        }).catch(err => {
                            console.error("Fetch error:", err);
                            swal("Error", "An unexpected error occurred.", "error");
                        });
                }).catch(err => console.error("Stop failed", err));
            }

            function onScanFailure(error) {
                console.warn("Scan error:", error);
            }

            const cameraMode = {
                facingMode: "user"
            };

            html5QrCode.start(
                cameraMode, {
                    fps: 45,
                    qrbox: {
                        width: 550,
                        height: 550
                    }
                },
                onScanSuccess,
                onScanFailure
            ).then(() => {
                if (cameraMode.facingMode === "user") {
                    document.querySelector("video").style.transform = "scaleX(-1)";
                }
            }).catch(err => {
                console.error("Camera initialization failed:", err);
            });
        });
    </script>

</body>

</html>
