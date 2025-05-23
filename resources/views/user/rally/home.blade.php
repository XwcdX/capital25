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

        /* custom css class buat swal */

        /* buat atur ukuran popup nya cst*/
        .custom-swal-popup {
            background-color: #ece7e3;
            border-radius: 20px !important;
            width: 28rem;
            height: 15rem;
            /* padding: 10px; */
            font-size: 13px;
            color: #25483d;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* buat button */
        .custom-swal-cancelBtn {
            font-size: 15px;
            font-weight: bold;
            background-color: #ece7e3;
            color: #25483d;
            border: 2px solid #25483d !important;
            border-radius: 20px;
            padding-right: 3rem;
            padding-left: 3rem;
            text-align: center;
            justify-content: center;
            align-items: center;
            display: flex;
        }

        .custom-swal-confirmBtn {
            font-size: 15px;
            font-weight: bold;
            background-color: #25483d;
            color: #ece7e3;
            border-radius: 20px;
            border: 2px solid #25483d !important;
            padding-right: 3rem;
            padding-left: 3rem;
            text-align: center;
            justify-content: center;
            align-items: center;
            display: flex;
        }

        /* .custom-swal-confirmBtn:hover{
            background-color: #ece7e3;
            border: 2px solid #25483d !important;
            color: #25483d;
        } */

        /* .custom-swal-cancelBtn:hover{
            background-color: #25483d;
            color: #ece7e3;
        } */

        /*lbh panjang*/
        .custom-swal-popup1 {
            background-color: #ece7e3;
            border-radius: 20px !important;
            width: 28rem;
            height: 18rem;
            font-size: 13px;
            color: #25483d;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }


        .custom-swal-message {
            font-weight: bold;
            text-align: center;
            margin-top: -0.8rem;
        }

        .custom-swal-title {
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            margin-top: -1.2rem;
        }

        .wrapper {
            height: 15rem !important;
            padding-right: 20px !important;
        }

        .custom-scrollbar {
            max-height: 80vh !important;
            width: 100% !important;
            height: 100% !important;
            overflow-y: scroll !important;
            padding-right: 30px !important;
            max-height: 18rem !important;
            scroll-behavior: smooth !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 15px !important;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #ece7e3 !important;
            border-radius: 10px !important;
            height: 70px !important;
            max-height: 10px !important;

        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: linear-gradient(to bottom, #415943 0%, #415943 var(--scroll-progress), #D4D4D6 var(--scroll-progress), #D4D4D6 100%) !important;
            border-radius: 15px !important;
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


        /* benerin main bg pas akses swal biar gak kek ke facelift*/
        body.swal2-shown {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        body {
            margin-right: 0;
            overflow: auto;
        }

        html,
        body {
            /* height: calc(100vh - 70px); */
            position: relative;
        }
    </style>
</head>

<body class="flex flex-col w-screen h-svh">
    <img src="{{ asset('assets/lifecycleHPDummy/dummyBG.jpeg') }}"
        class="absolute z-[-1] inset-0 w-full h-full object-cover">

    <!-- Greenpoint, Coin, map Buttons -->
    <div class="absolute top-0 right-0 my-3 mr-3 flex flex-col items-end space-y-2 flex-wrap z-[2] font-oxanium">
        <div class="flex space-x-2">
            <button onclick="openModal('greenpointModal');"
                class="hover:bg-slate-400 hover:cursor-pointer bg-white text-[#3e5c49] rounded-full w-[7rem] md:w-[10rem] space-x-1 flex items-center justify-center py-1.5">
                <img class="w-6 h-6 lg:w-7 lg:h-7 mr-1  object-contain" src="{{ asset('assets/lifecycleHPDummy/green-point.png') }}" />
                <span class="text-base md:text-2xl">{{ $team->green_points }}</span>
            </button>
            <button onclick="openModal('coinModal');"
                class="hover:bg-slate-400 hover:cursor-pointer bg-white text-[#3e5c49] rounded-full w-[7rem] md:w-[10rem] space-x-1 flex items-center justify-center py-1.5">
                <img class="w-6 h-6 lg:w-7 lg:h-7 mr-1 mb-[1.5%] object-contain" src="{{ asset('assets/lifecycleHPDummy/coin.png') }}" />
                <span class="text-base md:text-2xl">{{ $team->coin }}</span>
            </button>
        </div>
        <button
            class="w-10 h-10 rounded-full flex items-center justify-center bg-[var(--cap-green3)] bg-opacity-0 rounded-full border border-black"
            onclick="openMapModal(); document.getElementById('nav-toggle').checked = false;">
            <img class="w-[75%] " src="{{ asset('assets/treasure-map.png') }}" alt="">
        </button>
        <button
            class="w-10 h-10 rounded-full flex items-center justify-center bg-[var(--cap-green2)] bg-opacity-0 rounded-full border border-black"
            onclick="openCluezoneModal(); document.getElementById('nav-toggle').checked = false;">
            <img class="w-[75%] " src="{{ asset('assets/Icon pos map/clue zone.png') }}" alt="">
        </button>

    </div>

    <!-- Main Content -->
    <main class="flex flex-col items-center justify-center h-full text-white font-oxanium">
        <h1 class="z-[1] text-3xl md:text-5xl lg:text-7xl font-semibold  drop-shadow-[0_0_8px_rgba(0,0,0,1)]">Lifecycle
            Simulation</h1>
        <h2 class="z-[1] text-4xl md:text-6xl lg:text-8xl font-bold  drop-shadow-[0_0_8px_rgba(0,0,0,1)]">CAPITAL 2025
        </h2>
        <div class="mt-[100px] text-3xl font-bold drop-shadow-[0_0_8px_rgba(0,0,0,1)] mb-2  ">
            ROUND {{ $currentPhase->phase ?? 'N/A' }}
        </div>
        <div id="timer"
            class=" text-[#415943] bg-white text-black px-12 py-5 rounded-full text-2xl font-bold shadow-xl">
        </div>
    </main>

    <!-- Greenpoint Modal -->
    <div id="greenpointModal" class="hidden z-[3] fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
        onclick="closeModalOnOverlay(event, 'greenpointModal')">
        <div class="modal-content bg-white rounded-[2.5vw] w-[90%] sm:w-[55rem] h-[40%] sm:h-[27rem] max-h-[90vh] flex flex-col items-center pt-[2.3rem] px-[5rem] pb-[3.5rem]"
            onclick="event.stopPropagation();">
            <div class="flex flex-row items-center mb-3.5">
                <img class="w-10 h-10 mr-2  object-contain" src="{{ asset('assets/lifecycleHPDummy/green-point.png') }}" />
                <span class="text-3xl text-[#3e5c49] font-oxanium">{{ $team->green_points }}</span>
            </div>

            {{-- <button id="mascotTest" onclick = "showMascotError('TransactionPeriod_over')">Test</button> --}} {{-- buat tes swal --}}

            <div
                class="h-[90%] sm:h[20rem] w-full sm:w-[48rem] rounded-l-[2vw] rounded-r-[1.5vw] bg-[#3e5c49] font-quicksand pr-[10px] mx-[10rem] flex flex-col mb-5">
                <div class="custom-scrollbar overflow-y-scroll pr-3 mt-5 sm:mt-1 flex-1">
                    <div class="sm:mt-0">
                        <h1
                            class="text-white font-bold justify-center text-center mt-0 sm:mt-[1rem] pl-9 ml-9 mr-auto pr-auto text-lg sm:text-2xl font-oxanium ">
                            Riwayat
                            Transaksi</h1>
                        <div class="mt-4 pb-10 overflow-x-hidden w-full lg:ml-[3%] ml-[10%]">

                            {{-- TEST SCROLL  --}}
                            {{-- <div class="flex justify-between items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5 w-full">
                                                    <div class="flex flex-row w-[95%] text-lg">
                                                        <div class="flex flex-col items-center justify-center text-center">
                                                            <span>16/04/2025</span>
                                                            <span>08:45:00</span>
                                                        </div>
                                                        <div class="flex-1 flex items-center justify-center font-oxanium text-center text-xl text-green-500">
                                                            <span>+200</span>
                                                        </div>
                                                        <div class="flex-1 text-center">
                                                            <span>Quest reward</span>
                                                        </div>
                                                    </div>
                                                </div>
                        
                                                <div class="flex justify-between items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5 w-full">
                                                    <div class="flex flex-row w-[95%] text-lg">
                                                        <div class="flex flex-col items-center justify-center text-center">
                                                            <span>16/04/2025</span>
                                                            <span>08:45:00</span>
                                                        </div>
                                                        <div class="flex-1 flex items-center justify-center font-oxanium text-center text-xl text-green-500">
                                                            <span>+200</span>
                                                        </div>
                                                        <div class="flex-1 text-center">
                                                            <span>Quest reward</span>
                                                        </div>
                                                    </div>
                                                </div>
                        
                                                <div class="flex justify-between items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5 w-full">
                                                    <div class="flex flex-row w-[95%] text-lg">
                                                        <div class="flex flex-col items-center justify-center text-center">
                                                            <span>16/04/2025</span>
                                                            <span>08:45:00</span>
                                                        </div>
                                                        <div class="flex-1 flex items-center justify-center font-oxanium text-center text-xl text-green-500">
                                                            <span>+200</span>
                                                        </div>
                                                        <div class="flex-1 text-center">
                                                            <span>Quest reward</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex justify-between items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5 w-full">
                                                    <div class="flex flex-row w-[95%] text-lg">
                                                        <div class="flex flex-col items-center justify-center text-center">
                                                            <span>16/04/2025</span>
                                                            <span>08:45:00</span>
                                                        </div>
                                                        <div class="flex-1 flex items-center justify-center font-oxanium text-center text-xl text-green-500">
                                                            <span>+200</span>
                                                        </div>
                                                        <div class="flex-1 text-center">
                                                            <span>Quest reward</span>
                                                        </div>
                                                    </div>
                                                </div>
                        
                                                <div class="flex justify-between items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5 w-full">
                                                    <div class="flex flex-row w-[95%] text-lg">
                                                        <div class="flex flex-col items-center justify-center text-center">
                                                            <span>16/04/2025</span>
                                                            <span>08:45:00</span>
                                                        </div>
                                                        <div class="flex-1 flex items-center justify-center font-oxanium text-center text-xl text-green-500">
                                                            <span>+200</span>
                                                        </div>
                                                        <div class="flex-1 text-center">
                                                            <span>Quest reward</span>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="flex justify-between items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5 w-full">
                                                    <div class="flex flex-row w-[95%] text-lg">
                                                        <div class="flex flex-col items-center justify-center text-center">
                                                            <span>16/04/2025</span>
                                                            <span>08:45:00</span>
                                                        </div>
                                                        <div class="flex-1 flex items-center justify-center font-oxanium text-center text-xl text-green-500">
                                                            <span>+200</span>
                                                        </div>
                                                        <div class="flex-1 text-center">
                                                            <span>Quest reward</span>
                                                        </div>
                                                    </div>
                                                </div>
                        
                                                <div class="flex justify-between items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5 w-full">
                                                    <div class="flex flex-row w-[95%] text-lg">
                                                        <div class="flex flex-col items-center justify-center text-center">
                                                            <span>16/04/2025</span>
                                                            <span>08:45:00</span>
                                                        </div>
                                                        <div class="flex-1 flex items-center justify-center font-oxanium text-center text-xl text-green-500">
                                                            <span>+200</span>
                                                        </div>
                                                        <div class="flex-1 text-center">
                                                            <span>Quest reward</span>
                                                        </div>
                                                    </div>
                                                </div>  --}}
                            {{-- Dummy End  --}}


                            @foreach ($transactionsGreenPoint as $transaction)
                                @php
                                    $date = \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y');
                                    $time = \Carbon\Carbon::parse($transaction->created_at)->format('H:i:s');
                                    $amountDisplay =
                                        $transaction->action === 'debit'
                                            ? '-' . $transaction->amount
                                            : '+' . $transaction->amount;
                                @endphp

                                <div class="bg-[#4d6e5a] rounded-xl p-3 text-white text-sm sm:text-base">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                        <div class="text-center sm:text-left lg:max-w-[25%] lg:max-h-[35%]  ">
                                            <div>{{ $date }}</div>
                                            <div class="text-xs">{{ $time }}</div>
                                        </div>
                                        <div class="flex-1 flex items-center lg:ml-[30%] justify-center text-center text-xl lg:max-w-[25%] lg:max-h-[35%] {{ $transaction->action === 'debit' ? 'text-[#e80909]' : 'text-green-500' }}">
                                            {{ $amountDisplay }}
                                        </div>
                                        <div class="text-center sm:text-left text-xs sm:text-sm lg:max-w-[15%] lg:max-h-[35%] max-w-[40%] ml-[30%]">
                                            {{ $transaction->description }}
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
    </div>


    <!-- Coin Modal -->
    <div id="coinModal" class="hidden z-[3] fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
        onclick="closeModalOnOverlay(event, 'coinModal')">
        <div class="modal-content bg-white rounded-[2.5vw] w-[90%] sm:w-[55rem] h-[40%] sm:h-[27rem] max-h-[90vh] flex flex-col items-center pt-[2.3rem] px-[5rem] pb-[3.5rem]"
            onclick="event.stopPropagation();">
            <div class="flex flex-row items-center mb-3.5">
                <img class="w-10 h-10 mr-2  object-contain" src="{{ asset('assets/lifecycleHPDummy/coin.png') }}" />
                <span class="text-3xl text-[#3e5c49] font-oxanium">{{ $team->coin }}</span>
            </div>

            <div
                class="h-[90%] sm:h[20rem] w-full sm:w-[48rem] rounded-l-[2vw] rounded-r-[1.5vw] bg-[#3e5c49] font-quicksand pr-[10px] mx-[10rem] flex flex-col">
                <div class="custom-scrollbar overflow-y-scroll pr-3 mt-5 sm:mt-1 flex-1">
                    <div class="sm:mt-0">
                        <h1
                            class="text-white font-bold text-center mt-3 ml-9 pl-9 mr-auto pr-auto sm:ml-8 text-lg sm:text-2xl font-oxanium">
                            Riwayat
                            Transaksi</h1>
                        {{-- <div class="wrapper w-full">    --}}
                        {{-- kalau konten panjang jadi double scrollbar ^ --}}

                        <div class="mt-4 pb-10 pr-3 w-full lg:ml-[3%] ml-[10%]">
                            @foreach ($transactionsCoin as $transaction)
                                @php
                                    $date = \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y');
                                    $time = \Carbon\Carbon::parse($transaction->created_at)->format('H:i:s');
                                    $amountDisplay =
                                        $transaction->action === 'debit'
                                            ? '-' . $transaction->amount
                                            : '+' . $transaction->amount;
                                @endphp

                           

                                <div class="bg-[#4d6e5a] rounded-xl p-3 text-white text-sm sm:text-base">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                        <div class="text-center sm:text-left lg:max-w-[25%] lg:max-h-[35%]  ">
                                            <div>{{ $date }}</div>
                                            <div class="text-xs">{{ $time }}</div>
                                        </div>
                                        <div class="flex-1 flex items-center lg:ml-[30%] justify-center text-center text-xl lg:max-w-[25%] lg:max-h-[35%] {{ $transaction->action === 'debit' ? 'text-[#e80909]' : 'text-green-500' }}">
                                            {{ $amountDisplay }}
                                        </div>
                                        <div class="text-center sm:text-left text-xs sm:text-sm lg:max-w-[15%] lg:max-h-[35%] max-w-[40%] ml-[30%]">
                                            {{ $transaction->description }}
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
        function showMascotError() {
            Swal.fire({
                title: 'Error',
                text: data.message,
                imageUrl: '/assets/swalMascots/sadMascot.png',
                imageHeight: 75,
                imageWidth: 75,
                confirmButtonText: 'OKAY',
                customClass: {
                    title: 'custom-swal-title',
                    text: 'custom-swal-message',
                    confirmButton: 'custom-swal-confirmBtn',
                    popup: 'custom-swal-popup1'
                }
            })

        }


        // MASCOT ERROR SWAL --> buat transaction period over and also insufficient cash
        function showMascotError1(type) {
            let message = '';
            let image = '';
            let code = '';

            switch (type) {

                case 'TransactionPeriod_over':
                    message =
                        '<p class="custom-swal-message"> The Transaction Window period is over. If you want to make a purchase, please visit the Central Hub. </p>';
                    btntxt = 'BACK',
                        code = '1'
                    break;
                case 'insufficient_cash':
                    message =
                        '<p class="custom-swal-message"> Sorry, you cannot complete the purchase because your balance is insufficient. </p>';
                    btntxt = 'OKAY',
                        code = '2'
                    break;

            }

            const confirmBtnClass = code === '1' ? 'custom-swal-cancelBtn' : 'custom-swal-confirmBtn';

            Swal.fire({
                html: message,
                imageUrl: '/assets/swalMascots/sadMascot.png',
                imageWidth: 75,
                imageHeight: 75,
                confirmButtonText: btntxt,
                customClass: {
                    confirmButton: confirmBtnClass,
                    popup: 'custom-swal-popup1'
                }
            });
        }

        //CONFIRMATION MASCOT SWAL --> buat konfirmasi mau beli barang
        function showMascotConfirmation() {
            Swal.fire({
                html: '<p class ="custom-swal-message"> Are you sure you want to make the puchase? Make sure to double-check before proceeding! </p>',
                imageUrl: 'assets/swalMascots/thinkingMascot.png',
                imageHeight: 75,
                imageWidth: 75,
                showCancelButton: true,
                confirmButtonText: 'YES',
                cancelButtonText: 'NO',
                customClass: {
                    popup: 'custom-swal-popup1',
                    cancelButton: 'custom-swal-cancelBtn',
                    confirmButton: 'custom-swal-confirmBtn'
                }

            });
        }

        //SUCCESS MASCOT SWAL --> ini buat yang kayak sukses dimasukkan ke cart
        function showMascotSuccess() {
            Swal.fire({
                html: '<p class ="custom-swal-message"> The item has been added to your cart! </p>',
                title: 'Great choice!',
                imageUrl: 'assets/swalMascots/happyMascot.png',
                imageHeight: 75,
                imageWidth: 75,
                confirmButtonText: 'OKAY',
                customClass: {
                    popup: 'custom-swal-popup1',
                    confirmButton: 'custom-swal-confirmBtn',
                    title: 'custom-swal-title'
                }

            });

        }


        document.addEventListener("DOMContentLoaded", function() {
            if (!localStorage.getItem("currentPhaseId")) {
                localStorage.setItem("currentPhaseId", "{{ $currentPhase ? $currentPhase->id : 0 }}");
            }
            if (!localStorage.getItem("currentPhase")) {
                localStorage.setItem("currentPhase", "{{ $currentPhase ? $currentPhase->phase : 0 }}");
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
                    localStorage.setItem("currentPhase", event.phase);
                    localStorage.setItem("hasReducedReturnRates", "false");
                });

        updateCountdown();

        });

        function openModal(id) {
            document.getElementById(id).classList.remove("hidden");
        }

        function closeModalOnOverlay(event, id) {
            document.getElementById(id).classList.add("hidden");
        }

        let countdownString = "{{ $currentPhase ? $currentPhase->end_time : '00:00:00' }}";
        const nowDate = new Date();
        const yyyy = nowDate.getFullYear();
        const mm = String(nowDate.getMonth() + 1).padStart(2, '0');
        const dd = String(nowDate.getDate()).padStart(2, '0');
        const [h, m, s] = countdownString.split(':').map(Number);

        const hasReduced = "{{ $hasReduced }}";
        const countdownTime = new Date(
            yyyy,
            nowDate.getMonth(),
            dd,
            h, m, s
        ).getTime();

        function updateCountdown() {
            let now = new Date().getTime();
            let timeLeft = countdownTime - now;

            if (timeLeft <= 60 * 60 * 1000) {
                document
                    .querySelectorAll("a[onclick*='openTradezoneModal'], button[onclick*='openCluezoneModal']")
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

            // if (timeLeft <= 0 && localStorage.getItem('currentPhase') === "4") {
            //     if (!localStorage.getItem('coinsConverted')) {
            //         localStorage.setItem('coinsConverted', 'true');
            //         window.location.href = '{{ route('convertAllCoins') }}';
            //     }
            // }

            if (timeLeft <= 0) {
                document.getElementById("timer").textContent = "Time's up!";
                return;
            }

            // if (timeLeft <= 60 * 60 * 1000 && hasReduced == 0) {
            //     // localStorage.setItem("hasReducedReturnRates", "true");
            //     let urlTemplate = "{{ route('commodities.reduceReturnRates', ['phase' => ':phase']) }}";
            //     let url = urlTemplate.replace(':phase', localStorage.getItem('currentPhaseId'));

            //     fetch(url, {
            //             method: 'POST',
            //             headers: {
            //                 'Accept': 'application/json',
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //             },
            //             body: JSON.stringify({})
            //         })
            //         .then(res => res.json())
            //         .then(json => {
            //             if (!json.success) {
            //                 console.error("Failed to reduce rates:", json.message);
            //             } else {
            //                 // Swal.fire({
            //                 //     title: 'Success',
            //                 //     text: json.message,
            //                 //     icon: 'info',
            //                 //     confirmButtonText: 'OK'
            //                 // }).then(() => {
            //                 //     // window.location.reload();
            //                 // });
            //             }
            //         })
            //         .catch(err => console.error("AJAX error:", err));
            // }

            let hours = Math.floor((timeLeft / (1000 * 60 * 60)) % 24);
            let minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
            let seconds = Math.floor((timeLeft / 1000) % 60);
            document.getElementById("timer").textContent = `${hours}h ${minutes}m ${seconds}s`;
            setTimeout(updateCountdown, 1000);
        }
        updateCountdown();


        // benerin scrollbar
        document.querySelectorAll('.custom-scrollbar').forEach(scrollableContent => {

            function updateScrollbar() {
                const scrollTop = scrollableContent.scrollTop;
                const maxScroll = scrollableContent.scrollHeight - scrollableContent.clientHeight;

                let scrollPercentage = 0;
                if (maxScroll > 0) {
                    scrollPercentage = (scrollTop / maxScroll) * 100;
                }

                scrollableContent.style.setProperty('--scroll-progress', scrollPercentage + '%');
            }

            scrollableContent.addEventListener('scroll', updateScrollbar);
            updateScrollbar();
        });
    </script>

</body>

</html>
