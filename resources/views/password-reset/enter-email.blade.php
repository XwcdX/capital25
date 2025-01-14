<style>
    

    input:focus{
        border-color: #63006c !important;
        box-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color) !important;
    }

    #submitButton{
        background-color: #63006c !important; 
    }

    button:hover {
        background-color: rgb(134, 25, 143) !important;
    }
    body{
        overflow: hidden;
    }
</style>

@extends('user.layout')


@section('content')   
    @if (session('error'))
        <script>
            Swal.fire({
                title: "ERROR!",
                text: "{{ session('error') }}",
                icon: "error"
            });
        </script> 
    @elseif (session('success'))
        <script>
            Swal.fire({
                title: "SUCCESS!",
                text: "{{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif
    <main class="flex min-h-screen w-screen items-center justify-center">
        <form class="bg-gray-100 border-solid border-2 p-10 w-[75%] sm:w-[50%] md:w-[30%] mx-[20%] my-[20px]" method="POST" action="{{ route('forget.password.post') }}">
            @csrf
            <input type="text" hidden name="role" value={{ $role }}>
            <div>
                <label class="block mb-2" for="email">Email Address</label>
                <input class="border-solid border-radius-[2px] border-2 text-[16px] h-[35px] w-[100%] p-2" id="email" name="email" type="email" placeholder="JohnDoe@gmail.com" required>
            </div>
                <button id="submitButton" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold mt-4 py-1.5 px-3 w-[100%] rounded" type="submit">Send Reset Password Request</button>
        </form>
    </main>
@endsection

@section('script')
    
@endsection