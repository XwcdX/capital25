<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com/3.3.0"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <section class="w-screen flex justify-center items-center h-screen absolute">
        <div class="login-container w-[550px] h-[550px] max-sm:w-[320px] p-8 flex flex-col items-center justify-center">
            <div class="flex items-center justify-center w-full p-7 max-sm:pb-6">
                <h1 class="mix-blend-difference text-black font-bold text-5xl w-[400px] text-center max-sm:text-2xl">
                    ADMIN PAGE CAPITAL
                </h1>
            </div>
            <form action="{{ route('admin.logins') }}" method="POST"
                class="w-full p-7 max-sm:pb-6 flex flex-col items-center">
                @csrf
                <input class="mb-5 w-[400px] max-sm:w-full h-[55px] rounded-full border border-b-4 mx-auto"
                    type="text" placeholder="Email" name="email">
                <input class="w-[400px] max-sm:w-full h-[55px] rounded-full border border-b-4 mx-auto" type="password"
                    placeholder="Password" name="password">
                <a class="mt-[10px] text-center underline hover:text-slate-400"
                    href="{{ route('forget.password', ['role' => 'admin']) }}">forget password?</a>
                <button type="submit"
                    class="w-[400px] max-sm:w-full h-[55px] rounded-full border border-black text-black hover:text-white hover:bg-black mt-5">Login</button>
            </form>
        </div>
    </section>
</body>
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: "SUCCESS!",
            text: "{{ session('success') }}",
            showConfirmButton: true,
            confirmButtonColor: "#56843a",
        })
    </script>
@endif

</html>
