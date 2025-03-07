@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Manage Phase</h2>

    <p>Current Phase: <strong>{{ $currentPhase }}</strong></p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.updatePhase') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="phase_id" class="form-label">Select Phase:</label>
            <select id="phase_id" name="phase_id" class="form-control" required>
                @foreach(\App\Models\Phase::all() as $phase)
                    <option value="{{ $phase->id }}">{{ $phase->phase }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Phase</button>
    </form>
</div>
@endsection
