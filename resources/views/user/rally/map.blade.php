
<style>
    /* .map-image {
        width: 100%;
            max-width: 600px;
            border-radius: 10px;
        display: block;
        margin: 0 60px;
    } */

    /* .carousel-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        width: 100%;
    } */

    /* .carousel-btn {
        background-color: var(--cap-green4) !important;
        color: white;
        position: absolute;
        top: 40%;
        z-index: 20;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        width: 6%;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease, transform 0.2s ease;
    } */
/* 
    .carousel-btn:hover {
        background-color: var(--cap-green3);
        transform: scale(1.1);
    } */
/* 
    .prev-btn {
        left: 10px;
    }

    .next-btn {
        right: 10px;
    } */

    @keyframes blinkGlow {
        0% {
            filter: drop-shadow(0 0 5px white);
        }
        50% {
            filter: drop-shadow(0 0 15px white);
        }
        /* Dimmer Glow */
        100% {
            filter: drop-shadow(0 0 5px white);
        }
        /* Back to Glow */
    }

    .blinking-glow {
        animation: blinkGlow 1s infinite alternate;
    }

    #rallyTooltip {
        font-family: 'Quicksand';
        font-size: 14px;
        padding: 6px 12px;
    }

    .carousel-btn.hidden {
        visibility: hidden;
    }

    .phase-title {
        font-family: 'Oxanium';
        src: url('/assets/fonts/oxanium.ttf') format('truetype');
        font-size: 2rem;
        font-weight: bold;
    }


    @media (max-width: 600px) {
        .phase-title {
            font-size: 1.5rem;
        }

        .modal-content {
            max-width: 400px;
        }

        .map-image {
            margin: 0 30px;
        }

        .relative {
            padding: 0 30px;
        }

        #rallyTooltip {
            font-size: 10px;
            padding: 4px 8px;
        }

        .prev-btn {
            left: 5px;
        }

        .next-btn {
            right: 5px;
        }
    }
</style>


<div id="overlay-map" class="hidden w-screen h-screen fixed inset-0 bg-black bg-opacity-50 z-[1001]">

