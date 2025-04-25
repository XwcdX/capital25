@extends('user.layout')

@section('style')
    <style>
        html,
        body {
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
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
        }

        .text-outline {
            color: #ffffff;
            font-weight: bold;
            text-shadow: 2px 2px 4px #000000, -2px -2px 4px #000000, 2px -2px 4px #000000, -2px 2px 4px #000000;
        }
    </style>
@endsection

@section('content')
    <div class="w-screen h-screen flex flex-col items-center justify-center">
        <img class="bgfullScreen" src="{{ asset('assets/login.png') }}" alt="Background">

        {{-- TIMERRR --}}
        <div id="timer" class="text-white font-semibold text-6xl justify-center items-center text-center text-outline">
        </div>

        <!-- Main content -->
        <div class="containerMain bg-blue-950 bg-opacity-70 text-white rounded-xl w-full h-auto font-quicksand">
            <!-- Background image (covers entire screen) -->
            @if ($currentPhase)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                    @foreach ($commodities as $commodity)
                        @if ($commodity->phase_id == $currentPhase->id)
                            <div class="text-white grid-cols-5">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-30 h-30 overflow-hidden">
                                        <img src="{{ asset($commodity->image) }}" alt="{{ $commodity->name }}"
                                            class="gambar items-center justify-center justify-items-center mt-5">
                                    </div>
                                    <h2 class="text-lg font-semibold mt-[-1.5rem]">{{ $commodity->name }}</h2>
                                    <p class="priceItem text-lg font-bold">
                                        {{ number_format($commodity->price, 0, ',', '.') }}</p>


                                    <div
                                        class="space-y-1 text-lg returnrate 
                                    @if ($commodity->return_rate == 0.075) text-green-500 font-bold
                                    @elseif($commodity->return_rate == 0.05) text-yellow-300 font-bold
                                    @elseif($commodity->return_rate == 0.0375) text-red-600 font-bold @endif  
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
    </div>

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            updateCountdown()
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
                });
        });

        // Directly use the time string from your DB
        const endTimeString = "{{ $currentPhase ? $currentPhase->end_time : '00:00:00' }}";

        // Parse "HH:mm:ss"
        const [endHours, endMinutes, endSeconds] = endTimeString
            .split(':')
            .map(Number);

        // Compute the next timestamp for that time today (or tomorrow if passed)
        function getCountdownTimestamp() {
            const now = new Date();
            let target = new Date(
                now.getFullYear(),
                now.getMonth(),
                now.getDate(),
                endHours,
                endMinutes,
                endSeconds
            );
            if (target.getTime() <= now.getTime()) {
                // if already past, move to next day
                target.setDate(target.getDate() + 1);
            }
            return target.getTime();
        }

        const countdownTime = getCountdownTimestamp();

        function updateCountdown() {
            const now = Date.now();
            const timeLeft = countdownTime - now;
            const timerEl = document.getElementById("timer");
            const returnRateEls = document.querySelectorAll(".returnrate");
            const priceItemEls = document.querySelectorAll(".priceItem");

            if (!endTimeString || endTimeString === '00:00:00') {
                timerEl.textContent = "Phase not started yet";
                return;
            }

            if (timeLeft <= 0) {
                timerEl.textContent = "Time's up!";
                return;
            }
            const pad = n => String(n).padStart(2, '0');
            if (timeLeft > 60 * 60 * 1000) {
                // More than 60 minutes
                const totalMinutes = Math.floor(timeLeft / (1000 * 60));
                const displayMinutes = totalMinutes - 60;
                const seconds = Math.floor((timeLeft / 1000) % 60);
                timerEl.textContent = `${pad(displayMinutes)}:${pad(seconds)}`;
                returnRateEls.forEach(el => el.classList.add('hidden'));
                priceItemEls.forEach(el => el.classList.remove('hidden'));
            } else {
                // 60 minutes or less
                const minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
                const seconds = Math.floor((timeLeft / 1000) % 60);
                timerEl.textContent = `${pad(displayMinutes)}:${pad(seconds)}`;

                returnRateEls.forEach(el => el.classList.remove('hidden'));
                priceItemEls.forEach(el => el.classList.add('hidden'));
            }

            setTimeout(updateCountdown, 1000);
        }

        updateCountdown();
    </script>
@endsection
