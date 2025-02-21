<style>
</style>

<section id="timeline" class="relative h-screen w-screen bg-[#14240a] z-[14] flex justify-center items-center">
    
    <img src="{{ asset('assets/landing/daun-ijo.png')}}" alt="" loading="lazy" 
    class="bush w-full scale-[2.5] sm:scale-[1.6] lg:scale-[1.1] object-cover absolute -top-[5%] sm:-top-[10%] md:-top-[8%] lg:-top-[10%] xl:-top-[10%] left-0 z-[14]">
    
    
    <div class="relative container h-[80%] md:h-[68%] xl:h-[70%] flex items-center justify-center overflow-hidden gap-[4%] 
        w-[90%] sm:w-[85%] lg:w-[80%] transition-all duration-500">
        <div class="box h-full w-full flex flex-col items-center justify-center [@media(max-width:400px)]:space-y-2 space-y-5 md:space-y-5 " id="leftBox">
            <img class="original-content w-[70px] sm:w-[80px] lg:w-[125px] xl:w-[150px]" src="{{ asset('assets/timeline/icon-mic.png')}}" alt="">
            <h1 class="original-content text-white text-xl md:text-2xl font-extrabold w-[70%] text-center font-quicksand">Seminar & Technical Meeting</h1>

            <div class="hidden-content text-center w-[80%] sm:w-[80%] lg:w-3/4 hidden opacity-0 h-0 overflow-hidden transition-all duration-500 ease-in-out">
                <h1 class="timeline-title text-lg [@media(max-width:400px)]:text-xl sm:text-2xl lg:text-4xl font-oxanium text-black font-bold"></h1>
                <p class="timeline-desc text-md [@media(max-width:400px)]:text-base sm:text-lg xl:text-xl font-quicksand text-black my-5 sm:my-5 xl:my-10"></p>
                <div class="datetime font-quicksand text-md sm:text-lg xl:text-xl  text-black">
                    <h1 class="timeline-date"></h1>
                    <h1 class="timeline-time"></h1>
                    <h1 class="timeline-loc"></h1>
                </div>
                {{-- <button class="rounded-3xl border border-black border-[2px] bg-transparent text-black font-quicksand font-bold px-5 py-2 mt-5">Guidebook</button> --}}
            </div>
        </div>
        <div class="box h-full w-full flex flex-col items-center justify-center [@media(max-width:400px)]:space-y-2 space-y-5 md:space-y-5" id="centerBox">
            <img class="original-content w-[70px] sm:w-[80px] lg:w-[125px] xl:w-[150px]" src="{{ asset('assets/timeline/icon-recycle.png')}}" alt="">
            <h1 class="original-content text-white text-xl md:text-2xl font-extrabold w-[70%] text-center font-quicksand ">Lifecycle <br>Simulation</h1> 

            <div class="hidden-content text-center w-[80%] sm:w-[80%] lg:w-3/4 hidden opacity-0 h-0 overflow-hidden transition-all duration-500 ease-in-out">
                <h1 class="timeline-title text-lg [@media(max-width:400px)]:text-xl sm:text-2xl lg:text-4xl font-oxanium text-black font-bold"></h1>
                <p class="timeline-desc text-md [@media(max-width:400px)]:text-base sm:text-lg xl:text-xl font-quicksand text-black my-5 sm:my-5 xl:my-10"></p>
                <div class="datetime font-quicksand text-md sm:text-lg xl:text-xl text-black">
                    <h1 class="timeline-date"></h1>
                    <h1 class="timeline-time"></h1>
                    <h1 class="timeline-loc"></h1>
                </div>
                <button class="guidebook rounded-3xl border border-black border-[2px] bg-transparent text-black font-quicksand font-bold px-5 py-2 mt-5">Guidebook</button>
            </div>
        </div>
        <div class="box h-full w-full flex flex-col items-center justify-center [@media(max-width:400px)]:space-y-2 space-y-5 md:space-y-5" id="rightBox">
            <img class="original-content w-[70px] sm:w-[80px] lg:w-[125px] xl:w-[150px]" src="{{ asset('assets/timeline/icon-container.png')}}" alt="">
            <h1 class="original-content text-white text-xl md:text-2xl font-extrabold w-[70%] text-center font-quicksand">Talk Show & Awarding Ceremony</h1>

            <div class="hidden-content text-center w-[80%] sm:w-[80%] lg:w-3/4 hidden opacity-0 h-0 overflow-hidden transition-all duration-500 ease-in-out">
                <h1 class="timeline-title text-lg [@media(max-width:400px)]:text-xl sm:text-2xl lg:text-4xl font-oxanium text-white font-bold"></h1>
                <p class="timeline-desc text-md [@media(max-width:400px)]:text-base sm:text-lg xl:text-xl font-quicksand text-white my-5 sm:my-5 xl:my-10"></p>
                <div class="datetime font-quicksand text-md sm:text-lg xl:text-xl text-white">
                    <h1 class="timeline-date"></h1>
                    <h1 class="timeline-time"></h1>
                    <h1 class="timeline-loc"></h1>
                </div>
                {{-- <button class="rounded-3xl border border-white border-[2px] bg-transparent text-white font-quicksand font-bold px-5 py-2 mt-5">Guidebook</button> --}}
            </div>
        </div>
        <button id="closeBtn"
            class="absolute top-4 right-4 bg-white/80 text-gray-900 p-2 text-lg rounded-full opacity-0 pointer-events-none transition-opacity duration-300">
            ❌
        </button>
    </div>
</section>
