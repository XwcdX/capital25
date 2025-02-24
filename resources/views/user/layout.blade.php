<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('assets/favicon-512.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/favicon-192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/apple-touch-icon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User | {{ $title }}</title>
    {{-- tailwindcss --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/css/tw-elements.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    {{-- aos --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    {{-- swiper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Unbounded:wght@200..900&display=swap');
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- font landing --}}
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --cap-green6: #14240a;
            --cap-green5: #25483d;
            --cap-green4: #56843a;
            --cap-green3: #82b741;
            --cap-green2: #a8c747;
            --cap-green1: #e6e773;
            /*yellow*/
        }

        html {
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--cap-green5) 0%, var(--cap-green3) 49%, var(--cap-green1) 100%);
            border-radius: 8px;
        }

        ::-webkit-scrollbar-track {
            width: 0;
            background: #454556;
        }

        label {
            color: #454556 !important;
        }

        input,
        textarea,
        select {
            color: #454556 !important;
        }

        input:focused {
            outline: #454556 !important;
        }

        input:disabled,
        textarea:disabled {
            background: #aaaaaa50 !important;
        }

        @font-face {
            font-family: 'orbitron';
            src: url('/assets/fonts/heading-orbitron.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'quicksand';
            src: url('/assets/fonts/quicksand.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'oxanium';
            src: url('/assets/fonts/oxanium.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .font-orbitron {
            font-family: 'orbitron';
        }

        .font-quicksand {
            font-family: 'quicksand';
        }

        .font-oxanium {
            font-family: 'oxanium';
        }

        .font-league {
            font-family: 'League Spartan'
        }

        body {
            max-height: 100vh;
            overflow: hidden;
            overflow-x: hidden;
        }
    </style>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                fontFamily: {
                    sans: ["Open Sans", "sans-serif"],
                    body: ["Open Sans", "sans-serif"],
                    mono: ["ui-monospace", "monospace"],
                    unbounded: ["Unbounded", "sans-serif"],
                    dm: ["DM Sans", "sans-serif"],
                },
                extend: {
                    boxShadow: {
                        'custom-md': '0 1px 6px rgba(0, 0, 0, 0.1)',
                    },
                    keyframes: {
                        shake: {
                            '0%, 100%': {
                                transform: 'translateX(0)'
                            },
                            '25%': {
                                transform: 'translateX(-5px) rotate(-5deg)'
                            },
                            '50%': {
                                transform: 'translateX(5px) rotate(5deg)'
                            },
                            '75%': {
                                transform: 'translateX(-5px) rotate(-5deg)'
                            },
                        }
                    },
                    animation: {
                        shake: 'shake 0.5s ease-in-out infinite',
                    },
                    screens: {
                        'nav-custom': '1100px',
                        'custom-2xl': '1700px',
                    }
                },
            },
            corePlugins: {
                preflight: false,
            },
        };
    </script>
    @yield('style')
</head>

<body class="overflow-hidden">
    <div id="loader"
        class="loader fixed z-[10000] inset-0 h-screen w-screen flex justify-center items-center bg-[var(--cap-green5)]">
        @include('user.loader')
    </div>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/js/tw-elements.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.1.6/html5-qrcode.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @yield('script')
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonColor: "#56843a",
            })
        </script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loader = document.getElementById("loader");
            const body = document.body;
            const html = document.documentElement;

            body.style.overflow = "hidden";
            html.style.overflow = "hidden";
            window.scrollTo(0, 0);

            const isHomePage = window.location.pathname === "/";
            let timeoutReached = false;

            function removeLoader() {
                if (loader) {
                    loader.style.transition = "opacity 0.8s ease";
                    loader.style.opacity = "0";

                    setTimeout(() => {
                        loader.remove();
                        body.style.overflowY = "visible";
                        html.style.overflowY = "visible";
                        body.classList.remove('overflow-hidden');
                        body.classList.add('overflow-x-hidden');

                        setTimeout(() => {
                            if (typeof Lenis !== "undefined") {
                                lenis.start();
                            }
                        }, 3000);

                        if (typeof ScrollTrigger !== "undefined") {
                            ScrollTrigger.refresh();
                        }

                        // Ensure this runs last after everything is completed
                        document.body.style.maxHeight = "none";
                    }, 800);
                }
            }
            if (isHomePage) {
                const timeout = setTimeout(() => {
                    timeoutReached = true;
                    removeLoader();
                }, 3000);
                window.addEventListener("load", function() {
                    if (timeoutReached) {
                        removeLoader();
                    } else {
                        clearTimeout(timeout);
                        setTimeout(removeLoader, 3000);
                    }
                });

            } else {
                window.addEventListener("load", removeLoader);
            }
        });
    </script>

</body>

</html>
