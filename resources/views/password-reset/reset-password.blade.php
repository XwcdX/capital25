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
                text: "{!! session('error') !!}",
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
        <form class="bg-gray-100 border-solid border-2 p-10 max-w-[80%] mx-[20%] my-[20px]" method="POST" action="{{ route('reset.password.post') }}">
            @csrf
            <input type="text" hidden name="token" value={{ $token }}> {{-- for saving token --}}
            <input type="text" hidden name="role" value={{ $role }}> {{-- for saving role --}}
            <div class="my-[2px]">
                <label class="block mb-2" for="password">New Password</label>
                <input id='pass1' class="border-solid border-radius-[2px] border-2 text-[16px] h-[35px] w-[100%] p-2" id="password" name="password" type="password" onkeyup="checkPassword()" placeholder="********">
            </div>
            <div class="my-[8px]">
                <label class="block mb-2" for="password_confirmation">Confirm New Password</label>
                <input id='pass2' class="border-solid border-radius-[2px] border-2 text-[16px] h-[35px] w-[100%] p-2" id="password_confirmation" name="password_confirmation" type="password" onkeyup="checkPassword()" placeholder="********">
            </div>
            <p id="warningMessage" class="text-red-600"></p>
            <p class="pt-[6px]">
                <b>Rule:</b>
                <ul>
                    <li class="list-disc">Password must include <b>atleast one</b> uppercase letter, one lowercase letter, one number, and one special character.</li>
                    <li class="list-disc">Password must be atleast 8 characters long.</li>
                </ul>
            </p>
                <button id="submitButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold mt-4 py-1.5 px-3 rounded" style="opacity: 0.5;" type="submit" disabled=true>Reset Password</button>
        </form>
    </main>
@endsection

@section('script')
@endsection

<script>
    function checkPassword(){
        const password = document.getElementById('pass1').value;
        const confirmedPassword = document.getElementById('pass2').value;
        const warningMessage = document.getElementById('warningMessage');
        let message = '';

        //check all conditions for pass1
        if(password.length < 8) {message = '* Must be 8 characters or longer';}
        else if(!(/[A-Z]/.test(password))) {message = '* Must have atleast one uppercase letter';}
        else if(!(/[a-z]/.test(password))) {message = '* Must have atleast one lowercase letter';}
        else if(!(/[0-9]/.test(password))) {message = '* Must have atleast one number';}
        else if(!(/[!@#$%^&*()_+{}\[\]:;"'<>,.?~\\/-]/.test(password))) {message = 'Must have atleast one special character';}
        else if(password !== confirmedPassword) {message = '* Passwords must be the same.';}
        
        submitButton = document.getElementById('submitButton');
        if(message){
            submitButton.disabled = true;
            submitButton.style.opacity = 0.5;
        }else{
            submitButton.disabled = false;
            submitButton.style.opacity = 1;
        }
        
        warningMessage.innerHTML = message;
    }
</script>