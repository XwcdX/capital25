@extends('user.layout')

@section('style')
    <style>
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
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            position: relative;
            width: 90%;
            max-width: 800px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            text-align: center;
        }

        /* Styling peta dan ikon */
        .map-container {
            text-align: center;
            position: relative;
        }

        .map-image {
            width: 100%;
            max-width: 600px;
            border-radius: 10px;
            display: block;
            margin: 0 auto;
        }

        .map-icon {
            position: absolute;
            width: 40px;
            height: 40px;
            transform: translate(-50%, -50%);
        }

        .black-icon {
            filter: grayscale(100%);
        }

        .carousel-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            width: 100%;
        }

        .carousel-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            min-width: 80px;
        }

        .carousel-btn.hidden {
            visibility: hidden;
        }

        .phase-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
    <div id="mapModal" class="modal">
        <div class="modal-content">
            <h2 class="phase-title" id="phaseTitle">Phase {{ $currentPhase->phase }}</h2>

            <div id="mapCarousel">
                @foreach ($phases as $phase)
                    <div class="carousel-slide {{ $phase->id == $currentPhase->id ? 'active' : '' }}"
                        data-phase="{{ $phase->phase }}" data-phase-id="{{ $phase->id }}"
                        style="{{ $phase->id == $currentPhase->id ? 'display:block;' : 'display:none;' }}">

                        <img src="{{ asset('assets/map/map.png') }}" alt="Map for Phase {{ $phase->phase }}"
                            class="map-image">

                        @foreach ($rallies as $rally)
                            @php
                                $isVisited = in_array($rally->id, $visitedRalliesByPhase[$phase->id] ?? []);
                                $iconName = strtolower(str_replace(' ', '_', $rally->name)) . '.png';
                            @endphp
                            <div class="map-icon"
                                style="left: {{ $rallyPositions[$rally->name]['x'] ?? 50 }}%; top: {{ $rallyPositions[$rally->name]['y'] ?? 50 }}%;">
                                <img src="{{ asset($isVisited ? 'assets/map/color/' . $iconName : 'assets/map/black/' . $iconName) }}"
                                    alt="{{ $rally->name }}" class="{{ $isVisited ? '' : 'black-icon' }}">
                            </div>
                        @endforeach
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
                phaseTitle.innerText = "Phase " + (currentPhaseIndex + 1);

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
    </script>
@endsection
