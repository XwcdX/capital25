@extends('user.layout')

@section('title', $title)


@section('style')
<style>


.wrapper {
    height: 15rem !important;
    /* padding-right: 20px !important; */
}

  .custom-scrollbar{
   width: 100% !important;
   height: 100% !important;
   overflow-y: auto !important; 
   /* padding-right: 10px !important;    */
  }

  .custom-scrollbar::-webkit-scrollbar {
    width: 1.25rem !important;
    position: absolute;
}


 .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #dedede!important; 
    border-radius: 50px !important;
    max-height: 20px !important;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background-color: #a8a8a8 !important;
    border-radius: 50px !important;
    margin: 30px !important;
}

.modal-content{
    padding-left: 8rem !important;
    padding-right: 8rem !important;
}

@media (max-width: 640px){
    .modal-content{
        padding-left: 2rem !important;
        padding-right: 2rem !important;
    }
}

.space-value{
    margin-left: 6rem !important;
}

@media (max-width: 640px){
    .space-value{
        margin-left: 1.5rem !important;
    }
}
.outline-text {
    color: white;
    text-shadow: 
        -1px -1px 0 black,  
         1px -1px 0 black,  
        -1px  1px 0 black,  
         1px  1px 0 black;
}


</style>
@endsection


{{-- bikin modal transaction history greenpoint & coin --}}


@section('content')

{{-- whole page div --}}
<div class="h-screen w-screen relative flex items-center justify-center">
    {{-- bg picture --}}
    <img src="{{ asset('assets/lifecycleHPDummy/dummyBG.jpeg') }}" class="absolute inset-0 w-full h-full object-cover">

    {{-- div for showing greenpoints and coins --}}
    <div class="absolute top-0 right-0 my-3 mr-3 flex space-x-3 flex-wrap font-quicksand">
        {{-- greenpoint --}}
        <button onclick="openModal('greenpointModal'); hideText('homepage_text')" 
            class="hover:bg-slate-400 hover:cursor-pointer bg-white text-[#3e5c49] rounded-[2vw] w-[10rem] min-w-[6rem] h-12 flex items-center justify-center box-border px-3 font-oxanium">
            <img src="{{ asset('assets/lifecycleHPDummy/coin.png') }}" class="w-8 h-8 mr-2">
            <span class="text-2xl">{{$greenpoint}}</span>
        </button>

        {{-- coins --}}
        <button onclick="openModal('coinModal'); hideText('homepage_text')" 
            class="hover:bg-slate-400 hover:cursor-pointer bg-white text-[#3e5c49] rounded-[2vw] w-[10rem] min-w-[6rem] h-12 flex items-center justify-center box-border px-3 font-oxanium">
            <img src="{{ asset('assets/lifecycleHPDummy/green-point.png') }}" class="w-8 h-8 mr-2">
            <span class="text-2xl">{{$coin}}</span>  
        </button>
    </div>

    {{-- Lifecycle simulation text --}}
    <div class="z-10 text-center font-oxanium outline-text" id="homepage_text">
        <h1 class="text-3xl sm:text-5xl md:text-6xl text-white font-semibold">Lifecycle Simulation</h1>
        <h1 class="text-4xl sm:text-6xl md:text-7xl font-bold uppercase">Capital 2025</h1>
    </div>
</div>

