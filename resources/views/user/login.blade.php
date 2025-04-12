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
            <div class="container relative h-screen bg-[#DAD7CD] shadow-lg">
                <!-- Login Form -->
                <div
                    class="form-box login absolute right-0 w-[50%] h-full flex flex-col items-center justify-center text-black">
                    <form class="w-full px-8 font-quicksand" id="manualLogin" action="{{ route('team.logins') }}"
                        method="POST">
                        @csrf
                        <h1 class="text-[33px] min-[376px]:text-[39px] mb-4 lg:mb-6 text-black font-bold text-center">Hello,
                            Ecopreneurs!</h1>
                        <div class="input-box relative w-full mb-4 lg:mb-6">
                            <input id="teamNameOrEmail" type="text" aria-label="Team Name or Email"
                                placeholder="Team Name/Email" required="" name="email"
                                value="{{ old('Team Name or Email') }}"
                                class="w-full pr-[50px] pl-5 py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[16px] placeholder-[#636161] font-semibold">
                            <i
                                class="fa-solid fa-user absolute right-5 top-1/2 -translate-y-1/2 text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-4 lg:mb-6">
                            <input id="loginPassword" type="password" aria-label="Password" placeholder="Password"
                                required="" name="password" minlength="8"
                                class="w-full pr-[50px] pl-5 py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[16px] placeholder-[#636161] font-semibold">
                            <i
                                class="fa-solid fa-lock absolute right-5 top-1/2 -translate-y-1/2 text-[20px] text-gray-400"></i>
                        </div>
                        <div class="mb-4 lg:mb-6 w-full text-end">
                            <a href="{{ route('forget.password', ['role' => 'team']) }}"
                                class="text-[#6c6a66] text-md font-bold">Forgot Password?</a>
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
                    <form class="w-full px-8 grid gap-3 lg:gap-4 grid-cols-2 font-quicksand" id="submitRegister">
                        @csrf
                        <h1
                            class="text-[28px] lg:text-[33px] min-[376px]:text-[39px] mb-2 lg:mb-4 lg:mb-6 text-black font-bold text-center col-span-2">
                            Register Here</h1>
                        <div class="input-box relative w-full mb-2 lg:mb-6">
                            <input type="text" aria-label="TeamName" placeholder="Team Name" required=""
                                id="name"
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[6px] lg:py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] font-semibold"
                                onfocus="showTooltip()" onblur="hideTooltip()">
                            <div id="tooltip"
                                class="hidden absolute left-1 bottom-[110%] bg-gray-800 text-white text-xs rounded-lg py-2 px-3 w-72 shadow-lg transition-opacity duration-300"
                                style="white-space: normal;">
                                <b>Nama kelompok dilarang mengandung SARA, pornografi, politik, atau melanggar hukum dan
                                    norma.</b>
                            </div>
                            <i class="fa-solid fa-user absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400 cursor-pointer"
                                onmouseenter="showTooltip()" onmouseleave="hideTooltip()">
                            </i>
                        </div>
                        <div class="input-box relative w-full mb-2 lg:mb-6">
                            <input type="email" aria-label="Email" placeholder="Email" required="" id="email"
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[6px] lg:py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] font-semibold">
                            <i
                                class="fa-solid fa-envelope absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-2 lg:mb-6 col-span-2 lg:col-span-1">
                            <input type="text" aria-label="School" placeholder="School" required="" id="school"
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[6px] lg:py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] font-semibold">
                            <i
                                class="fa-solid fa-school absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-2 lg:mb-6 col-span-2 lg:col-span-1">
                            <input type="domicile" aria-label="Domicile" placeholder="Domicile" value="Surabaya-Jawa Timur"
                                required="" id="domicile"
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[6px] lg:py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] font-semibold">
                            <i
                                class="fa-solid fa-city absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-2 lg:mb-6 col-span-2">
                            <input type="password" aria-label="Password" placeholder="Password" required=""
                                id="password" minlength="8"
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[6px] lg:py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] font-semibold">
                            <i
                                class="fa-solid fa-lock absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <div class="input-box relative w-full mb-2 lg:mb-6 col-span-2">
                            <input type="password" aria-label="Confirm Password" placeholder="Confirm Password"
                                id="confirmPassword" minlength="8" required=""
                                class="w-full pr-[50px] pl-4 min-[376px]:pl-5 py-[6px] lg:py-[8px] min-[376px]:py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[14px] min-[376px]:text-[16px] placeholder-[#636161] font-semibold">
                            <i
                                class="fa-solid fa-lock absolute right-4 min-[376px]:right-5 top-1/2 -translate-y-1/2 text-[17px] min-[376px]:text-[20px] text-gray-400"></i>
                        </div>
                        <input type="file" id="hiddenPaymentProof" name="proof_of_payment"
                            accept="image/png, image/jpeg, application/pdf" class="hidden" />
                        <button type="button" id="paymentDetailsButton"
                            class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-full col-span-2">
                            Payment Details
                        </button>
                        <button type="submit"
                            class="w-full bg-emerald-800 text-white font-bold py-2 px-4 rounded-full hover:bg-emerald-900 col-span-2">Register</button>
                    </form>
                </div>

                <div class="toggle-box absolute w-full h-full font-quicksand">
                    <div
                        class="toggle-panel toggle-left left-0 absolute w-[50%] h-[100%] flex flex-col justify-center items-center text-slate-900 text-center">

                        <h1 class="text-3xl min-[376px]:text-4xl font-extrabold">Start Your<br>Journey Now</h1>
                        <p class="my-[15px] min-[376px]:my-[20px] text-sm min-[376px]:text-base">If you don't have an
                            account yet, join us now and help<br>create a greener,
                            better future for everyone!</p>
                        <button
                            class="btn register-btn w-[130px] min-[376px]:w-[160px] h-[39px] min-[376px]:h-[46px] text-sm min-[376px]:text-base bg-white border-2 border-white rounded-full">Register</button>
                    </div>
                    <div
                        class="toggle-panel toggle-right right-[-50%] absolute w-[50%] h-[100%] flex flex-col justify-center items-center text-slate-900 text-center">
                        <h1 class="text-3xl min-[376px]:text-4xl font-extrabold">Hello,<br>Ecopreneurs!</h1>
                        <p class="my-[15px] min-[376px]:my-[20px] text-sm min-[376px]:text-base">If you already have an
                            account,<br>login here and have fun with us!</p>
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
        document.getElementById('paymentDetailsButton').addEventListener('click', function() {
            Swal.fire({
                title: '<div class="text-center">Informasi Pembayaran</div>',
                html: `
                <div class="text-center">
                    <p class="font-bold">Jumlah Transfer: Rp150.000,00</p>
                    <p>Silahkan lakukan pembayaran ke:</p>
                    <p>Nomor Rekening BCA: 8292779282<br>Atas nama Pricilla Chealsea</p>
                    <p class="mt-4 font-bold">Ketentuan:</p>
                    <ol class="list-decimal text-left ml-6">
                    <li>Masukkan 'NAMA TIM_CAPITAL 2025' sebagai berita transfer.</li>
                    <li>Unggah bukti transfer (JPG, PNG) dengan drag & drop atau klik untuk upload.</li>
                    </ol>
                </div>
                <!-- Dropbox Container -->
                <div id="swal_drop_container" class="w-full justify-center items-center flex flex-col h-[200px] pb-[40px] pt-[20px]">
                    <div id="swal_drop_area" class="rounded-sm h-full w-[65%] flex items-center justify-center relative py-1 md:p-0 px-2 border border-dashed">
                    <label for="swalProofInput" class="h-full w-full font-return-grid text-[var(--cap-green5)] select-none cursor-pointer md:tracking-[1.25px] flex flex-col-reverse items-center justify-center font-serif">
                        <p id="swal_file_name" class="h-2/5 px-2 font-return-grid text-[#808080] leading-[20px] text-shadow-[0_0_10px_rgba(92,118,80,1)] select-none md:text-[18px]">
                        Drag & Drop your Image here or click to upload
                        </p>
                        <svg class="h-1/2 drop-shadow-[0_0_10px_rgba(92,118,80,1)]" fill="#808080" version="1.1" id="swal_drop_icon"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="38" height="38" viewBox="0 0 31.332 31.332" xml:space="preserve">
                        <g>
                            <path d="M23.047,15.266c0.781,0.781,0.781,2.047,0,2.828l-7.381,7.381l-7.379-7.379
                                    c-0.781-0.781-0.781-2.046,0-2.828
                                    c0.78-0.781,2.047-0.781,2.827,0l2.552,2.551V8.686
                                    c0-1.104,0.896-2,2-2c1.104,0,2,0.896,2,2v9.132l2.553-2.553
                                    C21,14.484,22.268,14.484,23.047,15.266z
                                    M31.332,15.666c0,8.639-7.027,15.666-15.666,15.666
                                    C7.026,31.332,0,24.305,0,15.666
                                    C0,7.028,7.026,0,15.666,0
                                    C24.307,0,31.332,7.028,31.332,15.666z
                                    M27.332,15.666C27.332,9.233,22.1,4,15.666,4
                                    C9.233,4,4,9.233,4,15.666
                                    C4,22.1,9.233,27.332,15.666,27.332
                                    C22.1,27.332,27.332,22.1,27.332,15.666z" />
                        </g>
                        </svg>
                    </label>
                    <input type="file" id="swalProofInput" accept="image/png, image/jpeg" class="hidden" />
                    </div>
                </div>
                <!-- Preview Container -->
                <div id="swal_proof_preview" class="hidden overflow-y-hidden flex items-center justify-center relative mb-5">
                    <img id="swal_proof_image" src="#" alt="Preview Bukti Transfer"
                        class="h-[130px] w-auto object-cover border rounded select-none cursor-pointer md:tracking-[1.25px]">
                    <span id="swal_remove_proof" class="absolute top-0 left-0 bg-red-500 text-white px-2 py-1 cursor-pointer rounded-full text-sm">&times;</span>
                </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Upload',
                confirmButtonColor: "#56843a",
                cancelButtonColor: "#d33",
                showCloseButton: true,
                focusConfirm: false,
                didOpen: () => {
                    const swalDropContainer = document.getElementById('swal_drop_container');
                    const swalDropArea = document.getElementById('swal_drop_area');
                    const swalProofInput = document.getElementById('swalProofInput');
                    const swalFileName = document.getElementById('swal_file_name');
                    const swalProofPreview = document.getElementById('swal_proof_preview');
                    const swalProofImage = document.getElementById('swal_proof_image');
                    const swalRemoveProof = document.getElementById('swal_remove_proof');

                    // swalDropArea.addEventListener('click', () => {
                    //     swalProofInput.click();
                    // });

                    swalDropArea.addEventListener('dragover', (event) => {
                        event.preventDefault();
                        swalDropArea.classList.add('dragover');
                    });

                    swalDropArea.addEventListener('dragleave', () => {
                        swalDropArea.classList.remove('dragover');
                    });

                    swalDropArea.addEventListener('drop', (event) => {
                        event.preventDefault();
                        swalDropArea.classList.remove('dragover');
                        const files = event.dataTransfer.files;
                        if (files.length > 0) {
                            swalProofInput.files = files;
                            previewSwalImage(files[0]);
                        }
                    });

                    swalProofInput.addEventListener('change', function() {
                        if (this.files && this.files[0]) {
                            previewSwalImage(this.files[0]);
                        }
                    });

                    swalRemoveProof.addEventListener('click', () => {
                        swalProofInput.value = '';
                        swalFileName.textContent =
                            "Drag & Drop your Image here or click to upload";
                        swalProofPreview.classList.add('hidden');
                        swalDropContainer.style.display = 'flex';
                    });

                    function previewSwalImage(file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            swalProofPreview.classList.remove('hidden');
                            swalProofImage.src = e.target.result;
                            swalFileName.textContent = file.name;
                            swalDropContainer.style.display = 'none';
                        };
                        reader.readAsDataURL(file);
                    }
                },
                preConfirm: () => {
                    const fileInput = document.getElementById('swalProofInput');
                    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                        Swal.showValidationMessage(`Please select a file`);
                        return false;
                    }
                    return fileInput.files[0];
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const file = result.value;
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('hiddenPaymentProof').files = dataTransfer.files;
                    Swal.fire({
                        title: 'Success!',
                        text: 'Proof of Payment uploaded successfully.',
                        icon: 'success',
                        showConfirmButton: true,
                        confirmButtonColor: "#56843a",
                    });
                }
            });
        });


        function showTooltip() {
            document.getElementById("tooltip").classList.remove("hidden");
        }

        function hideTooltip() {
            document.getElementById("tooltip").classList.add("hidden");
        }

        document.addEventListener("DOMContentLoaded", function() {
            const tooltip = document.getElementById("tooltip");
            tooltip.classList.remove("hidden");
            setTimeout(() => {
                tooltip.classList.add("hidden");
            }, 4000);
        });

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
                const proofOfPayment = document.getElementById('hiddenPaymentProof').files[0];

                if (!proofOfPayment) {
                    Swal.fire({
                        title: 'Error',
                        text: "Please upload proof of payment!",
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonColor: "#56843a",
                    });
                    return;
                }
                if (password !== confirmPassword) {
                    Swal.fire({
                        title: 'Error',
                        text: "Passwords do not match!",
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonColor: "#56843a",
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

                const formData = new FormData();
                formData.append('name', name);
                formData.append('email', email);
                formData.append('school', school);
                formData.append('domicile', domicile);
                formData.append('password', password);
                formData.append('proof_of_payment', proofOfPayment);

                const response = await fetch("{{ route('team.regist') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: formData,
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
                        showConfirmButton: true,
                        confirmButtonColor: "#56843a",
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.',
                    showConfirmButton: true,
                    confirmButtonColor: "#56843a",
                });
            }
        });
    </script>
@endsection
