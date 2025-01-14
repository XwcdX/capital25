@extends('admin.layout')

@section('content')
        <div class="flex flex-col w-full py-4 shadow-md items-center justify-center mb-5">
            <h1 class="text-center text-4xl uppercase font-bold mb-2">Dashboard</h1>
        </div>
        <div class="m-2">
            <div class=" flex">
                <h1 class="font-bold text-xl">Welcome</h1>
                <h1 class="font-bold text-xl uppercase">, {{ $admin->name }}</h1>
            </div>
            <div>
                <h1 class=" text-gray-400 font-bold text-sm">Panitia Divisi {{ $admin->division->name }}</h1>
            </div>
        </div>
@endsection