{{-- Modal untuk coin --}}
<div id="outer">
    <div id="greenpointModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <button onclick="closeModal('greenpointModal'); returnText('homepage_text')" class ="top-4 right-4 absolute text-white text-5xl"> &times; </button>
        <div class="modal-content bg-white rounded-[2.5vw] w-[90%] sm:w-[55rem] h-auto max-h-[90vh] flex flex-col items-center px-[8rem] pt-[2.3rem] pb-[2rem]">
            {{-- icon + jumlah --}}
            <div class="flex flex-row mb-3.5">
                <img src="{{ asset('assets/lifecycleHPDummy/coin.png') }}" class="w-8 h-8 mr-2">
                <span class=" text-3xl text-[#3e5c49] font-oxanium">{{$coin}}</span>
            </div>
            {{-- Riwayat Transaksi --}}
            <div class="p-5 h-[50vh] sm:h-[18rem] w-full sm:w-[40rem] overflow-y-auto rounded-l-[2vw] rounded-r-[1.5vw] bg-[#3e5c49] custom-scrollbar font-oxanium">
                <h1 class="text-white font-bold text-center mt-2 pl-5 text-lg sm:text-2xl font-oxanium">Riwayat Transaksi</h1>
                <div class="wrapper">
                <div class="custom-scrollbar mt-4 pb-10 overflow-y-auto pr-3">
                    @foreach ($transactionsGreenPoint as $i)
                        @php
                            $datetime = explode(' ', $i->created_at); 
                            $date = $datetime[0] ?? ''; 
                            $time = $datetime[1] ?? ''; 
                        @endphp

                        <div class="flex justify-start items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5">
                            {{-- Tanggal - Jam flex-col --}}
                            <div class="flex flex-col items-center">
                                <span>{{ $date }}</span>  
                                <span>{{ $time }}</span>  
                            </div>  
                            {{-- Value --}}
                            <div class="">
                                <span class="{{ $i->greenpoint < 0 ? 'text-[#e80909]' : 'text-green-500'  }} text-2xl relative top-3 space-value">
                                    {{ $i->greenpoint < 0 ? $i->greenpoint : '+' . $i->greenpoint }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- cek spacing coins apply to greenpoint --}}
{{-- Modal untuk Coins --}}
<div id="outer" >
    <div id="coinModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <button onclick="closeModal('coinModal'); returnText('homepage_text')" class ="top-4 right-4 absolute text-white text-5xl"> &times; </button>
        <div class="modal-content bg-white rounded-[2.5vw] w-[90%] sm:w-[55rem] h-auto max-h-[90vh] flex flex-col items-center pt-[2.3rem] pb-[2rem]">
            {{-- icon + jumlah --}}
            <div class="flex flex-row mb-3.5">
                <img src="{{ asset('assets/lifecycleHPDummy/green-point.png') }}" class="w-8 h-8 mr-2">
                <span class=" text-3xl text-[#3e5c49] font-oxanium">{{$greenpoint}}</span>
            </div>
            {{-- Riwayat Transaksi --}}
            <div class="p-5 h-[50vh] sm:h-[18rem] w-full sm:w-[40rem] overflow-y-auto rounded-l-[2vw] rounded-r-[1.5vw] bg-[#3e5c49] custom-scrollbar font-oxanium">
                <h1 class="text-white font-bold text-center mt-2 pl-5 text-lg sm:text-2xl ">Riwayat Transaksi</h1>
                <div class="wrapper">
                <div class="custom-scrollbar mt-4 pb-10 overflow-y-auto pr-3">
                    @foreach ($transactionsCoin as $i)
                        @php
                            $datetime = explode(' ', $i->created_at); 
                            $date = $datetime[0] ?? ''; 
                            $time = $datetime[1] ?? ''; 
                        @endphp

                    <div class="flex justify-start items-center text-white font-semibold text-2xl ml-5 mr-5 mb-5">
                        {{-- Tanggal - Jam flex-col --}}
                        <div class="flex flex-col items-center">
                            <span>{{ $date }}</span>  
                            <span>{{ $time }}</span>  
                        </div>  
                        {{-- Value --}}
                        <div class="flex flex-row">
                            <span class="{{ $i->coin < 0 ? 'text-[#e80909]' : 'text-green-500'  }} text-2xl relative top-3 space-value">
                                {{ $i->coin < 0 ? $i->coin : '+' . $i->coin }}
                            </span>
                        </div>
                    </div>
                @endforeach
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove("hidden");
    }

    function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
    }

    function hideText(id) {
        document.getElementById(id).classList.add("hidden");
    }

    function returnText(id) {
        document.getElementById(id).classList.remove("hidden");
    }
</script>

@endsection