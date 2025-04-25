@extends('user.layout')

@section('content')

{{-- @php
    $currentPhase = (object) [
        'id' => '9eb4be5a-74bd-4354-9b93-f45ad9dc2e8e',
        'phase' => 'Fase 2',
        'end_time' => '2025-04-30 23:59:59',
        'created_at' => '2025-01-01 12:00:00',
        'updated_at' => '2025-01-01 12:00:00'
    ];
@endphp --}}

<style>
    html, body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        font-family: 'oxanium'
    }

    .gambar {
        height: 10rem;
        width: 10rem;
    }

    .containerMain {
        max-width: 75rem;
        padding-left: 4rem;
        padding-right: 4rem; 
        padding-bottom: 2rem;
        z-index: 1;
    }

    .bgfullScreen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        object-fit: cover;
        z-index: -1;
    }

    
</style>

<body class="relative">
    <!-- Background image (covers entire screen) -->
    <img class="bgfullScreen" src="{{ asset('assets/login.png') }}" alt="Background">

    <!-- Main content -->
    <div class="containerMain bg-blue-950 bg-opacity-70 text-white rounded-xl absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-auto  mt-10">
        @if ($currentPhase)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                @foreach ($commodities as $commodity)
                    @if ($commodity->phase_id == $currentPhase->id) 
                        <div class="text-white grid-cols-5">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-30 h-30 overflow-hidden">
                                    <img src="{{ asset($commodity->image) }}" alt="{{ $commodity->name }}" class="gambar items-center justify-center justify-items-center mt-5">
                                </div>
                                <h2 class="text-lg font-semibold mt-[-1.5rem]">{{ $commodity->name }}</h2>
                                <p class="priceItem text-lg font-bold">{{ number_format($commodity->price, 0, ',', '.') }}</p>
                                    

                                <div class="space-y-1 text-lg returnrate 
                                    @if($commodity->return_rate == 0.075) text-green-500 font-bold
                                    @elseif($commodity->return_rate == 0.05) text-yellow-300 font-bold
                                    @elseif($commodity->return_rate == 0.0375) text-red-600 font-bold
                                    @endif  
                                    ">
                                    <p>{{ number_format($commodity->price, 0, ',', '.') }}</p>
                                    <p>
                                        @if ($commodity->return_rate == 0.075)
                                            10% → 7.5%
                                        @elseif ($commodity->return_rate == 0.05)
                                            7.5% → 5%
                                        @elseif ($commodity->return_rate == 0.0375)
                                            5% → 3.75%
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                    </div>

            {{-- Kalau phase nya belum start/ga ada --}}
        @else
            <p>Tidak ada fase yang aktif saat ini.</p>
        @endif
    </div>

    {{-- TIMERRR --}}
    <div id="timer" class="text-white font-semibold text-5xl justify-center items-center mx-[40rem] mt-[5.5rem] mr-10">

    </div>
</body>

@endsection

@section('script')
<script>

document.addEventListener('DOMContentLoaded', function () {
    updateCountdown();
});

let countdownString = "{{ $currentPhase ? $currentPhase->end_time : '2025-12-31 17:00:00' }}";  // Ganti dengan nilai default atau null handling
const nowDate = new Date();


const [endYear, endMonth, endDay, endHours, endMinutes, endSeconds] = countdownString.split(/[- :]/).map(Number);

const countdownTime = new Date(
    endYear,
    endMonth - 1, 
    endDay,
    endHours,
    endMinutes,
    endSeconds
).getTime();

function updateCountdown() {
    let now = new Date().getTime();
    let timeLeft = countdownTime - now;
    let returnRateElements = document.querySelectorAll(".returnrate")
    let returnPriceItem = document.querySelectorAll(".priceItem")

    // Jika waktu tersisa lebih dari 60 menit, tampilkan sisa waktu setelah dikurangi 60 menit
    if (timeLeft > 60 * 60 * 1000) {
        let minutesLeft = Math.floor(timeLeft / (1000 * 60)); 
        let minutesToDisplay = minutesLeft - 60;  
        let seconds = Math.floor((timeLeft / 1000) % 60);

        document.getElementById("timer").textContent = `${minutesToDisplay}m ${seconds}s`;

        returnRateElements.forEach(el=>{
            el.classList.add('hidden');
        });
        
        returnPriceItem.forEach(el => {
            el.classList.remove('hidden');
        });
    } else {
        // Jika waktu tersisa <= 60 menit, tampilkan waktu sisa dalam menit dan detik
        let minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
        let seconds = Math.floor((timeLeft / 1000) % 60);
        document.getElementById("timer").textContent = `${minutes}m ${seconds}s`;

        returnRateElements.forEach(el=>{
            el.classList.remove('hidden');
        });
        
        returnPriceItem.forEach(el => {
            el.classList.add('hidden');
        });
    }

    // Jika waktu sudah habis
    if (timeLeft <= 0) {
        document.getElementById("timer").textContent = "Time's up!";
        return;
    }

    // Update setiap detik
    setTimeout(updateCountdown, 1000);
}

updateCountdown();

</script>