<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lifecycle Simulation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative h-screen bg-cover bg-center bg-[rgba(0,0,0,0.5)]" style="background-image: url('background.jpg');">
    
    <!-- Menu -->
    <div class="absolute top-4 left-4 text-white text-5xl cursor-pointer">☰</div>

    <!-- Resources -->
    <div class="absolute top-4 right-4 flex space-x-4">
        <div class="bg-white px-6 py-2 rounded-full flex items-center space-x-2 font-bold shadow text-[#415943] text-xl">
            <span>🍃</span> 
            <span id="leafAmount">200.000</span> <!-- Data dummy -->
        </div>
        <div id="coinBox" class="bg-white px-6 py-2 rounded-full flex items-center space-x-2 font-bold shadow text-[#415943] text-xl cursor-pointer">
            <span>💰</span> 
            <span id="coinAmount">1.000.000</span> <!-- Data dummy -->
        </div>
    </div>

    <div class="flex flex-col items-center justify-center h-full text-white">
        <h1 class=" mt-[200px] text-8xl font-semibold">Lifecycle Simulation</h1>
        <h2 class= "text-8xl font-bold">CAPITAL 2025</h2>
        
        <ROUND class="mt-[100px] text-3xl font-bold">ROUND {{ $game->round ?? 'N/A' }}</div>

        <div id="timer" class=" absolute bottom-20 left-1/2 transform -translate-x-1/2 text-[#415943] bg-white text-black px-20 py-5 rounded-full text-3xl font-bold shadow-lg">
           
        </div>
        
    </div>

    <!-- Modal Transaksi -->
    <div id="transactionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[350px]">
            <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-[#415943] flex items-center">
                    💰 <span id="modalCoinAmount" class="ml-2">1.000.000</span>
                </span>
                <button id="closeModal" class="text-gray-500 text-xl">&times;</button>
            </div>
            <hr class="my-2">
            <div class="text-lg font-semibold text-center">Riwayat Transaksi</div>
            <div class="mt-4 h-32 overflow-y-auto">
                <div class="text-sm space-y-2">
                    <div class="flex justify-between">
                        <span>26/12/24 17:20</span> 
                        <span class="text-green-600">+50.000 (Pos 1)</span>
                    </div>
                    <div class="flex justify-between">
                        <span>26/12/24 17:50</span> 
                        <span class="text-red-600">-100.000 (Trade Zone)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    
        // Ambil waktu countdown dari server (format: HH:MM:SS)
        let countdownString = "{{ $game->countdown }}"; 

        // Buat tanggal hari ini dalam format YYYY-MM-DD
        let todayDate = new Date().toISOString().split('T')[0];

        // Gabungkan tanggal hari ini dengan waktu countdown dari server
        let countdownTime = new Date(todayDate + "T" + countdownString + "+07:00").getTime();

        function updateCountdown() {
            let now = new Date().getTime();
            let timeLeft = countdownTime - now;

            if (timeLeft <= 0) {
                document.getElementById("timer").textContent = "Time's up!";
                return;
            }

            let hours = Math.floor((timeLeft / (1000 * 60 * 60)) % 24);
            let minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
            let seconds = Math.floor((timeLeft / 1000) % 60);

            document.getElementById("timer").textContent = `${hours}h ${minutes}m ${seconds}s`;

            setTimeout(updateCountdown, 1000);
        }

        updateCountdown();


        console.log("Waktu sekarang (WIB):", new Date().toLocaleString("id-ID", { timeZone: "Asia/Jakarta" }));
        console.log("Countdown dari Database:", countdownString);
        console.log("Countdown Time (ms):", countdownTime);
        console.log("Countdown dalam WIB:", new Date(countdownTime).toLocaleString("id-ID", { timeZone: "Asia/Jakarta" }));

    </script>
</body>
</html>
