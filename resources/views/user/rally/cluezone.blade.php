@php
    switch ($currentPhase ? $currentPhase->phase : 'not started yet') {
        case 1:
            $ticketPrice = 1000;
            break;
        case 2:
            $ticketPrice = 2000;
            break;
        case 3:
            $ticketPrice = 4000;
            break;
        case 4:
            $ticketPrice = 8000;
            break;
        default:
            $ticketPrice = 0;
    }
@endphp

<div id="cluezone-modal" class="hidden fixed inset-0 z-50 flex flex-col items-center justify-center bg-black bg-opacity-50"
    onclick="closeModalOnOverlay(event,'cluezone-modal')">
    <h2 class="text-6xl font-bold text-white text-center">
        Clue Zone
    </h2>
    <div id="cluezone-content" class="relative bg-[#ece7e3] rounded-2xl p-6 md:w-[60%] pt-14  shadow-lg mt-4 "
        onclick="event.stopPropagation()">

        <button id="cluezone-history-btn"
            class="absolute top-4 right-4 bg-white p-2 rounded-full shadow hover:bg-gray-100 text-sm font-semibold"
            onclick="openCluezoneHistoryModal()">
            History
        </button>

        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="text-center mx-auto">
                <img src="{{ asset('assets/ClueZoneTicket.png') }}" alt="Ticket Clue Zone"
                    class="w-64 lg:ml-[40%] h-auto object-cover rounded-lg shadow-md mx-auto" />
                <p class="font-bold text-2xl text-[#415943] mt-3 lg:ml-[75%] ">
                    ${{ number_format($ticketPrice, 0, ',', '.') }}
                </p>
            </div>
            <div class="flex-1">
                <p class="text-3xl font-bold text-center text-[#415943] mb-4">
                    Ticket Clue Zone
                </p>
                <form id="cluezone-form" action="{{ route('cluezone.buy') }}" method="POST"
                    class="flex justify-center">
                    @csrf
                    <label for="quantity" class="sr-only">Quantity</label>
                    <select id="quantity" name="quantity" class="w-20 border border-gray-300 rounded-md p-2">
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-4">
            <button id="cluezone-back" type="button"
                class="w-full py-2 font-bold border-2 border-[#415943] rounded-full text-[#415943] bg-white">
                Back
            </button>
            <button id="cluezone-buy" type="button" class="w-full py-2 font-bold rounded-full bg-[#415943] text-white">
                Buy
            </button>
        </div>
    </div>
</div>

<div id="cluezone-history-modal"
    class="hidden z-[1002] fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center px-2"
    onclick="closeModalOnOverlay(event,'cluezone-history-modal')">

    <div class="modal-content
              bg-white rounded-[2.5vw]
              w-[95%] lg:w-[55rem]
              h-auto max-h-[90vh]
              flex flex-col items-center
              pt-6 pb-6 sm:pt-[2.3rem] sm:pb-[2rem]"
        onclick="event.stopPropagation();">

        <div
            class="h-[60vh] sm:h-[18rem]
                w-full sm:w-[40rem]
                overflow-y-auto
                rounded-l-[2vw] rounded-r-[1.5vw]
                bg-[#3e5c49]
                custom-scrollbar
                font-quicksand p-4">

            <h1 class="text-white font-bold text-center mt-3 pl-5 text-lg sm:text-2xl font-oxanium">
                Riwayat Pembelian Tiket
            </h1>

            <div class="wrapper w-full">
                <div class=" pb-10 overflow-x-hidden space-y-4 lg:ml-[10%] ml-[20%]">
                    
                    @foreach ($clueZoneTicket as $tx)
                        @php
                            $date = $tx->created_at->format('d/m/Y');
                            $time = $tx->created_at->format('H:i:s');
                            $desc = "Buying {$tx->quantity} ticket(s) on phase {$tx->phase->phase}";
                        @endphp

                        <div class="bg-[#4d6e5a] rounded-xl p-3 text-white text-sm sm:text-base">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                <div class="text-center sm:text-left">
                                    <div>{{ $date }}</div>
                                    <div class="text-xs">{{ $time }}</div>
                                </div>
                                <div class="text-center text-red-300 font-bold sm:text-xl">
                                    -${{ number_format($tx->price, 0, ',', '.') }}
                                </div>
                                <div class="text-center sm:text-left text-xs sm:text-sm">
                                    {{ $desc }}
                                </div>
                            </div>
                        </div>

                        

                    
                    @endforeach

                    @if ($clueZoneTicket->isEmpty())
                        <p class="text-center text-gray-200 mt-10">Belum ada riwayat pembelian tiket.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    (function() {
        const mainId = 'cluezone-modal';
        const histId = 'cluezone-history-modal';
        const modalIds = [mainId, histId];

        const buyBtn = document.getElementById('cluezone-buy');
        const backBtn = document.getElementById('cluezone-back');
        buyBtn.addEventListener('click', () => document.getElementById('cluezone-form').submit());
        backBtn.addEventListener('click', () => closeModal(mainId));

        document.getElementById('cluezone-history-btn')
            .addEventListener('click', () => openModal(histId));

        window.closeModalOnOverlay = (e, id) => {
            if (e.target.id === id) closeModal(id);
        };

        window.openClueZoneModal = () => openModal(mainId);
        window.openCluezoneHistoryModal = () => openModal(histId);
        window.closeClueZoneModal = () => closeModal(mainId);

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    })();

    
</script>
