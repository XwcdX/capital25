@extends('user.layout')

@section('content')
    <style>
        .container {
            max-width: 100vw;
            overflow: hidden;
        }

        .form-box {
            z-index: 1;
            transition: .6s ease-in-out 1.2s, visibility 0s 1s;
        }

        .form-box.registration {
            display: none;
        }

        .form-box.login {
            display: flex;
        }

        .container.active .form-box {
            right: 50%;
        }

        .toggle-box::before {
            content: '';
            position: absolute;
            width: 300%;
            height: 100%;
            left: -250%;
            background: url('{{ asset('assets/login.png') }}') no-repeat center center fixed, rgba(255, 255, 255, 0.3);
            background-size: cover;
            background-blend-mode: overlay;
            border-radius: 50px;
            z-index: 2;
            transition: 1.8s ease-in-out;
        }

        .toggle-panel {
            z-index: 2;
            transition: .6s ease-in-out;
        }

        .toggle-panel.toggle-left {
            left: 0;
            transition-delay: 1.2s;
        }

        .container.active .toggle-panel.toggle-left {
            left: -50%;
            transition-delay: .6s;
        }

        .toggle-panel.toggle-right {
            right: -50%;
            transition-delay: .6s;
        }

        .container.active .toggle-panel.toggle-right {
            right: 0;
            transition-delay: 1.2s;
        }

        .container.active .toggle-box::before {
            left: 50%;
        }


        @media screen and (max-width: 650px) {
            .form-box {
                bottom: 0;
                width: 100%;
                height: 70%;
            }

            .toggle-box::before {
                left: 0;
                width: 100%;
                height: 300%;
                top: -270%;
                border-radius: 15vw;
            }

            .toggle-panel {
                width: 100%;
                height: 30%;
            }

            .toggle-panel.toggle-left {
                top: 0;
            }

            .toggle-panel.toggle-right {
                right: 0;
                bottom: -30%;
            }

            .container.active .toggle-box::before {
                top: 70%;
                left: 0;
            }

            .container.active .form-box {
                right: 0;
                bottom: 30%;
            }

            .container.active .toggle-panel.toggle-left {
                left: 0;
                top: -30%;
            }

            .container.active .toggle-panel.toggle-right {
                bottom: 0;
            }
        }
    </style>

    <div class="flex justify-center items-center min-h-screen w-full">
        <div class="mx-auto cont relative w-[100%] h-[100%] bg-slate-700 flex justify-center items-center">
            <div class="container relative h-screen bg-[var(--cap-green2)] shadow-lg">
                <!-- Login Form -->
                <div
                    class="form-box login absolute right-0 w-[50%] h-full flex flex-col items-center justify-center text-black">
                    <form class="w-full px-8" id="manualLogin" action="{{ route('team.logins') }}" method="POST">
                        @csrf
                        <h1 class="text-[33px] min-[376px]:text-[39px] mb-4 lg:mb-6 text-black font-bold text-center">Hello, Ecopreneurs!</h1>
                        <div class="input-box relative w-full mb-4 lg:mb-6">
                            <input id="teamNameOrEmail" type="text" aria-label="Team Name or Email"
                                placeholder="Team Name/Email" required="" name="email"
                                value="{{ old('Team Name or Email') }}"
                                class="w-full pr-[50px] pl-5 py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[16px] placeholder-[#636161] placeholder:font-semibold">
                            <i
                                class="fa-solid fa-user absolute right-5 top-1/2 -translate-y-1/2 text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-4 lg:mb-6">
                            <input id="loginPassword" type="password" aria-label="Password" placeholder="Password"
                                required="" name="password" minlength="8"
                                class="w-full pr-[50px] pl-5 py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[16px] placeholder-[#636161] placeholder:font-semibold">
                            <i
                                class="fa-solid fa-lock absolute right-5 top-1/2 -translate-y-1/2 text-[20px] text-gray-400"></i>
                        </div>
                        <div class="mb-4 lg:mb-6 w-full text-end">
                            <a href="{{ route('forget.password', ['role'=>'team']) }}" class="text-[#6c6a66] text-md font-bold">Forgot Password?</a>
                        </div>
                        <div class="flex flex-col justify-center items-center">
                            <button type="submit"
                                class="w-full bg-emerald-800 text-white font-bold py-2 px-4 rounded-full hover:bg-emerald-900">Login</button>
                            {{-- <div class="text-center font-semibold my-2 lg:my-4 text-black">OR</div>
                            <button onclick="window.location.href=''"
                                class="w-full bg-[#7494ec] text-white font-bold py-2 px-4 rounded-full hover:bg-gray-400 p-[20px]">
                                <i class="fa-brands fa-google ml-"></i> Login with Email
                            </button> --}}
                        </div>
                    </form>
                </div>

                {{-- Registration Form --}}
                <div
                    class="form-box registration absolute right-0 w-[50%] h-full flex flex-col items-center justify-center text-black">
                    <form class="w-full px-8 grid gap-4 grid-cols-2" id="submitRegister">
                        @csrf
                        <h1 class="text-[33px] min-[376px]:text-[39px] mb-4 lg:mb-6 text-black font-bold text-center col-span-2">Register Here</h1>
                        <div class="input-box relative w-full mb-2 lg:mb-6">
                            <input type="text" aria-label="TeamName" placeholder="Team Name" required=""
                                id="name"
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] placeholder:font-semibold">
                            <i
                                class="fa-solid fa-user absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-2 lg:mb-6">
                            <input type="email" aria-label="Email" placeholder="Email" required="" id="email"
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] placeholder:font-semibold">
                            <i
                                class="fa-solid fa-envelope absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-2 lg:mb-6 col-span-2 lg:col-span-1">
                            <input type="text" aria-label="School" placeholder="School" required="" id="school"
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] placeholder:font-semibold">
                            <i
                                class="fa-solid fa-school absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-2 lg:mb-6 col-span-2 lg:col-span-1">
                            <input type="domicile" aria-label="Domicile" placeholder="Domicile" value="Surabaya-Jawa Timur" required=""
                                id="domicile"
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] placeholder:font-semibold">
                            <i
                                class="fa-solid fa-city absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-2 lg:mb-6 col-span-2">
                            <input type="password" aria-label="Password" placeholder="Password" required=""
                                id="password" minlength="8"
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] placeholder:font-semibold">
                            <i
                                class="fa-solid fa-lock absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-2 lg:mb-6 col-span-2">
                            <input type="password" aria-label="Confirm Password" placeholder="Confirm Password"
                                id="confirmPassword" minlength="8" required=""
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] placeholder:font-semibold">
                            <i
                                class="fa-solid fa-lock absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <button type="submit"
                            class="w-full bg-emerald-800 text-white font-bold py-2 px-4 rounded-full hover:bg-emerald-900 col-span-2">Register</button>
                    </form>
                </div>

                <div class="toggle-box absolute w-full h-full">
                    <div
                        class="toggle-panel toggle-left left-0 absolute w-[50%] h-[100%] flex flex-col justify-center items-center text-slate-900 text-center">

                        <h1 class="text-3xl min-[376px]:text-4xl font-extrabold">Start Your<br>Journey Now</h1>
                        <p class="my-[15px] min-[376px]:my-[20px] text-sm min-[376px]:text-base">If you don't have an account yet, join us now and help<br>create a greener,
                            better future for everyone!</p>
                        <button
                            class="btn register-btn w-[130px] min-[376px]:w-[160px] h-[39px] min-[376px]:h-[46px] text-sm min-[376px]:text-base bg-white border-2 border-white rounded-full">Register</button>
                    </div>
                    <div
                        class="toggle-panel toggle-right right-[-50%] absolute w-[50%] h-[100%] flex flex-col justify-center items-center text-slate-900 text-center">
                        <h1 class="text-3xl min-[376px]:text-4xl font-extrabold">Hello,<br>Ecopreneurs!</h1>
                        <p class="my-[15px] min-[376px]:my-[20px] text-sm min-[376px]:text-base">If you already have an account,<br>login here and have fun with us!</p>
                        <button
                            class="btn login-btn w-[130px] min-[376px]:w-[160px] h-[39px] min-[376px]:h-[46px] text-sm min-[376px]:text-base bg-white border-2 border-white rounded-full">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const container = document.querySelector('.container');
        const registerBtn = document.querySelector('.register-btn');
        const loginBtn = document.querySelector('.login-btn');
        const formBoxLogin = document.querySelector('.form-box.login');
        const formBoxRegistration = document.querySelector('.form-box.registration');

        const animationDuration = 1000;

        registerBtn.addEventListener('click', () => {
            container.classList.add('active');
            setTimeout(() => {
                formBoxLogin.style.display = 'none';
                formBoxRegistration.style.display = 'flex';
            }, animationDuration);
        });

        loginBtn.addEventListener('click', () => {
            container.classList.remove('active');
            setTimeout(() => {
                formBoxLogin.style.display = 'flex';
                formBoxRegistration.style.display = 'none';
            }, animationDuration);
        });

        const submitRegister = document.getElementById('submitRegister');
        submitRegister.addEventListener('submit', async function(event) {
            event.preventDefault();
            try {
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const school = document.getElementById('school').value;
                const domicile = document.getElementById('domicile').value;
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                if (password !== confirmPassword) {
                    Swal.fire({
                        title: 'Error',
                        text: "Passwords do not match!",
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                    return;
                }
                Swal.fire({
                    title: 'Processing your registration...',
                    text: 'Please wait while we send the verification email.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
                const response = await fetch("{{ route('team.regist') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name,
                        email,
                        school,
                        domicile,
                        password
                    }),
                });
                const data = await response.json();
                Swal.close();
                if (data.success) {
                    window.location.href = "{{ route('team.verification.notice') }}";
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Registration failed.',
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.',
                });
            }
        });
    </script>
@endsection
