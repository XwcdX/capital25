<div id="storylineModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[1002]" onclick="closeModal('storylineModal')">
    <div class="bg-[#fffdf7] rounded-3xl w-[90%] sm:w-[55rem] max-w-lg md:max-w-3xl h-[28rem] p-5 md:px-12 md:py-10 flex flex-col relative" onclick="event.stopPropagation();">
        <div class="mb-2 text-center">
            <h1 id="fase-title" class="text-xl md:text-3xl text-[#03300f] font-bold font-oxanium">Fase {{ $currentPhase }}</h1>
        </div>

        <button id="prev-btn" type="button" class="absolute left-0 top-1/2 -translate-y-1/2 ml-2">
            <img src="{{ asset('assets/storyline/left.png') }}" class="h-6 w-6 md:h-10 md:w-10">
        </button>

        <div class="relative w-full h-[20rem] overflow-hidden pl-[20px]">
            <div class="h-full overflow-y-auto pr-[16px] pb-8  custom-scroll font-quicksand">
                <p id="storyline-text" class="text-[#03300f] font-bold text-justify text-sm md:text-lg leading-relaxed font-quicksand">
                    {{ $currentPhase->phase ?? 'Fase tidak ditemukan' }}
                </p>
            </div>
        </div>

        <button id="next-btn" type="button" class="absolute right-0 top-1/2 -translate-y-1/2 mr-2">
            <img src="{{ asset('assets/storyline/left.png') }}" class="h-6 w-6 md:h-10 md:w-10 rotate-180 ">
        </button>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function(){
    let currentPhase = {{ $currentPhase->phase }};
    let maxPhase = currentPhase;
    let storylines = @json($storylines);

    const titleElement = document.getElementById("fase-title");
    const textElement = document.getElementById("storyline-text");
    const prevButton = document.getElementById("prev-btn");
    const nextButton = document.getElementById("next-btn");

    function updateStoryline() {
        titleElement.textContent = "Fase " + currentPhase;
        textElement.textContent = storylines[currentPhase] || "Fase tidak ditemukan";
        prevButton.style.visibility = (currentPhase > 1) ? "visible" : "hidden";
        nextButton.style.visibility = (currentPhase < maxPhase) ? "visible" : "hidden";
    }

    prevButton.addEventListener("click", function(){
        if(currentPhase > 1){
            currentPhase--;
            updateStoryline();
        }
    });

    nextButton.addEventListener("click", function(){
        if(currentPhase < maxPhase){
            currentPhase++;
            updateStoryline();
        }
    });

    updateStoryline();
});

function openStorylineModal(){
    document.getElementById("storylineModal").classList.remove("hidden");
}

function closeModal(id){
    document.getElementById(id).classList.add("hidden");
}
</script>
