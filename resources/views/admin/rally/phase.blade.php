@extends('admin.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-700">Manage Phase</h2>
        </div>
        <div class="p-6">
            <p class="mb-4 text-gray-600">
                Current Phase: 
                <span class="font-bold">
                    {{ is_object($currentPhase) ? $currentPhase->phase : $currentPhase }}
                </span>
            </p>
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
        </div>
    </div>
</div>
@endsection
