@extends('admin.layout')

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

        <div class="flex space-x-2 mb-4">
            <button id="openQrModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Generate Rally QR Code
            </button>
            <button id="showCurrentQr" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Show Current QR
            </button>
        </div>

        @foreach ($rallies as $rally)
            <div id="current-qr-{{ $rally->id }}" class="hidden mb-4">
                @if ($rally->current_qr_link)
                    {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)->generate($rally->current_qr_link) !!}
                @else
                    <p class="text-sm text-gray-500">No QR code available for this rally.</p>
                @endif
            </div>
        @endforeach

        <div id="teamsContainer">
            @foreach ($rallies as $rally)
                <div class="rally-teams hidden" data-rally-id="{{ $rally->id }}" data-rally-post="{{ $rally->post }}"
                    data-rally-name="{{ $rally->name }}">
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
                <div id="qrCodeContainer" class="hidden flex justify-center items-center">
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
        const initialTeams = {
            @foreach ($rallies as $rally)
                "{{ $rally->id }}": {!! json_encode(
                    $rally->teams->map(
                        fn($team) => [
                            'teamId' => $team->id,
                            'teamName' => $team->name,
                            'coin' => $team->pivot->coin ?? null,
                            'qrExpiredAt' => $team->pivot->qr_expired_at,
                            'rallyId' => $rally->id,
                            'selectedRank' => null,
                            'locked' => false,
                        ],
                    ),
                ) !!},
            @endforeach
        };
    </script>

    <script>
        var rewardMapping = @json($rewardMapping);

        document.addEventListener("DOMContentLoaded", () => {
            let rallyChannel = null;
            const rallyDropdown = document.getElementById("rallyDropdown");
            const openQrModalButton = document.getElementById("openQrModal");
            const showCurrentQrButton = document.getElementById("showCurrentQr");
            const qrCodeModal = document.getElementById("qrCodeModal");
            const qrCodeContainer = document.getElementById("qrCodeContainer");
            const qrCodeImage = document.getElementById("qrCodeImage");
            const loadingSpinner = document.getElementById("loadingSpinner");
            const closeQrModalButton = document.getElementById("closeQrModal");
            const closeModalButton = document.getElementById("closeModalButton");

            let phase = {!! json_encode(optional($currentPhase)->phase) !!};
            let phaseId = {!! json_encode(optional($currentPhase)->id) !!};

            let updatedTeamsGlobal = [];



            function subscribeToRallyChannel(rallyId) {
                if (rallyChannel) {
                    Echo.leave(rallyChannel.name);
                }
                rallyChannel = Echo.channel(`rally.${rallyId}.phase.${phaseId}`);

                rallyChannel.stopListening(".rally.history.updated");
                rallyChannel.listen(".rally.history.updated", (event) => {
                    const updatedTeamData = event.rallyHistory.map(history => ({
                        teamId: history.id,
                        teamName: history.name,
                        coin: history.coin,
                        qrExpiredAt: history.pivot.qr_expired_at,
                        rallyId: history.pivot.rally_id,
                        selectedRank: null,
                        locked: false
                    }));

                    updatedTeamsGlobal = updatedTeamData;
                    renderTeams();

                    Swal.fire({
                        title: "Rally Updated",
                        text: "New rally data received.",
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                });
            }

            function renderTeams() {
                const rallyId = rallyDropdown.value;
                const rallyContainer = document.querySelector(`[data-rally-id="${rallyId}"]`);
                if (!rallyContainer) return;

                const rallyPost = rallyContainer.dataset.rallyPost;
                const scanCountElement = rallyContainer.querySelector(`#scannedCount-${rallyId}`);
                scanCountElement.textContent = updatedTeamsGlobal.length;

                const ul = rallyContainer.querySelector(".team-list");
                ul.innerHTML = '';
                const totalScanned = updatedTeamsGlobal.length;

                const bonusCoins = {
                    1: 500,
                    2: 1000,
                    3: 2000,
                    4: 4000
                };
                const amt = bonusCoins[phase] || 0;

                if (rallyPost === '9') {
                    updatedTeamsGlobal.forEach(team => {
                        const li = document.createElement('li');
                        li.className =
                            'mb-2 p-3 bg-white shadow rounded-lg flex justify-between items-center';
                        li.textContent = team.teamName;
                        ul.appendChild(li);
                    });

                    const btnLi = document.createElement('li');
                    btnLi.className = 'list-none mt-4';
                    const btn = document.createElement('button');
                    btn.textContent = `Distribute ${amt} Coins to Each Team`;
                    btn.className = 'bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow';
                    btn.addEventListener('click', () => {
                        if (!updatedTeamsGlobal.length) {
                            return Swal.fire('No teams to reward', '', 'info');
                        }
                        Swal.fire({
                            title: 'Confirm Distribution',
                            text: `This will credit each of the ${updatedTeamsGlobal.length} teams with ${amt} coins.`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, distribute'
                        }).then(res => {
                            if (!res.isConfirmed) return;
                            const promises = updatedTeamsGlobal.map(team =>
                                updateBalanceForTeam({
                                    team_id: team.teamId,
                                    transaction_type: 'coin',
                                    action: 'credit',
                                    amount: amt,
                                    description: `Bonus post in phase ${phase}`
                                })
                            );
                            Promise.all(promises)
                                .then(() => Swal.fire('Success', 'Coins distributed!', 'success'))
                                .catch(() => Swal.fire('Error', 'Failed to distribute coins.',
                                    'error'));
                        });
                    });
                    btnLi.appendChild(btn);
                    ul.appendChild(btnLi);
                    return;
                }

                updatedTeamsGlobal.forEach(team => {
                    const li = document.createElement("li");
                    li.id = `team-${team.teamId}`;
                    li.className = 'mb-4 p-4 bg-white shadow rounded-lg';

                    const teamLabel = document.createElement("span");
                    teamLabel.textContent = team.teamName + " - Rank: ";
                    teamLabel.className = 'font-medium text-gray-800';
                    li.appendChild(teamLabel);

                    const rankSelect = document.createElement("select");
                    rankSelect.dataset.teamId = team.teamId;
                    rankSelect.className =
                        'rank-select border border-gray-300 rounded px-2 py-1 ml-2 focus:outline-none focus:ring focus:ring-blue-200';

                    const defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.textContent = "-- Select Rank --";
                    rankSelect.appendChild(defaultOption);

                    const ranksSelectedByOthers = updatedTeamsGlobal
                        .filter(t => t.teamId !== team.teamId && t.selectedRank)
                        .map(t => t.selectedRank);

                    for (let i = 1; i <= totalScanned; i++) {
                        const option = document.createElement("option");
                        option.value = i;
                        option.textContent = i;
                        if (team.selectedRank == i) option.selected = true;
                        rankSelect.appendChild(option);
                    }
                    li.appendChild(rankSelect);
                    const deleteButton = document.createElement("button");
                    deleteButton.textContent = "Delete";
                    deleteButton.className = 'delete-btn ml-4 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-200';
                    
                    deleteButton.addEventListener("click", function() {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: `You are about to delete team ${team.teamName}. This action cannot be undone.`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                deleteItem(team.teamId, rallyId);
                                renderTeams();  
                            }
                        });
                    });

                    li.appendChild(deleteButton);
                    ul.appendChild(li);

                    if (!team.locked) {
                        rankSelect.addEventListener("change", function() {
                            const selectedValue = parseInt(this.value) || null;
                            const teamIndex = updatedTeamsGlobal.findIndex(t => t.teamId === team
                                .teamId);
                            if (teamIndex > -1) updatedTeamsGlobal[teamIndex].selectedRank =
                                selectedValue;
                            renderTeams();
                            handleRankChange(team.teamId, selectedValue);
                        });
                    }
                });
            }

            function deleteItem(teamId, rallyId) {
                const url = `{{ route('admin.deleteTeamRally', ['teamId' => ':teamId', 'rallyId' => ':rallyId']) }}`.replace(':teamId', teamId).replace(':rallyId', rallyId);
                
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        teamId: teamId,
                        rallyId: rallyId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: error.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
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
                    const groups = {};
                    commodities.forEach(c => {
                        if (!groups[c.id]) {
                            groups[c.id] = {
                                id: c.id,
                                name: c.name,
                                price: c.price,
                                records: []
                            };
                        }
                        groups[c.id].records.push({
                            quantity: c.quantity,
                            return_rate: c.return_rate
                        });
                    });

                    const optionsHtml = Object.values(groups)
                        .map(g => `<option value="${g.id}">${g.name}</option>`)
                        .join("");

                    let detailsHtml = "";
                    Object.values(groups).forEach(g => {
                        detailsHtml += `
                                <div style="margin-bottom:1em; border-bottom:1px solid #ccc; padding-bottom:0.5em;">
                                <div><strong>Commodity:</strong> ${g.name}</div>
                                <div><strong>Price:</strong> ${g.price}</div>
                            `;
                        g.records.forEach(r => {
                            detailsHtml += `
                            <div>
                                <strong>Quantity:</strong> ${r.quantity},
                                <strong>Return Rate:</strong> ${(r.return_rate * 100).toFixed(2)}%
                            </div>
                            `;
                        });
                        detailsHtml += `</div>`;
                    });

                    const htmlContent = `
                            <div><strong>Total Reward Units:</strong> ${rewardValue}</div>
                            <div style="margin-top:1em">
                                <label for="commoditySelect"><strong>Pick one commodity:</strong></label><br>
                                <select id="commoditySelect" class="swal2-input" style="text-align:left">
                                    ${optionsHtml}
                                </select>
                            </div>
                            <div style="margin-top:1em">
                                <label for="quantityInput"><strong>Enter quantity to allocate:</strong></label><br>
                                <input id="quantityInput" type="number" min="1" max="${rewardValue}" class="swal2-input w-24" placeholder="e.g., 1 - ${rewardValue}">
                            </div>
                            <hr>
                            <div style="margin-top:1em">
                                ${detailsHtml}
                            </div>`;

                    Swal.fire({
                        title: 'Allocate Entire Reward to One Commodity',
                        html: htmlContent,
                        focusConfirm: false,
                        showCancelButton: true,
                        confirmButtonText: 'Save',
                        didOpen: () => {
                            const sel = Swal.getPopup().querySelector('#commoditySelect');
                            const qtyInput = Swal.getPopup().querySelector('#quantityInput');

                            const updateMaxQty = () => {
                                const selectedGroup = groups[sel.value];
                                if (selectedGroup) {
                                    const totalQty = selectedGroup.records.reduce((sum,
                                        r) => sum + r.quantity, 0);
                                    qtyInput.max = totalQty;
                                    qtyInput.placeholder = `1 - ${totalQty}`;
                                }
                            };

                            sel.addEventListener('change', updateMaxQty);
                            updateMaxQty();
                        },
                        preConfirm: () => {
                            const sel = Swal.getPopup().querySelector('#commoditySelect');
                            const qtyInput = Swal.getPopup().querySelector('#quantityInput');
                            const quantity = parseInt(qtyInput.value);

                            if (!sel.value) {
                                Swal.showValidationMessage('Please select a commodity');
                            }
                            if (!qtyInput.value || quantity <= 0 || quantity > parseInt(qtyInput
                                    .max)) {
                                Swal.showValidationMessage(
                                    `Quantity must be between 1 and ${qtyInput.max}`);
                            }

                            return {
                                chosenId: sel.value,
                                quantity
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const {
                                chosenId,
                                quantity
                            } = result.value;
                            // // const chosenId = result.value;
                            const group = groups[chosenId];
                            const price = group.price;
                            const rallyName = rallyContainer.dataset.rallyName || 'Current Rally';

                            // const updatePromises = group.records.map(r => {
                            //     const computedReward = rewardValue * (price * r
                            //         .return_rate) * r.quantity;

                            //     const description =
                            //         `Rally "${rallyName}", Rank ${selectedRank}: ` +
                            //         `${rewardValue} reward(s) → ${group.name} @ ${ (r.return_rate*100).toFixed(2) }% (qty ${r.quantity}).`;

                            //     return updateBalanceForTeam({
                            //         team_id: teamId,
                            //         transaction_type: 'coin',
                            //         action: 'credit',
                            //         amount: computedReward,
                            //         commodity_id: chosenId,
                            //         quantity: rewardValue,
                            //         description
                            //     });
                            // });

                            let remainingQty = quantity;
                            const sortedRecords = [...group.records].sort((a, b) => b.return_rate -
                                a.return_rate);
                            const updatePromises = [];

                            for (const r of sortedRecords) {
                                if (remainingQty <= 0) break;

                                const usableQty = Math.min(remainingQty, r.quantity);
                                const computedReward = rewardValue * (price * r.return_rate) *
                                    usableQty;

                                const description = `Rally "${rallyName}", Rank ${selectedRank}: ` +
                                    `${rewardValue} reward(s) → ${group.name} @ ${(r.return_rate * 100).toFixed(2)}%`;

                                updatePromises.push(updateBalanceForTeam({
                                    team_id: teamId,
                                    transaction_type: 'coin',
                                    action: 'credit',
                                    amount: computedReward,
                                    commodity_id: chosenId,
                                    quantity: rewardValue,
                                    description
                                }));

                                const newQty = r.quantity - usableQty;
                                updatePromises.push(updateCommodityQuantity(r.return_rate, teamId,
                                    chosenId, newQty));

                                remainingQty -= usableQty;
                            }

                            if (updatePromises.length === 0) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Not enough available quantity for this commodity.',
                                    icon: 'error'
                                });
                                return;
                            }



                            Promise.all(updatePromises)
                                .then(() => {
                                    const idx = updatedTeamsGlobal.findIndex(t => t.teamId ===
                                        teamId);
                                    if (idx > -1) updatedTeamsGlobal[idx].locked = true;
                                    renderTeams();

                                    Swal.fire({
                                        title: 'Success',
                                        text: 'Reward allocated successfully.',
                                        icon: 'success'
                                    });
                                })
                                .catch(() => {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Failed to update balances.',
                                        icon: 'error'
                                    });
                                });
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

            function updateCommodityQuantity(return_rate, teamId, commodityId, newQty) {
                const updateUrl = "{{ route('admin.updateQuantity') }}";
                const url = updateUrl.replace('__ID__', commodityId);

                fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            return_rate: return_rate,
                            teamId: teamId,
                            commodityId: commodityId,
                            quantity: newQty,

                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: "Success!",
                                text: "Quantity Updated",
                                icon: "success",
                                confirmButtonText: "Continue"
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: "Error in updating quantity",
                                icon: "error",
                                confirmButtonText: "Continue"
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong!');
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

                if (!rallyId) return;
                updatedTeamsGlobal = initialTeams[rallyId] || [];
                renderTeams();
                subscribeToRallyChannel(rallyId);
                const firstOpt = rallyDropdown.querySelector("option:first-child[value='']");
                if (firstOpt) firstOpt.remove();
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
                updatedTeamsGlobal = [];
                const container = document.querySelector(`[data-rally-id="${rallyId}"]`);
                if (container) {
                    const countEl = container.querySelector(`#scannedCount-${rallyId}`);
                    if (countEl) countEl.textContent = '0';
                    const teamList = container.querySelector('.team-list');
                    if (teamList) teamList.innerHTML = '';
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

                        let currentDiv = document.getElementById(`current-qr-${rallyId}`);
                        if (currentDiv) {
                            currentDiv.innerHTML = data;
                        }
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

            showCurrentQrButton.addEventListener("click", () => {
                const rallyId = rallyDropdown.value;
                if (!rallyId) {
                    return Swal.fire({
                        title: "No Rally Selected",
                        text: "Please choose a rally first.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                }
                const qrDiv = document.getElementById(`current-qr-${rallyId}`);
                if (!qrDiv) {
                    return Swal.fire({
                        title: "No QR Code",
                        text: "There is no current QR code for this rally.",
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                }

                const svgElem = qrDiv.querySelector('svg');
                if (!svgElem) {
                    return Swal.fire({
                        title: "No QR Code",
                        text: "There is no current QR code for this rally.",
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                }
                const svgMarkup = new XMLSerializer().serializeToString(svgElem);
                qrCodeModal.classList.remove("hidden");
                loadingSpinner.classList.add("hidden");
                qrCodeContainer.classList.remove("hidden");
                qrCodeImage.src = `data:image/svg+xml;base64,${btoa(svgMarkup)}`;
            });

            const closeModal = () => qrCodeModal.classList.add("hidden");
            closeQrModalButton.addEventListener("click", closeModal);
            closeModalButton.addEventListener("click", closeModal);
        });
    </script>
@endsection
