@extends('admin.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-700">Manage Phase</h2>
        </div>
        <div class="p-6">
            <div class="flex justify-between">
                <p class="mb-4 text-gray-600">
                Current Phase: 
                <span class="font-bold">
                    {{ is_object($currentPhase) ? $currentPhase->phase : $currentPhase }}
                </span>
                </p>
                <div class="flex items-center space-x-2">
                    <div class="text-xl font-bold" id="timer"></div>
                </div>
                
            </div>
            <div class="flex justify-between">
                <form action="{{ route('admin.updatePhase') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="phase_id" class="block text-gray-700 font-medium mb-2">
                            Select Phase:
                        </label>
                        <select id="phase_id" name="phase_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @foreach ($allPhases as $phase)
                                <option value="{{ $phase->id }}"
                                    @if(is_object($currentPhase) && $currentPhase->id == $phase->id) selected @endif>
                                    {{ $phase->phase }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150">
                        Update Phase
                    </button>
                </form>
                <form id="set-phase-time" action="{{ route('admin.spedUpPhase')}}" class="flex flex-col space-y-2">
                    @csrf
                    <div>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="end_time" id="end_time">
                        <label for="minutes">Minutes: </label>
                        <input id="minutes" name="minutes" type="number">
                    </div>
                    
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-150">
                        Speed Up Phase Time
                    </button>
                </form> 
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const currentPhase = @json($currentPhase);
    const phaseResumed = @json(Cache::get('phase_resumed'));
    let pauseDuration = null;
    document.addEventListener("DOMContentLoaded", function() {
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
                    localStorage.setItem("currentPhaseId", event.phase_id);
                    localStorage.setItem("currentPhase", event.phase);
                    localStorage.setItem("hasReducedReturnRates", "false");
                });
    });

    let countdownString = currentPhase === "No Phase Set" ? "00:00:00" : @json(is_object($currentPhase) ? $currentPhase->end_time : "00:00:00");
    
    const nowDate = new Date();
    const yyyy = nowDate.getFullYear();
    const mm = String(nowDate.getMonth() + 1).padStart(2, '0');
    const dd = String(nowDate.getDate()).padStart(2, '0');
    const [h, m, s] = countdownString.split(':').map(Number);

    const countdownTime = new Date(
        yyyy,
        nowDate.getMonth(),
        dd,
        h, m, s
    ).getTime();

    function updateCountdown() {
        let now = new Date().getTime();
        let timeLeft = countdownTime - now;
        
        if (timeLeft <= 0) {
            document.getElementById("timer").textContent = "Time's up!";
            return;
        }

        if (!phaseResumed && timeLeft <= 60 * 60 * 1000) {
            pauseDuration = (60 * 60 * 1000)-timeLeft;
            document.getElementById("timer").textContent = "01:00:00";
            return;
        }

        let hours = Math.floor((timeLeft / (1000 * 60 * 60)) % 24);
        let minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
        let seconds = Math.floor((timeLeft / 1000) % 60);
        document.getElementById("timer").textContent = `${hours}h ${minutes}m ${seconds}s`;
        setTimeout(updateCountdown, 1000);
    }

    updateCountdown();

    document.getElementById('set-phase-time').addEventListener("submit", function(e){
        e.preventDefault(); 
        
        const minutes = parseInt(document.getElementById('minutes').value);
        const countdown = currentPhase === "No Phase Set"
            ? "00:00:00"
            : @json(is_object($currentPhase) ? $currentPhase->end_time : "00:00:00");

        const [h, m, s] = countdown.split(':').map(Number);
        const now = new Date();
        const endTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), h, m, s);

        if (minutes < 0) {
            endTime.setTime(endTime.getTime() + pauseDuration);
        } else {
            endTime.setMinutes(endTime.getMinutes() - minutes);
        }

        const newH = String(endTime.getHours()).padStart(2, '0');
        const newM = String(endTime.getMinutes()).padStart(2, '0');
        const newS = String(endTime.getSeconds()).padStart(2, '0');
        const newTimeString = `${newH}:${newM}:${newS}`;

        Swal.fire({
            title: 'Change phase time?',
            text: `The phase time will be sped up to ${minutes} minute${minutes > 1 ? 's' : ''}.`,
            icon: 'question',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('end_time').value = newTimeString;
                let form = this;
                const formData = new FormData(form);

                fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Phase time has been updated.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'An unexpected error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            }
        });
    });
    
</script>
@endsection