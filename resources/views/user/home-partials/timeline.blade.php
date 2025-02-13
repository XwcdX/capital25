<section id="timeline" class="relative h-screen w-screen bg-[#14240a] z-[11] flex justify-center items-center">
    <div class="relative container h-[75%] lg:h-[60%] xl:h-[70%] flex items-center justify-center overflow-hidden gap-[4%] 
        md:w-[80%] lg:w-[65%] transition-all duration-500">
        <div class="box h-full w-full md:w-auto flex flex-col items-center justify-center space-y-2 md:space-y-5" id="leftBox">
            <img class="max-lg:w-[80px] lg:w-[150px]" src="{{ asset('assets/timeline/icon-mic.png')}}" alt="">
            <h1 class="text-white text-lg md:text-2xl font-bold w-[70%] text-center">Seminar & Technical Meeting</h1>
        </div>
        <div class="box h-full w-full md:w-auto flex flex-col items-center justify-center space-y-2 md:space-y-5" id="centerBox">
            <img class="max-lg:w-[80px] lg:w-[150px]" src="{{ asset('assets/timeline/icon-recycle.png')}}" alt="">
            <h1 class="text-white text-lg md:text-2xl font-bold w-[70%] text-center">Lifecycle Simulation</h1>
        </div>
        <div class="box h-full w-full md:w-auto flex flex-col items-center justify-center space-y-2 md:space-y-5" id="rightBox">
            <img class="max-lg:w-[80px] lg:w-[150px]" src="{{ asset('assets/timeline/icon-container.png')}}" alt="">
            <h1 class="text-white text-lg md:text-2xl font-bold w-[70%] text-center">Closing & Awarding Ceremony</h1>
        </div>
        <button id="closeBtn"
            class="absolute top-4 right-4 bg-white/80 text-gray-900 p-2 text-lg rounded-full opacity-0 pointer-events-none transition-opacity duration-300">
            ❌
        </button>
    </div>
</section>
