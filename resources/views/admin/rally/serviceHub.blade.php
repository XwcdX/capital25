@extends('admin.layout')

@section('style')
    <style>
        .team-container {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .team-container h2 {
            margin-bottom: 10px;
        }

        .team-container select {
            margin-right: 10px;
        }

        #team-search-container {
            margin-bottom: 20px;
        }

        #team-search-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-right: none;
            border-radius: 5px 0 0 5px;
            outline: none;
        }

        #team-search-button {
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-left: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border-radius: 0 5px 5px 0;
        }
    </style>
@endsection

@section('content')
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
        <h1 class="text-center text-4xl uppercase font-bold mb-2">Service Hub</h1>
    </div>
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
        <div class="container px-8 py-8">
            <div id="team-search-container" class="flex items-center justify-center mb-8">
                <input id="team-search-input" type="search" placeholder="Search teams by name">
                <button id="team-search-button">Search</button>
            </div>

            @php
                $teams = json_decode($data);
            @endphp

            @if ($teams)
                @foreach ($teams as $team)
                    <div class="team-container" data-team-name="{{ strtolower($team->name) }}">
                        <h2>{{ $team->name }}</h2>
                        <label for="commodity-select-{{ $team->id }}">Select Commodity:</label>
                        <select id="commodity-select-{{ $team->id }}" class="commodity-select"
                            data-team-id="{{ $team->id }}">
                            <option value="">-- Choose a Commodity --</option>
                            @if (isset($team->commodities))
                                @foreach ($team->commodities as $commodity)
                                    <option value="{{ $commodity->id }}" data-price="{{ $commodity->price }}">
                                        {{ $commodity->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <button class="buy-commodity-button" data-team-id="{{ $team->id }}">Buy Commodity</button>
                    </div>
                @endforeach
            @else
                <p>No teams available.</p>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Echo.channel("phase-updates")
                .listen(".PhaseUpdated", (event) => {
                    Swal.fire({
                        title: 'New Phase Started!',
                        text: `Phase ${event.phase} is now started!`,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                });

            const searchInput = document.getElementById('team-search-input');
            const searchButton = document.getElementById('team-search-button');

            function filterTeams() {
                const query = searchInput.value.toLowerCase();
                document.querySelectorAll('.team-container').forEach(function(teamCard) {
                    const teamName = teamCard.getAttribute('data-team-name');
                    if (teamName.includes(query)) {
                        teamCard.style.display = "";
                    } else {
                        teamCard.style.display = "none";
                    }
                });
            }

            searchInput.addEventListener('input', filterTeams);
            searchButton.addEventListener('click', filterTeams);

            document.querySelectorAll('.buy-commodity-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const teamId = this.getAttribute('data-team-id');
                    const select = document.querySelector(
                        `select.commodity-select[data-team-id="${teamId}"]`);
                    const commodityId = select.value;

                    if (!commodityId) {
                        Swal.fire('Error', 'Please select a commodity.', 'error');
                        return;
                    }

                    Swal.fire({
                        title: 'Enter Quantity',
                        input: 'number',
                        inputAttributes: {
                            min: 1,
                            step: 1
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Next'
                    }).then((quantityResult) => {
                        if (quantityResult.isConfirmed && quantityResult.value) {
                            const quantity = parseInt(quantityResult.value);
                            if (quantity < 1) {
                                Swal.fire('Error', 'Quantity must be at least 1.', 'error');
                                return;
                            }

                            Swal.fire({
                                title: 'Are you sure?',
                                text: "This action cannot be undone.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, purchase it!',
                                cancelButtonText: 'Cancel'
                            }).then((confirmResult) => {
                                if (confirmResult.isConfirmed) {
                                    fetch("{{ route('admin.buyCommodity') }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                            },
                                            body: JSON.stringify({
                                                team_id: teamId,
                                                commodity_id: commodityId,
                                                quantity: quantity
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success == 0) {
                                                Swal.fire('Error', data.message,
                                                    'error');
                                            } else {
                                                Swal.fire('Success', data
                                                    .message, 'success');
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            Swal.fire('Error',
                                                'An error occurred while processing the request.',
                                                'error');
                                        });
                                }
                            });
                        }
                    });
                });
            });
        });
    </script>
@endsection
