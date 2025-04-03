@extends('user.layout')

@section('title', $title)

@section('style')
<style>

.wrapper{
    position: relative !important;
    width: 100% !important;
    height: 20rem !important;
    overflow:  hidden !important;
    padding-right: 15px !important;
    padding-left: 20px !important;
}

.content-scroll{
    height: 100% !important;
    overflow-y: auto;
    padding-right: 15px !important; 
    padding-bottom: 2rem !important;
}

.custom-scrollbar{
    width: 100% !important;
    height: 100% !important;
    overflow-y: auto !important; 
    padding-right: 16px !important;
    margin-right: 20px !important;
    
   }
 
   .custom-scrollbar::-webkit-scrollbar {
     width: 0.8rem !important;
     position: absolute;
 }
 
 
  .custom-scrollbar::-webkit-scrollbar-thumb {
     background: #dedede!important; 
     border-radius: 50px !important;
     max-height: 20px !important;
     min-height: 0px !important;
 }
 
 .custom-scrollbar::-webkit-scrollbar-track {
     background-color: #a8a8a8 !important;
     border-radius: 50px !important;
     margin: 30px !important;
 }
</style> 

@section('content')

<div class="min-h-screen w-screen flex flex-col items-center px-4">

    <img src="{{ asset('assets/lifecycleHPDummy/dummyBG.jpeg') }}" class="absolute inset-0 w-full h-full object-cover">
    <h1 class="text-[#fffdf7] text-2xl md:text-4xl text-center pt-8 md:pt-16 font-bold">Storyline</h1>

    <div class="bg-black bg-opacity-50 fixed min-h-screen w-screen justify-center items-center flex">
        {{-- Main Box --}}
        <div class="relative rounded-3xl mt-4 bg-[#fffdf7] md:w-full w-[35rem] max-w-lg md:max-w-3xl h-[28rem] p-5 md:p-8 flex flex-col my-5 mx-5 px-3">
            <div class="mb-2 break-words text-center">
                <h1 id="fase-title" class="text-xl md:text-3xl text-[#03300f] font-bold">Fase {{$currentPhase}}</h1>
            </div>

            {{-- Tombol Previous --}}
            <button id="prev-btn" type ="button" class="absolute left-0 md:left-0 top-1/2 transform -translate-y-1/2">
                <img src="{{ asset('assets/storyline/left.png') }}" class="h-6 w-6 md:h-10 md:w-10">
            </button>

            {{-- Konten Storyline --}}
            <div class ="wrapper ">
            <div class="overflow-y-auto justify-items-center mt-3 mx-auto md:mt-4 md:px-30 px-3 content-scroll custom-scrollbar">
                <p id="storyline-text" class="text-[#03300f] font-bold text-justify text-sm md:text-lg leading-relaxed">
                    {{ $storylines[$currentPhase] ?? 'Fase tidak ditemukan' }}
                </p>
                </div>
            </div>
          

            {{-- Tombol Next --}}
            <button id="next-btn" type ="button" class="absolute right-0 md:right-0 top-1/2 transform -translate-y-1/2">
                <img src="{{ asset('assets/storyline/left.png') }}" class="h-6 w-6 md:h-10 md:w-10 rotate-180">
            </button>
        </div>
    </div>
</div>

{{-- revisi w/o refresh--}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let currentPhase = {{ $currentPhase }};
        let maxPhase = {{$maxUnlockedPhase}}; 
        let totalPhases = 4;
        let storylines = @json($storylines);

        const titleElement = document.getElementById("fase-title");
        const textElement = document.getElementById("storyline-text");
        const prevButton = document.getElementById("prev-btn");
        const nextButton = document.getElementById("next-btn");

        function updateStoryline() {
            titleElement.textContent = `Fase  ${currentPhase }`;
            textElement.textContent = storylines[currentPhase] || "Fase tidak ditemukan";
            
            //atur show/hide, >1 show, else hide, <maxUnlock show, else hide
            prevButton.style.visibility = (currentPhase > 1) ? "visible" : "hidden";
            nextButton.style.visibility = (currentPhase < maxPhase && currentPhase < maxPhase) ? "visible" : "hidden";
        }

        prevButton.addEventListener("click", function () {
            if (currentPhase > 1) {
                currentPhase--;
                updateStoryline();
            }
        });

        nextButton.addEventListener("click", function () {
            if (currentPhase < totalPhases) {
                currentPhase++;
                updateStoryline();
            }
        });

        // Inisialisasi tampilan awal
        updateStoryline();
    });
</script>

@endsection