<div id="mapModal" class="relative  flex items-center justify-center z-[1002]" onclick="event.stopPropagation()">
    <div class="bg-white w-[80%] max-w-[850px] max-h-[700px] rounded-lg shadow-xl p-4 text-center relative">
        <h2 class="text-2xl md:text-3xl font-bold font-['Oxanium'] mb-2 text-cap-green" id="phaseTitle">
            Fase {{ $currentPhase->phase }}
        </h2>

        <div id="mapCarousel">
            @foreach ($phases as $phase)
                <div class="carousel-slide {{ $phase->id == $currentPhase->id ? 'block' : 'hidden' }}"
                    data-phase="{{ $phase->phase }}" data-phase-id="{{ $phase->id }}">

                    <div class="relative w-full mx-auto px-8 md:px-16">
                        <!-- Prev Button -->
                        <button class="carousel-btn prev-btn absolute left-2 top-1/2 transform -translate-y-1/2 bg-[var(--cap-green4)] text-white rounded-full w-[6%] aspect-square flex items-center justify-center hover:bg-[var(--cap-green3)] hover:scale-110 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Map + Icons -->
                        <div class="text-center relative w-full mx-auto">
                            <img src="{{ asset('assets/Icon pos map/Map/Map.png') }}"
                                alt="Map for Phase {{ $currentPhase->phase }}"
                                class="w-full h-auto rounded-lg">

                            @php
                                $rallyPositions = [
                                    '7' => ['x' => 2, 'y' => 8, 'name' => 'Recycling'],
                                    '1' => ['x' => 8, 'y' => 8, 'name' => 'Natural Resources'],
                                    '2' => ['x' => 14, 'y' => 8, 'name' => 'Raw Material Extraction'],
                                    '3' => ['x' => 20, 'y' => 8, 'name' => 'Production'],
                                    '4' => ['x' => 26, 'y' => 8, 'name' => 'Packing and Distribution'],
                                    '5' => ['x' => 62.5, 'y' => 8, 'name' => 'Use and Maintenance '],
                                    '6' => ['x' => 62.3, 'y' => 82, 'name' => 'Disposal'],
                                    '8' => ['x' => 68.3, 'y' => 82, 'name' => 'Waste Management'],
                                ];

                                $extraIcons = [
                                    'Clue Zone' => ['x' => 56.5, 'y' => 8.2, 'icon' => 'clue zone.png'],
                                    'Basecamp' => ['x' => 86.5, 'y' => 81.7, 'icon' => 'Basecamp.png'],
                                ];

                                $centralHub = [
                                    'Central Hub' => ['x' => 45, 'y' => 70.3, 'icon' => 'central hub.png'],
                                ];
                            @endphp

                            @foreach ($extraIcons as $name => $position)
                                <img src="{{ asset('assets/Icon pos map/' . $position['icon']) }}" alt="{{ $name }}"
                                    class="absolute w-[5%] h-auto animate-pulse"
                                    data-name="{{ $name }}"
                                    style="top: {{ $position['y'] }}%; left: {{ $position['x'] }}%;">
                            @endforeach

                            <!-- Rally Position Icons -->
                            @foreach ($rallies as $rally)
                            @php
                                $isVisited = in_array($rally->id, $visitedRalliesByPhase[$phase->id] ?? []);
                                $iconName =  'Pos ' . $rally->post . ($isVisited ? '' : ' (2)') . '.png';
                            @endphp
                            <img src="{{ asset('assets/Icon pos map/' . $iconName) }}" alt="{{ $rally->name }}"
                                data-name="Post {{ $rally->post }}&#10; {{ $rallyPositions[$rally->post]['name'] }}"
                                class="absolute rally-icon"
                                style="width:6%; height:auto; top: {{ $rallyPositions[$rally->post]['y'] ?? 50 }}%; left: {{ $rallyPositions[$rally->post]['x'] ?? 50 }}%;">
                            @endforeach

                            @foreach ($centralHub as $name => $position)
                                <img src="{{ asset('assets/Icon pos map/' . $position['icon']) }}" alt="{{ $name }}"
                                    data-name="{{ $name }}"
                                    class="absolute w-[25%] h-auto"
                                    style="top: {{ $position['y'] }}%; left: {{ $position['x'] }}%; transform: translate(-50%, -50%);">
                            @endforeach
                        </div>

                        <!-- Next Button -->
                        <button class="carousel-btn next-btn absolute right-2 top-1/2 transform -translate-y-1/2 bg-[var(--cap-green4)] text-white rounded-full w-[6%] aspect-square flex items-center justify-center hover:bg-[var(--cap-green)] hover:scale-110 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const overlay = document.getElementById("overlay-map");
        const modal = document.getElementById("mapModal");

        overlay.addEventListener("click", function(event) {
            console.log("test");
            if (!modal.contains(event.target)) {
                closeModalOverlay('overlay-map');
            }
        });

        let maxActivePhase = @json($currentPhase->phase);            
        let currentPhaseIndex = {{ $phases->search(fn($phase) => $phase->id == $currentPhase->id) }};
        const totalPhases = {{ count($phases) }};
        const slides = document.querySelectorAll(".carousel-slide");
        const phaseTitle = document.getElementById("phaseTitle");

        function updatePhase(direction) {
            slides[currentPhaseIndex].classList.add("hidden");
            slides[currentPhaseIndex].classList.remove("block");

            currentPhaseIndex = (currentPhaseIndex + direction + totalPhases) % totalPhases;

            slides[currentPhaseIndex].classList.remove("hidden");
            slides[currentPhaseIndex].classList.add("block");

            phaseTitle.innerText = "Fase " + (currentPhaseIndex + 1);

            updateButtons();
        }

        function updateButtons() {
            const activeSlide = slides[currentPhaseIndex];
            const prevBtn = activeSlide.querySelector(".prev-btn");
            const nextBtn = activeSlide.querySelector(".next-btn");

            document.querySelectorAll(".prev-btn").forEach(btn => btn.style.visibility = "hidden");
            document.querySelectorAll(".next-btn").forEach(btn => btn.style.visibility = "hidden");

            if (currentPhaseIndex > 0) prevBtn.style.visibility = "visible";
            if (currentPhaseIndex < totalPhases - 1 && currentPhaseIndex < maxActivePhase - 1) nextBtn.style.visibility = "visible";


            prevBtn.onclick = () => updatePhase(-1);
            nextBtn.onclick = () => updatePhase(1);
        }

        // document.getElementById("mapModal").style.display = "flex";

        updateButtons();
    });

    document.addEventListener("DOMContentLoaded", function() {
        const rallyIcons = document.querySelectorAll(".rally-icon");

        rallyIcons.forEach(icon => {
            icon.addEventListener("click", function(event) {
                let tooltip = document.getElementById("rallyTooltip");
                if (!tooltip) {
                    tooltip = document.createElement("div");
                    tooltip.id = "rallyTooltip";
                    tooltip.style.position = "absolute";
                    tooltip.style.background = "rgba(0,0,0,0.8)";
                    tooltip.style.color = "white";
                    // tooltip.style.padding = "6px 12px";
                    tooltip.style.borderRadius = "5px";
                    // tooltip.style.fontSize = "14px";
                    tooltip.style.whiteSpace = "nowrap";
                    tooltip.style.textAlign = "center";
                    tooltip.style.fontWeight = "bold";
                    tooltip.style.zIndex = "1000";
                    document.body.appendChild(tooltip);
                }

                // Set tooltip text (rally name from data-name attribute)
                tooltip.innerText = this.getAttribute("data-name");

                // Position tooltip above the icon
                const rect = this.getBoundingClientRect();
                tooltip.style.top =
                    `${window.scrollY + rect.top + window.innerHeight * 0.04}px`;
                tooltip.style.left =
                    `${window.scrollX + rect.left + rect.width / 2 - tooltip.offsetWidth / 2}px`;

                // Remove tooltip after 2 seconds
                setTimeout(() => {
                    tooltip.remove();
                }, 2000);
            });
        });
        
    });

    function closeModalOverlay(id) {
        console.log('test')
        document.getElementById(id).classList.add('hidden');
        // document.getElementById(id).classList.add("hidden");
    }
</script>

