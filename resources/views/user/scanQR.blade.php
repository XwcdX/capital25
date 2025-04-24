<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #82b741, 0 0 40px #82b741, 0 0 50px #82b741, 0 0 60px #82b741, 0 0 70px #82b741;
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
            /*object-fit: cover;*/
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
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const html5QrCode = new Html5Qrcode("reader");
            const boxSize = window.innerWidth < 500 ? 300 : 500;

            function startScanning(deviceId) {
                const config = {
                    fps: 15,
                    qrbox: {
                        width: boxSize,
                        height: boxSize
                    },
                    aspectRatio: 1.7777778,
                    experimentalFeatures: {
                        useBarCodeDetectorIfSupported: true
                    },
                    videoConstraints: {
                        facingMode: { exact: "environment" },
                        width: {
                            ideal: 1280
                        },
                        height: {
                            ideal: 720
                        }
                    }
                };

                html5QrCode.start({
                        deviceId: {
                            exact: "environtment"
                        }
                    },
                    config,
                    decodedText => {
                        html5QrCode.stop()
                            .then(() => window.location.href = decodedText)
                            .catch(err => console.error("Failed to stop scanner:", err));
                    },
                    err => console.warn("QR scan error:", err)
                );
            }

            Html5Qrcode.getCameras()
                .then(devices => {
                    console.log("Available cameras:", devices);
                    if (!devices.length) {
                        return swal.fire("Error", "No cameras found.", "error");
                    }

                    const back = devices.find(d =>
                        d.label.toLowerCase().includes("back") ||
                        d.label.toLowerCase().includes("environment")
                    );
                    const front = devices.find(d =>
                        d.label.toLowerCase().includes("front") ||
                        d.label.toLowerCase().includes("user") ||
                        d.label.toLowerCase().includes("integrated")
                    );

                    const chosen = back?.id || front?.id || devices[0].id;
                    startScanning(chosen);
                })
                .catch(err => {
                    console.error("Camera access error:", err);
                    swal.fire("Error", "Failed to access camera.", "error");
                });
        });
    </script>
</body>

</html>
