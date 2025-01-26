<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User | {{ $title }}</title>
    {{-- tailwindcss --}}
    <script src="https://cdn.tailwindcss.com/3.4.5"></script>
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --cap-green5: #344E41;
            --cap-green4: #3A5A40;
            --cap-green3: #5C7650;
            --cap-green2: #A3B18A;
            --cap-green1: #DAD7CD;
        }

        html {
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgb(23, 24, 56);
            background: linear-gradient(180deg, rgba(69, 69, 86, 1) 0%, rgba(140, 84, 162, 1) 49%, rgba(249, 182, 63, 1) 100%);
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
                    colors: {
                        'nex': {
                            'yellow': '#F9B63F',
                            'purple': '#8C54A2',
                            'blue': '#8FBDD2 ',
                            'black': '#454556',
                        }
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

<body class="overflow-x-hidden">
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/js/tw-elements.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.1.6/html5-qrcode.min.js"></script>
    @yield('script')
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            })
        </script>
    @endif
</body>

</html>
