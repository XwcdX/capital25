@extends('user.layout')

@section('style')
    <style>
        .landing-container {
             filter: blur(5px);
            transition: opacity 0.3s ease-in-out;
        }

        .modal {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            color: var(--cap-green);
        }

        .modal-content {
            position: relative;
            width: 80%;
            max-height: 700px;
            max-width: 850px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            padding: 15px;
            text-align: center;
        }

        .map-container {
            text-align: center;
            position: relative;
        }

        .map-image {
            height: 90%;
            /* max-width: 600px; */
            border-radius: 10px;
            display: block;
            margin: 0 auto;
        }

        .carousel-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            width: 100%;
        }

        .carousel-btn {
            background-color: var(--cap-green4);
            color: white;
            border: none;
            padding: 10px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            min-width: 80px;
            font-family: 'Quicksand';
        }

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

            .modal-content{
                max-width: 400px;
            }

            #rallyTooltip {
                font-size: 10px;
                padding: 4px 8px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="landing-container">
        @include('user.home-partials.landing')
    </div>
    <div id="mapModal" class="modal">
        <div class="modal-content">
            <h2 class="phase-title" id="phaseTitle">Fase {{ $currentPhase->phase }}</h2>

            <div id="mapCarousel">
                @foreach ($phases as $phase)
                    <div class="carousel-slide {{ $phase->id == $currentPhase->id ? 'active' : '' }}"
                        data-phase="{{ $phase->phase }}" data-phase-id="{{ $phase->id }}"
                        style="{{ $phase->id == $currentPhase->id ? 'display:block;' : 'display:none;' }}">

                        <div class="relative w-full mx-auto">
                            <!-- Map Image -->
                            <img src="{{ asset('assets/Icon pos map/Map/Map.png') }}"
                                alt="Map for Phase {{ $currentPhase->phase }}" class="w-full h-auto">

                            <!-- Extra Icons (Clue Zone & Basecamp) -->
                            @php
                                $rallyPositions = [
                                    'Pos 7' => ['x' => 2, 'y' => 8, 'name' => 'Recycling'],
                                    'Pos 1' => ['x' => 8, 'y' => 8, 'name' => 'Natural Resources '],
                                    'Pos 2' => ['x' => 14, 'y' => 8, 'name' => 'Raw Material Extraction'],
                                    'Pos 3' => ['x' => 20, 'y' => 8, 'name' => 'Production'],
                                    'Pos 4' => ['x' => 26, 'y' => 8, 'name' => 'Packing and Distribution'],
                                    'Pos 5' => ['x' => 62.5, 'y' => 8, 'name' => 'Use and Maintenance '],
                                    'Pos 6' => ['x' => 62.3, 'y' => 82, 'name' => 'Disposal'],
                                    'Pos 8' => ['x' => 68.3, 'y' => 82, 'name' => 'Waste Management'],
                                ];

                                $extraIcons = [
                                    'Clue Zone' => ['x' => 56, 'y' => 8, 'icon' => 'clue zone.png'],
                                    'Basecamp' => ['x' => 86.3, 'y' => 81.5, 'icon' => 'Basecamp.png'],
                                ];

                                $centralHub = [
                                    'Central Hub' => ['x' => 45, 'y' => 70, 'icon' => 'central hub.png'],
                                ];
                            @endphp

                            @foreach ($extraIcons as $name => $position)
                                <img src="{{ asset('assets/Icon pos map/' . $position['icon']) }}" alt="{{ $name }}"
                                    class="absolute rally-icon blinking-glow" data-name="{{ $name }}"
                                    style="width:6%; height:auto; top: {{ $position['y'] }}%; left: {{ $position['x'] }}%;">
                            @endforeach


                            <!-- Rally Position Icons -->
                            @foreach ($rallies as $rally)
                                @php
                                    $isVisited = in_array($rally->id, $visitedRalliesByPhase[$phase->id] ?? []);
                                    $iconName = $rally->name . ($isVisited ? '' : ' (2)') . '.png';
                                @endphp
                                <img src="{{ asset('assets/Icon pos map/' . $iconName) }}" alt="{{ $rally->name }}"
                                    data-name="{{ $rally->name }}&#10; {{ $rallyPositions[$rally->name]['name'] }}"
                                    class="absolute rally-icon"
                                    style="width:6%; height:auto; top: {{ $rallyPositions[$rally->name]['y'] ?? 50 }}%; left: {{ $rallyPositions[$rally->name]['x'] ?? 50 }}%;">
                            @endforeach

                            {{-- Central Hub --}}
                            @foreach ($centralHub as $name => $position)
                                <img src="{{ asset('assets/Icon pos map/' . $position['icon']) }}"
                                    alt="{{ $name }}" class="absolute rally-icon" data-name="{{ $name }}"
                                    style="top: {{ $position['y'] }}%; left: {{ $position['x'] }}%; width: 25%; height: auto; transform: translate(-50%, -50%);">
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="carousel-container">
                <button id="prevPhase" class="carousel-btn">Previous</button>
                <button id="nextPhase" class="carousel-btn">Next</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let currentPhaseIndex = {{ $phases->search(fn($phase) => $phase->id == $currentPhase->id) }};
            const totalPhases = {{ count($phases) }};
            const slides = document.querySelectorAll(".carousel-slide");
            const phaseTitle = document.getElementById("phaseTitle");

            const prevBtn = document.getElementById("prevPhase");
            const nextBtn = document.getElementById("nextPhase");

            function updatePhase(direction) {
                slides[currentPhaseIndex].style.display = "none";
                currentPhaseIndex = (currentPhaseIndex + direction + totalPhases) % totalPhases;
                slides[currentPhaseIndex].style.display = "block";
                phaseTitle.innerText = "Fase " + (currentPhaseIndex + 1);

                updateButtons();
            }

            function updateButtons() {
                prevBtn.style.visibility = currentPhaseIndex === 0 ? "hidden" : "visible";
                nextBtn.style.visibility = currentPhaseIndex === totalPhases - 1 ? "hidden" : "visible";
            }

            document.getElementById("nextPhase").addEventListener("click", () => updatePhase(1));
            document.getElementById("prevPhase").addEventListener("click", () => updatePhase(-1));

            document.getElementById("mapModal").style.display = "flex";

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
    </script>
@endsection
