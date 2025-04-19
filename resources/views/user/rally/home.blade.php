<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    @vite(['resources/js/app.js'])
    <style>
        :root {
            --cap-green6: #14240a;
            --cap-green5: #25483d;
            --cap-green4: #56843a;
            --cap-green3: #82b741;
            --cap-green2: #a8c747;
            --cap-green1: #e6e773;
            /*yellow*/
        }

        .swal2-popup.swal-high-z-index {
            z-index: 100000 !important;
        }

        .wrapper {
            height: 15rem !important;
            padding-right: 20px !important;
        }

        .custom-scrollbar {
            width: 100% !important;
            height: 100% !important;
            overflow-y: auto !important;
            /* padding-right: 10px !important; */
            margin-left: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 1.5rem !important;
            position: absolute;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #dedede !important;
            border-radius: 50px !important;
            max-height: 20px !important;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background-color: #a8a8a8 !important;
            border-radius: 50px !important;
            margin: 30px !important;
        }

        .modal-content {
            padding-left: 8rem !important;
            padding-right: 8rem !important;
        }

        @media (max-width: 640px) {
            .modal-content {
                padding-left: 2rem !important;
                padding-right: 2rem !important;
            }
        }

        .space-value {
            margin-left: 8rem !important;
        }

        @media (max-width: 640px) {
            .space-value {
                margin-left: 2rem !important;
            }
        }

        .content-scroll {
            height: 100% !important;
            overflow-y: auto;
            padding-right: 15px !important;
            padding-bottom: 2rem !important;
        }

        .custom-scroll {
            width: 100% !important;
            height: 100% !important;
            overflow-y: auto !important;
            padding-right: 16px !important;
            margin-right: 20px !important;

        }

        .custom-scroll::-webkit-scrollbar {
            width: 0.8rem !important;
            position: absolute;
        }


        .custom-scroll::-webkit-scrollbar-thumb {
            background: #dedede !important;
            border-radius: 50px !important;
            max-height: 20px !important;
            min-height: 0px !important;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background-color: #a8a8a8 !important;
            border-radius: 50px !important;
            margin: 30px !important;
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
    </style>
</head>

<body class="fixed h-screen w-screen">
    <img src="{{ asset('assets/lifecycleHPDummy/dummyBG.jpeg') }}" class="absolute inset-0 w-full h-full object-cover">

    <!-- Greenpoint & Coins Buttons -->
    <div class="absolute top-0 right-0 my-3 mr-3 flex space-x-3 flex-wrap z-[2] font-oxanium">
        <button onclick="openModal('greenpointModal');"
            class="hover:bg-slate-400 hover:cursor-pointer bg-white text-[#3e5c49] rounded-full w-[10rem] min-w-[6rem] h-12 flex items-center justify-center px-3">
            <span class="text-xl mr-2">🍃</span>
            <span class="text-2xl">{{ $team->green_points }}</span>
        </button>
        <button onclick="openModal('coinModal');"
            class="hover:bg-slate-400 hover:cursor-pointer bg-white text-[#3e5c49] rounded-full w-[10rem] min-w-[6rem] h-12 flex items-center justify-center px-3">
            <span class="text-xl mr-2">💰</span>
            <span class="text-2xl">{{ $team->coin }}</span>
        </button>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center h-full text-white font-oxanium">
        <h1 class="z-[1]  text-8xl font-semibold  drop-shadow-[0_0_8px_rgba(0,0,0,0.9)]">Lifecycle Simulation</h1>
        <h2 class="z-[1] text-8xl font-bold  drop-shadow-[0_0_8px_rgba(0,0,0,0.9)]">CAPITAL 2025</h2>
        <div class="mt-[100px] text-3xl font-bold">
            ROUND {{ $currentPhase->phase ?? 'N/A' }}
        </div>
        <div id="timer"
            class="absolute bottom-20 left-1/2 transform -translate-x-1/2 text-[#415943] bg-white text-black px-20 py-5 rounded-full text-3xl font-bold shadow-lg">
        </div>
    </div>

    <!-- Greenpoint Modal -->
    <div id="greenpointModal" class="hidden z-[3] fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
        onclick="closeModalOnOverlay(event, 'greenpointModal')">
        <div class="modal-content bg-white rounded-[2.5vw] w-[90%] sm:w-[55rem] h-auto max-h-[90vh] flex flex-col items-center px-[8rem] pt-[2.3rem] pb-[2rem]"
            onclick="event.stopPropagation();">
            <div class="flex flex-row mb-3.5">
                <span class="text-xl mr-2">🍃</span>
                <span class="text-3xl text-[#3e5c49] font-oxanium">{{ $team->green_points }}</span>
            </div>

            <div
                class="h-[50vh] sm:h-[18rem] w-full sm:w-[40rem] overflow-y-auto rounded-l-[2vw] rounded-r-[1.5vw] bg-[#3e5c49] custom-scrollbar font-quicksand">
                <h1 class="text-white font-bold text-center mt-3 pl-5 text-lg sm:text-2xl font-oxanium">Riwayat
                    Transaksi</h1>
                <div class="wrapper w-full">
                    <div class="custom-scrollbar mt-4 pb-10 overflow-x-hidden pr-3 w-full">
                        @foreach ($transactionsGreenPoint as $transaction)
                            @php
                                $date = \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y');
                                $time = \Carbon\Carbon::parse($transaction->created_at)->format('H:i:s');
                                $amountDisplay =
                                    $transaction->action === 'debit'
                                        ? '-' . $transaction->amount
                                        : '+' . $transaction->amount;
                            @endphp
                            <div
                                class="flex justify-between items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5 w-full">
                                <div class="flex flex-row w-[95%] text-lg">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <span>{{ $date }}</span>
                                        <span>{{ $time }}</span>
                                    </div>
                                    <div
                                        class="flex-1 flex items-center justify-center text-center text-xl {{ $transaction->action === 'debit' ? 'text-[#e80909]' : 'text-green-500' }}">
                                        <span>{{ $amountDisplay }}</span>
                                    </div>
                                    <div class="flex-1 text-center ">
                                        <span>{{ $transaction->description }}</span>
                                    </div>
                                </div>
                            </div>
                            <hr class="border-t border-gray-400 my-2 w-full">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Coin Modal -->
    <div id="coinModal" class="hidden z-[3] fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
        onclick="closeModalOnOverlay(event, 'coinModal')">
        <div class="modal-content bg-white rounded-[2.5vw] w-[90%] sm:w-[55rem] h-auto max-h-[90vh] flex flex-col items-center pt-[2.3rem] pb-[2rem]"
            onclick="event.stopPropagation();">
            <div class="flex flex-row mb-3.5">
                <span class="text-xl mr-2">💰</span>
                <span class="text-3xl text-[#3e5c49] font-oxanium">{{ $team->coin }}</span>
            </div>

            <div
                class="h-[50vh] sm:h-[18rem] w-full sm:w-[40rem] overflow-y-auto rounded-l-[2vw] rounded-r-[1.5vw] bg-[#3e5c49] custom-scrollbar font-quicksand">
                <h1 class="text-white font-bold text-center mt-3 pl-5 text-lg sm:text-2xl font-oxanium">Riwayat
                    Transaksi</h1>
                <div class="wrapper w-full ">
                    <div class="custom-scrollbar mt-4 pb-10 overflow-x-hidden pr-3 pl-3 w-full">
                        @foreach ($transactionsCoin as $transaction)
                            @php
                                $date = \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y');
                                $time = \Carbon\Carbon::parse($transaction->created_at)->format('H:i:s');
                                $amountDisplay =
                                    $transaction->action === 'debit'
                                        ? '-' . $transaction->amount
                                        : '+' . $transaction->amount;
                            @endphp
                            <div
                                class="flex justify-between items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5 w-full">
                                <div class="flex flex-row w-[95%] text-lg">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <span>{{ $date }}</span>
                                        <span>{{ $time }}</span>
                                    </div>
                                    <div
                                        class="flex-1 flex items-center justify-center font-oxanium text-center text-xl {{ $transaction->action === 'debit' ? 'text-[#e80909]' : 'text-green-500' }}">
                                        <span>{{ $amountDisplay }}</span>
                                    </div>
                                    <div class="flex-1 text-center">
                                        <span>{{ $transaction->description }}</span>
                                    </div>
                                </div>
                            </div>
                            <hr class="border-t border-gray-400 my-2 w-full">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.rallynav')
    @include('user.rally.storyline')
    @include('user.rally.tradezone')
    @include('user.rally.inventory')
    @include('user.rally.map')
    @include('user.rally.cluezone')

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: @json(session('error')),
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: @json(session('success')),
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (!localStorage.getItem("currentPhaseId")) {
                localStorage.setItem("currentPhaseId", "{{ $currentPhase->id }}");
            }
            if (!localStorage.getItem("hasReducedReturnRates")) {
                localStorage.setItem("hasReducedReturnRates", "false");
            }

            Echo.channel("phase-updates")
                .listen(".PhaseUpdated", (event) => {
                    Swal.fire({
                        title: 'New Phase Started!',
                        text: `Phase ${event.phase} is now started!`,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                    localStorage.setItem("currentPhaseId", event.phase_id);
                    localStorage.setItem("hasReducedReturnRates", "false");
                });
        });

        function openModal(id) {
            document.getElementById(id).classList.remove("hidden");
        }

        function closeModalOnOverlay(event, id) {
            document.getElementById(id).classList.add("hidden");
        }

        let countdownString = "{{ $currentPhase->end_time }}";
        let todayDate = new Date().toISOString().split('T')[0];
        let countdownTime = new Date(todayDate + "T" + countdownString + "+07:00").getTime();

        function updateCountdown() {
            let now = new Date().getTime();
            let timeLeft = countdownTime - now;

            if (timeLeft <= 0) {
                document.getElementById("timer").textContent = "Time's up!";
                return;
            }

            if (timeLeft <= 60 * 60 * 1000) {
                document
                    .querySelectorAll("a[onclick*='openTradezoneModal'], a[onclick*='openCluezoneModal']")
                    .forEach(el => {
                        el.classList.add("opacity-50", "pointer-events-none");
                    });

                ['cluezone-modal', 'tradezone-modal'].forEach(id => {
                    const m = document.getElementById(id);
                    if (m && !m.classList.contains('hidden')) {
                        m.classList.add('hidden');
                    }
                });
            }

            if (timeLeft <= 60 * 60 * 1000 && localStorage.getItem("hasReducedReturnRates") === "false") {
                localStorage.setItem("hasReducedReturnRates", "true");
                let urlTemplate = "{{ route('commodities.reduceReturnRates', ['phase' => ':phase']) }}";
                let url = urlTemplate.replace(':phase', localStorage.getItem('currentPhaseId'));

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({})
                    })
                    .then(res => res.json())
                    .then(json => {
                        if (!json.success) {
                            console.error("Failed to reduce rates:", json.message);
                        }
                    })
                    .catch(err => console.error("AJAX error:", err));
            }

            let hours = Math.floor((timeLeft / (1000 * 60 * 60)) % 24);
            let minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
            let seconds = Math.floor((timeLeft / 1000) % 60);
            document.getElementById("timer").textContent = `${hours}h ${minutes}m ${seconds}s`;
            setTimeout(updateCountdown, 1000);
        }
        updateCountdown();
    </script>

</body>

</html>
