@extends('admin.layout')

@section('content')
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
        <h1 class="text-center text-4xl uppercase font-bold mb-2">Investment Lab</h1>
    </div>

    <div class="container max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Convert Coin → Green Points</h1>

        <input type="text" id="team-search" placeholder="Search team…" class="w-full mb-4 px-3 py-2 border rounded" />

        <div class="overflow-x-auto">
            <ul id="team-list" class="min-w-[800px] space-y-2">
                <li class="flex justify-between items-center p-3 border-b bg-gray-100 sticky top-0 z-10" data-name='headerDataNameBruteForce'>
                    <span class="w-[25%] font-semibold">Name</span>
                    <span class="w-[25%] font-semibold">Green Point</span>
                    <span class="w-[25%] font-semibold">Coin</span>
                    <span class="w-[25%] text-center font-semibold">Action</span>
                </li>

                @foreach ($teams as $team)
                    <li class="flex justify-between items-center p-3 border rounded bg-white"
                        data-name="{{ Str::lower($team->name) }}">
                        <span class="w-[25%]">{{ $team->name }}</span>
                        <span class="w-[25%]">{{ $team->green_points }}</span>
                        <span class="w-[25%]">{{ $team->coin }}</span>
                        <button class="w-[25%] convert-btn bg-blue-600 text-white px-4 py-1 rounded"
                            data-id="{{ $team->id }}" data-name="{{ $team->name }}">
                            Convert
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const search = document.getElementById('team-search');

            const filterTeams = () => {
                const q = search.value.toLowerCase();
                document.querySelectorAll('#team-list li').forEach(li => {
                    li.style.display = (li.dataset.name.includes(q) || li.dataset.name.includes('headerDataNameBruteForce')) ? '' : 'none';
                });
            };

            search.addEventListener('keyup', () => {
                setTimeout(filterTeams, 0);
            });

            search.addEventListener('input', filterTeams);

            document.querySelectorAll('.convert-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const teamId = btn.dataset.id;
                    const teamName = btn.dataset.name;

                    Swal.fire({
                        title: `Convert coins for ${teamName}`,
                        input: 'number',
                        inputLabel: 'Amount of coins to convert',
                        inputAttributes: {
                            min: 0.01,
                            step: 0.01
                        },
                        showCancelButton: true,
                        cancelButtonColor: "#d33",
                        confirmButtonText: 'Convert',
                        preConfirm: amount => {
                            if (!amount || amount <= 0) {
                                Swal.showValidationMessage(
                                    'Please enter a valid amount');
                            }
                            return amount;
                        }
                    }).then(result => {
                        if (result.isConfirmed) {
                            fetch("{{ route('admin.team.convert') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        team_id: teamId,
                                        amount: result.value
                                    })
                                })
                                .then(r => r.json())
                                .then(json => {
                                    if (json.success) {
                                        Swal.fire('Success', json.message, 'success');
                                        window.location.reload();
                                    } else {
                                        Swal.fire('Error', json.message, 'error');
                                    }
                                })
                                .catch(() => {
                                    Swal.fire('Error', 'Server error', 'error');
                                });
                        }
                    });
                });
            });
        });
    </script>
@endsection
