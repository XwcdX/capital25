<style>
    input:focus {
        border-color: #63006c !important;
        box-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color) !important;
    }

    body {
        overflow: hidden;
    }
</style>

@extends('user.layout')


@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                title: "SUCCESS!",
                text: "{{ session('success') }}",
                icon: "success",
                showConfirmButton: true,
                confirmButtonColor: "#56843a",
            });
        </script>
    @endif
    <main class="flex min-h-screen w-screen items-center justify-center bg-[var(--cap-green4)]">
        <form
            class="bg-gray-100 border-solid border-2 rounded-xl px-10 pb-10 pt-4 w-[75%] sm:w-[50%] md:w-[30%] mx-[20%] my-[20px] flex flex-col justify-center items-center"
            method="POST" action="{{ route('forget.password.post') }}">
            @csrf
            <img src="{{ asset('assets/logo_capital.png') }}" alt="Logo Capital"
                class="h-full max-h-28 w-auto mb-2 flex items-center justify-center">
            <input type="text" hidden name="role" value={{ $role }}>
            <div class="w-full">
                <label class="block mb-2" for="email">Email Address</label>
                <input class="border-solid border-radius-[2px] border-2 text-[16px] h-[35px] w-[100%] p-2" id="email"
                    name="email" type="email" placeholder="JohnDoe@gmail.com" required>
            </div>
            <button id="submitButton"
                class="bg-[var(--cap-green2)] hover:bg-[var(--cap-green3)] text-white text-sm font-bold mt-4 py-1.5 px-3 w-[100%] rounded-full"
                type="submit">Send Reset Password Request</button>
        </form>
    </main>
@endsection

@section('script')
@endsection
