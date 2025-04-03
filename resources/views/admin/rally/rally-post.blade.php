@extends('admin.layout')

@section('style')
@endsection

@section('content')
    <div class="container mx-auto mt-5">
        <div class="mb-4">
            <label for="rallyDropdown" class="block mb-2 text-sm font-medium text-gray-700">Select Rally:</label>
            <select id="rallyDropdown"
                class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:ring-blue-300">
                <option value="">-- Select a Rally --</option>
                @foreach ($rallies as $rally)
                    <option value="{{ $rally->id }}">{{ $rally->name }}</option>
                @endforeach
            </select>
        </div>

        <button id="openQrModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Generate Rally QR Code
        </button>

        <div id="teamsContainer">
            @foreach ($rallies as $rally)
                <div class="rally-teams hidden" data-rally-id="{{ $rally->id }}">
                    <h2 class="text-xl font-semibold">{{ $rally->name }}</h2>

                    @php
                        $groupedTeams = $rally->teams->groupBy('pivot.qr_expired_at');
                    @endphp

                    @foreach ($groupedTeams as $qrExpiredAt => $teams)
                        <div class="bg-gray-100 p-4 rounded my-4">
                            <h3 class="text-lg font-semibold">QR Expired At:
                                {{ \Carbon\Carbon::parse($qrExpiredAt)->format('Y-m-d H:i') }}</h3>
                            <ul class="list-disc pl-5 team-list">
                                @foreach ($teams as $team)
                                    <li id="team-{{ $team->id }}">{{ $team->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

    </div>

    <div id="qrCodeModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-[1036]">
        <div class="bg-white rounded-lg shadow-lg w-96">
            <div class="px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold">Rally QR Code</h2>
                <button id="closeQrModal" class="text-gray-400 hover:text-gray-600">
                    &times;
                </button>
            </div>
            <div class="p-4 text-center">
                <div id="loadingSpinner"
                    class="loader mx-auto my-4 border-t-4 border-blue-500 w-12 h-12 rounded-full animate-spin"></div>

                <div id="qrCodeContainer" class="hidden">
                    <img id="qrCodeImage" src="" alt="QR Code" class="mx-auto">
                </div>
            </div>
            <div class="px-4 py-2 border-t border-gray-200 text-right">
                <button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Close
                </button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let rallyChannel = null;
            const rallyDropdown = document.getElementById("rallyDropdown");
            const openQrModalButton = document.getElementById("openQrModal");
            const qrCodeModal = document.getElementById("qrCodeModal");
            const qrCodeContainer = document.getElementById("qrCodeContainer");
            const qrCodeImage = document.getElementById("qrCodeImage");
            const loadingSpinner = document.getElementById("loadingSpinner");
            const closeQrModalButton = document.getElementById("closeQrModal");
            const closeModalButton = document.getElementById("closeModalButton");

            let phaseId = {!! json_encode(optional($currentPhase)->id) !!};

            Echo.channel("phase-updates")
                .listen(".PhaseUpdated", (event) => {
                    phaseId = event.phase_id;

                    const selectedRallyId = rallyDropdown.value;
                    if (selectedRallyId) {
                        subscribeToRallyChannel(selectedRallyId);
                    }
                });

            function subscribeToRallyChannel(rallyId) {
                if (rallyChannel) {
                    Echo.leave(rallyChannel.name);
                }

                rallyChannel = Echo.channel(`rally.${rallyId}.phase.${phaseId}`);

                rallyChannel.stopListening(".rally.history.updated");

                rallyChannel.listen(".rally.history.updated", (event) => {
                    if (event.rallyHistory.length > 0) {
                        const newPhaseId = event.rallyHistory[0].pivot.phase_id;
                        if (phaseId !== newPhaseId) {
                            phaseId = newPhaseId;
                            localStorage.setItem("current_phase_id", newPhaseId);
                            subscribeToRallyChannel(rallyId);
                        }
                    }

                    const updatedTeamData = event.rallyHistory.map(history => ({
                        teamId: history.id,
                        teamName: history.name,
                        coin: history.coin,
                        rallyId: history.pivot.rally_id
                    }));

                    updateTeamData(updatedTeamData);
                    Swal.fire({
                        title: "Rally Updated",
                        text: "New rally data received.",
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                });
            }


            function updateTeamData(updatedTeams) {
                console.log(updatedTeams);

                updatedTeams.forEach(team => {
                    let teamElement = document.querySelector(`#team-${team.teamId}`);

                    if (!teamElement) {
                        const rallyContainer = document.querySelector(`[data-rally-id="${team.rallyId}"]`);
                        if (!rallyContainer) return;

                        let teamList = rallyContainer.querySelector(".team-list");
                        if (!teamList) {
                            teamList = document.createElement("ul");
                            teamList.classList.add("list-disc", "pl-5", "team-list");
                            rallyContainer.appendChild(teamList);
                        }

                        teamElement = document.createElement("li");
                        teamElement.id = `team-${team.teamId}`;
                        teamList.appendChild(teamElement);
                    }

                    teamElement.textContent = `${team.teamName} - Score: ${team.coin}`;
                });
            }



            rallyDropdown.addEventListener("change", (event) => {
                const rallyId = event.target.value;
                document.querySelectorAll(".rally-teams").forEach((el) => {
                    el.classList.add("hidden");
                });
                const selectedRallyTeams = document.querySelector(`[data-rally-id="${rallyId}"]`);
                if (selectedRallyTeams) selectedRallyTeams.classList.remove("hidden");

                if (rallyId !== "") {
                    const firstOption = rallyDropdown.querySelector("option:first-child");
                    if (firstOption && firstOption.value === "") {
                        firstOption.remove();
                    }
                    subscribeToRallyChannel(rallyId);
                }
            });

            openQrModalButton.addEventListener("click", () => {
                const rallyId = rallyDropdown.value;

                if (rallyId === "") {
                    Swal.fire({
                        title: "No Rally Selected",
                        text: "Please choose a rally first.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                qrCodeModal.classList.remove("hidden");
                qrCodeContainer.classList.add("hidden");
                loadingSpinner.classList.remove("hidden");

                fetch(`{{ route('admin.generateQR', ':rallyId') }}`.replace(':rallyId', rallyId))
                    .then(response => response.text())
                    .then(data => {
                        qrCodeImage.src = `data:image/svg+xml;base64,${btoa(data)}`;
                        qrCodeContainer.classList.remove("hidden");
                        loadingSpinner.classList.add("hidden");
                    })
                    .catch(error => {
                        console.error("Error fetching QR code:", error);
                        Swal.fire({
                            title: "QR Code Error",
                            text: "Failed to generate QR code.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        qrCodeModal.classList.add("hidden");
                    });
            });

            const closeModal = () => qrCodeModal.classList.add("hidden");
            closeQrModalButton.addEventListener("click", closeModal);
            closeModalButton.addEventListener("click", closeModal);
        });
    </script>
@endsection
