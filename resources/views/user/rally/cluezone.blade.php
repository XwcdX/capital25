@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buy ClueZone Ticket</h1>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $currentPhaseInt = Cache::get("current_phase")->phase;
        switch($currentPhaseInt) {
            case 1:
                $ticketPrice = 1000;
                break;
            case 2:
                $ticketPrice = 2000;
                break;
            case 3:
                $ticketPrice = 4000;
                break;
            case 4:
                $ticketPrice = 8000;
                break;
            default:
                $ticketPrice = 0;
        }
    @endphp

    <p>Current Phase: {{ $currentPhaseInt }}</p>
    <p>Price per Ticket: {{ number_format($ticketPrice) }}</p>
    
    <form action="{{ route('cluezone.buy') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="quantity">Number of Tickets (max 4):</label>
            <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="4" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Buy Ticket(s)</button>
    </form>
</div>
@endsection
