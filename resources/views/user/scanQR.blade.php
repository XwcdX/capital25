<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.1.6/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ Auth::user()->id }}">
    @vite(['resources/js/app.js'])
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
            /* width: 250px; */
            /* height: 250px; */
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

        /* #qr-canvas {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80vw !important;
            max-width: 500px !important;
            aspect-ratio: 1;
            display: none;
        } */
    </style>
</head>

<body>

    <h1>Scan Rally QR Code</h1>
    <div id="reader"></div>
    <p id="scanned-result"></p>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let phaseId = localStorage.getItem("current_phase_id");

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
                                qr_data: decodedText,
                                phase_id: phaseId,
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                swal("Success", "Scanned Successfully! ", "success");
                                window.dispatchEvent(new CustomEvent("rallyScanned", {
                                    detail: {
                                        rallyId: data.data.rally_id
                                    }
                                }));
                            } else {
                                swal("Error", data.message || "An unexpected error occurred.", "error");
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

            function startScanner(cameraId) {
                const boxSize = window.innerWidth < 500 ? 300 : 500;
                html5QrCode.start(cameraId, {
                        fps: 45,
                        qrbox: {
                            width: boxSize,
                            height: boxSize
                        }
                    },
                    onScanSuccess,
                    onScanFailure
                ).then(() => {
                    const videoElement = document.querySelector("video");
                    if (videoElement) {
                        videoElement.style.transform = cameraId === "user" ? "scaleX(-1)" : "scaleX(1)";
                    }
                }).catch(err => console.error("Camera initialization failed:", err));
            }

            Html5Qrcode.getCameras().then(devices => {
                if (devices.length > 0) {
                    const backCamera = devices.find(device => device.label.toLowerCase().includes(
                        "back")) || devices[0];
                    startScanner(backCamera.id);
                } else {
                    console.error("No cameras found.");
                    swal("Error", "No available cameras detected.", "error");
                }
            }).catch(err => {
                console.error("Camera access error:", err);
                swal("Error", "Failed to access camera.", "error");
            });

            Echo.channel("phase-updates")
                .listen(".PhaseUpdated", (event) => {
                    localStorage.setItem("current_phase_id", event.phase_id);
                    phaseId = event.phase_id;
                });
        });
    </script>
</body>

</html>
