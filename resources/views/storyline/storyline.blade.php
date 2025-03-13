@extends('user.layout')

@section('title', $title)

@section('content')

<div class="min-h-screen w-screen flex flex-col items-center px-4">

    <img src="{{ asset('assets/lifecycleHPDummy/dummyBG.jpeg') }}" class="absolute inset-0 w-full h-full object-cover">
    <h1 class="text-[#fffdf7] text-2xl md:text-4xl text-center pt-8 md:pt-16 font-bold">Storyline</h1>

    <div class ="bg-black bg-opacity-50 fixed min-h-screen w-screen justify-center items-center flex ">
    {{-- Main Box --}}
    <div class="relative rounded-3xl mt-4 bg-[#fffdf7] w-full max-w-lg md:max-w-3xl h-auto p-5 md:p-8 flex flex-col my-5">
        <div class=" mb-2 break-words">
        <h1 class="text-xl md:text-3xl text-center text-[#03300f] font-bold">Fase {{$currentPhase}}</h1>

        {{-- Tombol Previous --}}
        @if ($currentPhase > 1)
            <a href="{{ route('storyline.changePhase', $currentPhase - 1) }}" 
                class="absolute left-3 md:left-6 top-1/2 transform -translate-y-1/2">
                <img src="{{ asset('assets/storyline/left.png') }}" class="h-6 w-6 md:h-10 md:w-10">
            </a>
        @else
            <img src="{{ asset('assets/storyline/left.png') }}" class="hidden h-6 w-6 md:h-10 md:w-10 opacity-25 absolute left-3 md:left-6 top-1/2 transform -translate-y-1/2">
        @endif 

        {{-- Konten Storyline --}}
        <div class="w-full px-5 md:px-10 mt-3 md:mt-4">
            <p class="text-[#03300f] font-bold text-justify text-sm md:text-lg leading-relaxed">
                {{ $storylines[$currentPhase] ?? 'Fase tidak ditemukan'}}
            </p>
        </div>

        {{-- Tombol Next --}}
        @if ($currentPhase < $maxUnlockedPhase)
            <a href="{{ route('storyline.changePhase', $currentPhase + 1) }}" 
                class="absolute right-3 md:right-6 top-1/2 transform -translate-y-1/2">
                <img src="{{ asset('assets/storyline/left.png') }}" class="h-6 w-6 md:h-10 md:w-10 rotate-180">
            </a>
        @else
            <img src="{{ asset('assets/storyline/left.png') }}" class="hidden">
        @endif

        </div>
        
    </div>
    </div>
</div>

@endsection