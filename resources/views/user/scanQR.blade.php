<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ Auth::user()->id }}">
    <meta name="scan-url" content="{{ route('scanQR') }}">
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
    <p id="scanned-result" class="d-done"></p>
    <script>
        function startScanning(selectedCameraId) {
            let phaseId = {!! json_encode(optional($currentPhase)->id) !!};
            let scanUrl = document.querySelector('meta[name="scan-url"]').getAttribute('content');
            const html5QrCode = new Html5Qrcode("reader");
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const teamId = document.querySelector('meta[name="user-id"]').getAttribute('content');

            const onScanSuccess = (decodedText, decodedResult) => {
                const result = document.getElementById("scanned-result");
                result.innerHTML = `Scanned: <strong>${decodedText}</strong>`;
                result.classList.remove("d-none");
                if (html5QrCode.isScanning) {
                    html5QrCode.stop().then(() => {
                        fetch(scanUrl, {
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
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    swal.fire("Success", "Scanned Successfully! ", "success");
                                    window.dispatchEvent(new CustomEvent("rallyScanned", {
                                        detail: {
                                            rallyId: data.data.rally_id
                                        }
                                    }));
                                } else {
                                    swal.fire("Error", data.message || "An unexpected error occurred.",
                                        "error");
                                }
                            }).catch(err => {
                                console.error("Fetch error:", err);
                                swal.fire("Error", "An unexpected error occurred.", "error");
                            });
                    }).catch(err => console.error("Stop failed", err));
                }
            };


            const onScanFailure = (error) => {
                console.log("Scan failed:", error);
            };
            const boxSize = window.innerWidth < 500 ? 300 : 500;

            const config = {
                fps: 30,
                qrbox: {
                    width: boxSize,
                    height: boxSize
                }
            };
            html5QrCode.start(selectedCameraId, config, onScanSuccess, onScanFailure);
        }

        Html5Qrcode.getCameras().then(devices => {
            if (devices.length > 0) {
                let backCamera = devices.find(device => device.label.toLowerCase().includes("back"));
                let selectedCameraId = backCamera ? backCamera.id : devices[0].id;
                startScanning(selectedCameraId);
            } else {
                console.error("No cameras found.");
                swal.fire("Error", "No available cameras detected.", "error");
            }
        }).catch(err => {
            console.error("Camera access error:", err);
            swal.fire("Error", "Failed to access camera.", "error");
        });
        document.addEventListener("DOMContentLoaded", function() {
            Echo.channel("phase-updates")
                .listen(".PhaseUpdated", (event) => {
                    phaseId = event.phase_id;
                });
        })
    </script>
</body>

</html>
