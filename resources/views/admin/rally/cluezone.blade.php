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

            @if ($teams)
                @foreach ($teams as $team)
                    <div class="team-container" data-team-name="{{ strtolower($team->name) }}">
                        <h2 class="text-lg font-bold">{{ $team->name }}</h2>
                        <h2>Current ticket quantity: {{$team->cluezone[0]->quantity - $team->cluezone[0]->claimed_tickets}}</h2>
                        
                        <form id="claim-form-{{ $team->id }}" class="claim-ticket-form">
                            @csrf
                            <input type="hidden" name="team_id" value="{{ $team->id }}">
                            <select name="claimed_tickets">
                                @for ($i = 1; $i <= $team->cluezone[0]->quantity - $team->cluezone[0]->claimed_tickets ; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="bg-sky-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-sky-800 transition duration-200">Claim</button>
                        </form>
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

            document.querySelectorAll('form[id^="claim-form-"]').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const selectedQuantity = this.querySelector('select[name="claimed_tickets"]').value;
                    const formData = new FormData(this);

                    Swal.fire({
                        title: 'Confirm Claim',
                        text: `Are you sure you want to claim ${selectedQuantity} ticket(s)?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, claim it!',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("{{ route('admin.clueZoneClaim')}}", {
                                method: "POST",
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message || 'Ticket successfully claimed!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            })
                            .catch(error => {
                                console.error(error);
                                Swal.fire('Error', error.message, 'error');
                            });
                        }
                    });
                });
            });   

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
        });
    </script>
@endsection
