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
                <div class="rally-teams hidden" data-rally-id="{{ $rally->id }}" data-rally-post="{{ $rally->post }}">
                    <h2 class="text-xl font-semibold">{{ $rally->name }}</h2>
                    <div class="scan-count mb-2 font-medium text-gray-700">
                        Total Teams Scanned: <span id="scannedCount-{{ $rally->id }}">0</span>
                    </div>
                    <ul class="list-disc pl-5 team-list"></ul>
                </div>
            @endforeach
        </div>
    </div>

    <div id="qrCodeModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-[1036]">
        <div class="bg-white rounded-lg shadow-lg w-96">
            <div class="px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold">Rally QR Code</h2>
                <button id="closeQrModal" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <div class="p-4 text-center">
                <div id="loadingSpinner"
                    class="loader mx-auto my-4 border-t-4 border-blue-500 w-12 h-12 rounded-full animate-spin"></div>
                <div id="qrCodeContainer" class="hidden">
                    <img id="qrCodeImage" src="" alt="QR Code" class="mx-auto">
                </div>
            </div>
            <div class="px-4 py-2 border-t border-gray-200 text-right">
                <button id="closeModalButton"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Close</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var rewardMapping = @json($rewardMapping);

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

            let updatedTeamsGlobal = [];

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
                            subscribeToRallyChannel(rallyId);
                        }
                    }

                    const updatedTeamData = event.rallyHistory.map(history => ({
                        teamId: history.id,
                        teamName: history.name,
                        coin: history.coin,
                        qrExpiredAt: history.pivot.qr_expired_at,
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
                updatedTeamsGlobal = updatedTeams;
                renderTeams();
            }

            function renderTeams() {
                const rallyId = rallyDropdown.value;
                const rallyContainer = document.querySelector(`[data-rally-id="${rallyId}"]`);
                if (!rallyContainer) return;

                const scanCountElement = rallyContainer.querySelector(`#scannedCount-${rallyId}`);
                scanCountElement.textContent = updatedTeamsGlobal.length;

                const teamList = rallyContainer.querySelector(".team-list");
                teamList.innerHTML = '';
                const totalScanned = updatedTeamsGlobal.length;

                updatedTeamsGlobal.forEach(team => {
                    const li = document.createElement("li");
                    li.id = `team-${team.teamId}`;

                    const teamLabel = document.createElement("span");
                    teamLabel.textContent = team.teamName + " - Rank: ";
                    li.appendChild(teamLabel);

                    const rankSelect = document.createElement("select");
                    rankSelect.dataset.teamId = team.teamId;
                    rankSelect.className = "rank-select border ml-2";
                    const defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.textContent = "-- Select Rank --";
                    rankSelect.appendChild(defaultOption);

                    for (let i = 1; i <= totalScanned; i++) {
                        const option = document.createElement("option");
                        option.value = i;
                        option.textContent = i;
                        rankSelect.appendChild(option);
                    }
                    li.appendChild(rankSelect);
                    teamList.appendChild(li);

                    rankSelect.addEventListener("change", function() {
                        handleRankChange(team.teamId, this.value);
                    });
                });
            }

            function getTeamCommodity(teamId) {
                return fetch("{{ route('admin.getTeamCommodity') }}?team_id=" + teamId + "&phase_id=" + phaseId)
                    .then(response => response.json())
                    .then(resp => {
                        if (!resp.success) {
                            throw new Error(resp.message || "Error fetching commodity data");
                        }
                        return resp.data;
                    });
            }

            function handleRankChange(teamId, selectedRank) {
                const rallyId = rallyDropdown.value;
                const rallyContainer = document.querySelector(`[data-rally-id="${rallyId}"]`);
                const rallyPost = rallyContainer.dataset.rallyPost;
                let rewardValue = 0;
                if (rewardMapping[rallyPost] && rewardMapping[rallyPost].reward[selectedRank - 1]) {
                    rewardValue = rewardMapping[rallyPost].reward[selectedRank - 1];
                }

                getTeamCommodity(teamId).then(commodities => {
                    let htmlContent = `
                        <div>
                            <strong>Total Reward for this Rank: ${rewardValue}</strong>
                        </div>
                        <div>
                            <strong>Remaining Reward: </strong><span id="remainingReward">${rewardValue}</span>
                        </div>
                        <hr>
                    `;

                    commodities.forEach(commodity => {
                        htmlContent += `
                        <div class="commodity-row" data-commodity-id="${commodity.id}" style="margin-bottom:1em; border-bottom:1px solid #ccc; padding-bottom:0.5em;">
                            <div><strong>Commodity:</strong> ${commodity.name}</div>
                            <div><strong>Price:</strong> ${commodity.price}</div>
                            <div><strong>Return Rate:</strong> ${(commodity.return_rate * 100).toFixed(2)}%</div>
                            <div><strong>Quantity:</strong> ${commodity.quantity}</div>
                            <div>
                                <label>Allocated Reward:</label>
                                <input type="number" id="allocatedReward-${commodity.id}" class="swal2-input allocated-reward" placeholder="Enter allocation amount" value="0">
                            </div>
                        </div>
                        `;
                    });

                    Swal.fire({
                        title: 'Allocate Reward',
                        html: htmlContent,
                        focusConfirm: false,
                        showCancelButton: true,
                        confirmButtonText: 'Save',
                        preConfirm: () => {
                            let totalAllocated = 0;
                            const allocationData = [];
                            const inputs = Swal.getPopup().querySelectorAll(
                            '.allocated-reward');
                            inputs.forEach(input => {
                                const value = parseFloat(input.value) || 0;
                                totalAllocated += value;
                                const commodityId = input.id.replace('allocatedReward-',
                                    '');
                                allocationData.push({
                                    commodityId: commodityId,
                                    allocated: value
                                });
                            });
                            if (totalAllocated !== rewardValue) {
                                Swal.showValidationMessage(
                                    `Total allocated reward (${totalAllocated}) must equal ${rewardValue}`
                                    );
                            }
                            return allocationData;
                        },
                        didOpen: () => {
                            const inputs = Swal.getPopup().querySelectorAll(
                            '.allocated-reward');
                            inputs.forEach(input => {
                                input.addEventListener('input', () => {
                                    let total = 0;
                                    inputs.forEach(inp => {
                                        total += parseFloat(inp
                                            .value) || 0;
                                    });
                                    const remaining = rewardValue - total;
                                    Swal.getPopup().querySelector(
                                            '#remainingReward').textContent =
                                        remaining;
                                });
                            });
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const allocationData = result
                            .value;
                            const updatePromises = [];
                            allocationData.forEach(allocation => {
                                if (allocation.allocated > 0) {
                                    const commodity = commodities.find(c => c.id ===
                                        allocation.commodityId);
                                    if (commodity) {
                                        const computedReward = allocation.allocated * (
                                                commodity.price * commodity.return_rate) *
                                            commodity.quantity;
                                        updatePromises.push(
                                            updateBalanceForTeam({
                                                team_id: teamId,
                                                transaction_type: 'coin',
                                                action: 'credit',
                                                amount: computedReward,
                                                commodity_id: commodity.id,
                                                quantity: allocation.allocated,
                                                description: `Rank ${selectedRank} with ${allocation.allocated} reward on ${commodity.name}`
                                            })
                                        );
                                    }
                                }
                            });
                            if (updatePromises.length > 0) {
                                Promise.all(updatePromises)
                                    .then(() => {
                                        Swal.fire({
                                            title: 'Success',
                                            text: 'Reward allocated successfully.',
                                            icon: 'success'
                                        });
                                    })
                                    .catch(() => {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'An error occurred while updating balance.',
                                            icon: 'error'
                                        });
                                    });
                            } else {
                                Swal.fire({
                                    title: 'Info',
                                    text: 'No allocation was made.',
                                    icon: 'info'
                                });
                            }
                        }
                    });
                }).catch(error => {
                    console.error("Error fetching commodity data", error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to fetch commodity data.',
                        icon: 'error'
                    });
                });
            }

            function updateBalanceForTeam(data) {
                return fetch("{{ route('admin.updateBalance') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json());
            }

            rallyDropdown.addEventListener("change", (event) => {
                const rallyId = event.target.value;
                document.querySelectorAll(".rally-teams").forEach(el => el.classList.add("hidden"));
                const selectedRallyTeams = document.querySelector(`[data-rally-id="${rallyId}"]`);
                if (selectedRallyTeams) selectedRallyTeams.classList.remove("hidden");

                if (rallyId !== "") {
                    const firstOption = rallyDropdown.querySelector("option:first-child");
                    if (firstOption && firstOption.value === "") firstOption.remove();
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
                const selectedRallyTeams = document.querySelector(`[data-rally-id="${rallyId}"]`);
                const teamList = selectedRallyTeams.querySelector(".team-list");
                if (teamList) teamList.innerHTML = '';

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
