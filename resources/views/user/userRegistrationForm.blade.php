@extends('user.layout')

@section('style')
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        i {
            font-size: 2.5em;
        }

        #proof_of_payment {
            display: none;
        }

        #drop_area {
            border: 2px dashed #000;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 1s ease;
        }

        #drop_area:hover {
            transform: scale(102%);
            box-shadow: 0px 0px 25px #2daa22;
        }

        #drop_area.dragover {
            background-color: rgba(0, 122, 204, 0.5);
        }

        .text-white {
            color: white !important;
        }
        @keyframes sway {
            0%, 100% {
                transform: rotate(0deg);
            }
            50% {
                transform: rotate(var(--sway-angle));
            }
        }

        .bush {
            animation: sway var(--sway-speed) ease-in-out infinite alternate;
        }


    </style>
@endsection

@section('content')
    {{-- @if (session('users') == [])
        @include('utils.welcome')
    @endif --}}
    <div
        class="relative lg:container flex justify-center bg-gradient-to-b from-[#316235] from-[30%] to-[#c9e3b0] mx-auto p-0 md:p-5 z-[-1] min-w-[100vw] overflow-hidden">
        <div
            class="relative z-[10] form-wrapper overflow-hidden sm:my-10 border rounded-xl bg-white/10 backdrop-blur-md shadow-lg border border-white/40 w-full lg:w-[60%]">
            <div class="form-container flex font-quicksand">
                @php
                    function ordinal($number)
                    {
                        $suffixes = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
                        if ($number % 100 >= 11 && $number % 100 <= 13) {
                            return 'th';
                        }
                        return $suffixes[$number % 10];
                    }
                    $firstEmptyIndex = null;
                @endphp
                @for ($i = 0; $i < 4; $i++)
                    @php
                        $user = session('users')[$i] ?? [];
                        if ($firstEmptyIndex === null && empty($user)) {
                            $firstEmptyIndex = $i;
                        }
                    @endphp
                    <div id="form-{{ $i + 1 }}" class="form-slide grid grid-cols-12 gap-2 p-12 w-full"
                        @if ($firstEmptyIndex === $i) data-first-empty="true" @endif>
                        <h2 class="text-4xl font-bold mb-4 col-span-12 text-white">
                            Team Profile ({{ $i === 0 ? 'Leader' : $i . ordinal($i) . ' Member' }})
                        </h2>
                        <input type="hidden" id="user{{ $i }}-id" name="user[{{ $i }}][id]"
                            value="{{ $user['id'] ?? '' }}">
                        <input type="hidden" id="user{{ $i }}-position"
                            name="user[{{ $i }}][position]" value="{{ $i }}">
                        <div class="col-span-12 sm:col-span-6">
                            <label for="user{{ $i }}-name" class="mb-2 text-white">Name:</label>
                            <input type="text" id="user{{ $i }}-name" name="user[{{ $i }}][name]"
                                value="{{ $user['name'] ?? '' }}"
                                class="mb-4 p-2 border-none rounded-xl w-full bg-[#BFBDBC]">
                        </div>

                        <div class="col-span-12 sm:col-span-6 relative h-[55px] mb-5">
                            <label for="user{{ $i }}-gender" class="mb-2 text-white">Gender:</label>
                            <select id="user{{ $i }}-gender" name="user[{{ $i }}][gender]"
                                class="mb-4 p-2 border-none rounded-xl w-full bg-[#BFBDBC] appearance-none pr-10 relative">
                                <option value="0"
                                    {{ isset($user['gender']) && $user['gender'] == '0' ? 'selected' : '' }}>Male
                                </option>
                                <option value="1"
                                    {{ isset($user['gender']) && $user['gender'] == '1' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                            <div class="absolute bottom-0 right-3 transform -translate-y-1/2 pointer-events-none">
                                <svg width="13" height="13" viewBox="0 0 69 60" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M64.2982 0.80514C67.4549 0.736127 69.4433 4.18018 67.8052 6.87942L36.9564 57.7117C35.379 60.311 31.593 60.2696 30.0728 57.6365L1.4751 8.10384C-0.0451357 5.47073 1.81203 2.17126 4.85177 2.1048L64.2982 0.80514Z"
                                        fill="rgb(0,0,0)" />
                                </svg>
                            </div>
                        </div>

                        <div class="col-span-12">
                            <label for="user{{ $i }}-phone" class="mb-2 text-white">Phone:</label>
                            <input type="number" id="user{{ $i }}-phone"
                                name="user[{{ $i }}][phone_number]" value="{{ $user['phone_number'] ?? '' }}"
                                class="mb-4 p-2 border-none  rounded-xl w-full bg-[#BFBDBC]">
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label for="user{{ $i }}-line" class="mb-2 text-white">Line ID:</label>
                            <input type="text" id="user{{ $i }}-line"
                                name="user[{{ $i }}][line_id]" value="{{ $user['line_id'] ?? '' }}"
                                class="mb-4 p-2 border-none  rounded-xl w-full bg-[#BFBDBC]">
                        </div>

                        <div class="col-span-12 sm:col-span-6 relative h-[55px] mb-5">
                            <label for="user{{ $i }}-consumption" class="mb-2 text-white">Consumption
                                Type:</label>
                            <select id="user{{ $i }}-consumption"
                                name="user[{{ $i }}][consumption_type]"
                                class="mb-4 p-2 border-none  rounded-xl w-full bg-[#BFBDBC] appearance-none pr-10">
                                <option value="0"
                                    {{ isset($user['consumption_type']) && $user['consumption_type'] == '0' ? 'selected' : '' }}>
                                    Normal</option>
                                <option value="1"
                                    {{ isset($user['consumption_type']) && $user['consumption_type'] == '1' ? 'selected' : '' }}>
                                    Vegetarian</option>
                                <option value="2"
                                    {{ isset($user['consumption_type']) && $user['consumption_type'] == '2' ? 'selected' : '' }}>
                                    Vegan</option>
                            </select>
                            <div class="absolute bottom-0 right-3 transform -translate-y-1/2 pointer-events-none">
                                <svg width="13" height="13" viewBox="0 0 69 60" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M64.2982 0.80514C67.4549 0.736127 69.4433 4.18018 67.8052 6.87942L36.9564 57.7117C35.379 60.311 31.593 60.2696 30.0728 57.6365L1.4751 8.10384C-0.0451357 5.47073 1.81203 2.17126 4.85177 2.1048L64.2982 0.80514Z"
                                        fill="rgb(0,0,0)" />
                                </svg>
                            </div>
                        </div>

                        <div class="col-span-12">
                            <label for="user{{ $i }}-food-allergy" class="mb-2 text-white">Food Allergy:</label>
                            <textarea id="user{{ $i }}-food-allergy" name="user[{{ $i }}][food_allergy]"
                                class="mb-4 p-2 border-none  rounded-xl w-full bg-[#BFBDBC] resize-none">{{ $user['food_allergy'] ?? '-' }}</textarea>
                        </div>

                        <div class="col-span-12">
                            <label for="user{{ $i }}-drug-allergy" class="mb-2 text-white">Drug Allergy:</label>
                            <textarea id="user{{ $i }}-drug-allergy" name="user[{{ $i }}][drug_allergy]"
                                class="mb-4 p-2 border-none  rounded-xl w-full bg-[#BFBDBC] resize-none">{{ $user['drug_allergy'] ?? '-' }}</textarea>
                        </div>

                        <div class="col-span-12">
                            <label for="user{{ $i }}-medical-history" class="mb-2 text-white">Medical
                                History:</label>
                            <textarea id="user{{ $i }}-medical-history" name="user[{{ $i }}][medical_history]"
                                class="mb-4 p-2 border-none  rounded-xl w-full bg-[#BFBDBC] resize-none">{{ $user['medical_history'] ?? '-' }}</textarea>
                        </div>

                        @foreach (['student_card', 'twibbon'] as $field)
                            <div class="col-span-12 mb-2">
                                <label for="user{{ $i }}-{{ $field }}" class="text-white">
                                    {{ ucfirst(str_replace('_', ' ', $field)) }}:
                                </label>

                                @php
                                    $hasFile = !empty($user[$field]);
                                @endphp

                                @if ($hasFile)
                                    <div class="mb-4 relative">
                                        <img id="preview-existing-{{ $field }}-{{ $i }}"
                                            src="{{ asset($user[$field]) }}" alt="{{ ucfirst($field) }}"
                                            class="h-[130px] w-auto rounded">
                                        <span id="remove-existing-{{ $field }}-{{ $i }}"
                                            onclick="removeExistingImage({{ $i }}, '{{ $field }}')"
                                            class="absolute top-0 left-0 bg-red-500 text-white px-2 py-1 cursor-pointer rounded-full text-sm">
                                            &times;
                                        </span>
                                    </div>
                                @endif

                                <div id="upload-container-{{ $field }}-{{ $i }}"
                                    class="{{ $hasFile ? 'hidden' : '' }}">
                                    <div class="relative">
                                        <img id="preview-upload-{{ $field }}-{{ $i }}" src="#"
                                            alt="Preview" class="h-[130px] w-auto rounded hidden">
                                        <span id="remove-upload-{{ $field }}-{{ $i }}"
                                            onclick="removeUploadedImage({{ $i }}, '{{ $field }}')"
                                            class="absolute top-0 left-0 bg-red-500 text-white px-2 py-1 cursor-pointer rounded-full text-sm hidden">
                                            &times;
                                        </span>
                                    </div>
                                    <div class="relative w-full flex items-center bg-[#BFBDBC] rounded-xl overflow-hidden">
                                        <label for="user{{ $i }}-{{ $field }}"
                                            class="px-3 py-2 cursor-pointer text-gray-700 bg-transparent border-r border-gray-500">
                                            Choose File
                                        </label>
                                        <input type="file" id="user{{ $i }}-{{ $field }}"
                                            name="user[{{ $i }}][{{ $field }}]"
                                            accept="image/png, image/jpeg" class="hidden"
                                            onchange="previewImage(event, '{{ $field }}', {{ $i }})">
                                        <span id="file-name-{{ $field }}-{{ $i }}"
                                            class="text-gray-700 truncate px-3">
                                            No file chosen
                                        </span>
                                    </div>
                                    @if (trim(strtolower($field)) === 'twibbon')
                                        <a href="https://docs.google.com/document/d/12WIOeYrcGlbaqv9JmoMQY2ooaxqyFOALBmwBZJKh-Ug/edit?usp=sharing"
                                            target="_blank" rel="noopener noreferrer"
                                            class="text-blue-500 underline hover:text-blue-700">
                                            📄 Ketentuan Upload Twibbon (Google Docs)
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endfor
                @php
                    if ($firstEmptyIndex === null && !isset($proof)) {
                        $firstEmptyIndex = 4;
                    }
                @endphp

                <div id="form-5" class="form-slide p-12 w-full flex flex-col items-center justify-center"
                    @if ($firstEmptyIndex === 4) data-first-empty="true" @endif>
                    <h2 class="text-2xl sm:text-4xl font-bold mb-4 col-span-12 text-white text-center">
                        Informasi Pembayaran
                    </h2>
                    <div class="w-full md:w-[90%] lg:w-[80%] bg-slate-300 rounded-xl flex flex-col items-center p-5">
                        <h1 class="text-[var(--cap-green5)] text-xl sm:text-3xl font-bold my-5 text-center">Jumlah
                            Transfer: Rp150.000,00</h1>
                        <p class="text-center text-sm sm:text-lg font-bold mb-7">Silahkan lakukan pembayaran dari jumlah
                            yang ditentukan ke akun berikut:</p>
                        <p class="text-center text-sm sm:text-lg font-bold mb-7">Nomor Rekening BCA: 82927779282<br>atas
                            nama Pricilla Chealsea</p>
                        <p class="text-center text-sm sm:text-lg font-bold">Ketentuan:</p>
                        <ol class="list-decimal pl-5 mb-7">
                            <li class="text-center text-sm sm:text-lg font-bold">Masukkan 'NAMA TIM_CAPITAL 2025' sebagai
                                berita transfer</li>
                            <li class="text-center text-sm sm:text-lg font-bold">File bukti transfer diunggah dalam format
                                JPG, PNG, atau PDF</li>
                        </ol>

                        <div id="prooff" class="mb-4 relative {{ isset($proof) ? '' : 'hidden' }}">
                            @if (isset($proof))
                                <img src="{{ asset($proof) }}" alt="" class="h-[130px] w-auto rounded">
                                <span id="remove-existing" onclick="removeExistingImage(4)"
                                    class="absolute top-0 left-0 bg-red-500 text-white px-2 py-1 cursor-pointer rounded-full text-sm">
                                    &times;
                                </span>
                            @endif
                        </div>

                        <div id="drop_container"
                            class="w-full justify-center items-center flex flex-col h-[200px] pb-[40px] pt-[20px] {{ isset($proof) ? 'hidden' : '' }}">
                            <div id="drop_area"
                                class="rounded-sm h-full w-[65%] flex items-center justify-center relative py-1 md:p-0 px-2">
                                <label for="proof_of_payment"
                                    class="h-full w-full font-return-grid text-[var(--cap-green5)] select-none cursor-pointer md:tracking-[1.25px] flex flex-col-reverse items-center justify-center font-serif">
                                    <p id="file_name"
                                        class="h-2/5 px-2 font-return-grid text-[#808080] leading-[20px] text-shadow-[0_0_10px_rgba(92,118,80,1)] select-none md:text-[18px]">
                                        Drag
                                        & Drop your Image here or click to
                                        upload</p>

                                    <svg class="h-1/2 drop-shadow-[0_0_10px_rgba(92,118,80,1)]" fill="#808080"
                                        version="1.1" id="drop_icon" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="38" height="38"
                                        viewBox="0 0 31.332 31.332" xml:space="preserve">
                                        <g>
                                            <path
                                                d="M23.047,15.266c0.781,0.781,0.781,2.047,0,2.828l-7.381,7.381l-7.379-7.379c-0.781-0.781-0.781-2.046,0-2.828
                                                                c0.78-0.781,2.047-0.781,2.827,0l2.552,2.551V8.686c0-1.104,0.896-2,2-2c1.104,0,2,0.896,2,2v9.132l2.553-2.553
                                                                C21,14.484,22.268,14.484,23.047,15.266z M31.332,15.666c0,8.639-7.027,15.666-15.666,15.666C7.026,31.332,0,24.305,0,15.666
                                                                C0,7.028,7.026,0,15.666,0C24.307,0,31.332,7.028,31.332,15.666z M27.332,15.666C27.332,9.233,22.1,4,15.666,4
                                                                C9.233,4,4,9.233,4,15.666C4,22.1,9.233,27.332,15.666,27.332C22.1,27.332,27.332,22.1,27.332,15.666z" />
                                        </g>
                                    </svg>
                                </label>
                                <input type="file" id="proof_of_payment" name="user[4][proof_of_payment]"
                                    accept="image/png, image/jpeg" onchange="handleProofUpload()">
                            </div>
                        </div>
                        <div id="proof_preview"
                            class="hidden overflow-y-hidden flex items-center justify-center relative mb-5">
                            <img id="proof_image" src="#" alt="Preview Bukti Transfer"
                                class="h-[130px] w-auto object-cover border rounded select-none cursor-pointer md:tracking-[1.25px]">
                            <span id="remove-proof-of-payment" onclick="removeUploadedImage(4)"
                                class="absolute top-0 left-0 bg-red-500 text-white px-2 py-1 cursor-pointer rounded-full text-sm">
                                &times;
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-wrapper flex justify-center items-center my-5"></div>
        </div>
           {{-- bushes --}}
           <img class="absolute -bottom-[7%] left-[30%] z-[1] md:w-[450px] lg:w-[550px] bush"
            style="--sway-speed: 3.5s; --sway-angle: 3deg;"
            src="{{ asset('assets/form/bush-4.png')}}" alt="">
        
            <img class="absolute -bottom-[2%] md:left-[11%] z-[2] md:w-[400px] lg:w-[500px] bush"
                style="--sway-speed: 3s; --sway-angle: 4deg;"
                src="{{ asset('assets/form/bush-5.png')}}" alt="">
            
            <img class="absolute -bottom-[2%] md:right-[13%] z-[2] md:w-[400px]  lg:w-[500px] scale-x-[-1] bush"
                style="--sway-speed: 4s; --sway-angle: -4deg;"
                src="{{ asset('assets/form/bush-5.png')}}" alt="">
            
            <img class="absolute -bottom-[18%] md:-left-[32%] z-[3] md:w-[650px] lg:w-[775px] bush"
                style="--sway-speed: 3.8s; --sway-angle: 2.5deg;"
                src="{{ asset('assets/form/bush-2.png')}}" alt="">
            
            <img class="absolute -bottom-[15%] md:-right-[32%] lg:-right-[27%] z-[3] md:w-[600px] lg:w-[725px] scale-x-[-1] rotate-[-5deg] bush"
                style="--sway-speed: 3.2s; --sway-angle: -3deg;"
                src="{{ asset('assets/form/bush-2.png')}}" alt="">
            
            <img class="absolute md:-bottom-[13%] lg:-bottom-[15%] left-[9%] z-[4] md:w-[400px] lg:w-[500px] bush"
                style="--sway-speed: 3s; --sway-angle: 3deg;"
                src="{{ asset('assets/form/bush-1.png')}}" alt="">
            
            <img class="absolute md:-bottom-[13%] lg:-bottom-[15%] right-[8%] z-[4] md:w-[400px] lg:w-[500px] rotate-[-17deg] bush"
                style="--sway-speed: 3.5s; --sway-angle: -3.5deg;"
                src="{{ asset('assets/form/bush-1.png')}}" alt="">
            
                <img class="absolute md:-bottom-[14%] lg:-bottom-[17%] left-[30%] z-[5] md:w-[425px] lg:w-[525px] bush"
                style="--sway-speed: 4s; --sway-angle: 5deg;"
                src="{{ asset('assets/form/bush-3.png')}}" alt="">
            
            <img class="absolute md:-bottom-[16%] lg:-bottom-[20%] left-0 z-[5] md:w-[350px] lg:w-[450px] bush"
                style="--sway-speed: 3.6s; --sway-angle: 3deg;"
                src="{{ asset('assets/form/bush-4.png')}}" alt="">
            
            <img class="absolute md:-bottom-[18%] lg:-bottom-[20%] right-0 z-[5] md:w-[350px] lg:w-[450px] rotate-[5deg] bush"
                style="--sway-speed: 4.2s; --sway-angle: -3deg;"
                src="{{ asset('assets/form/bush-4.png')}}" alt="">
      

    </div>
@endsection

@section('script')
    <script>
        const dropAreaContainer = document.getElementById('drop_container');
        const dropArea = document.getElementById('drop_area');
        const proofInput = document.getElementById('proof_of_payment');
        const fileNameLabel = document.getElementById('file_name');
        const proofImg = document.getElementById('proof_image');
        const proofPreview = document.getElementById('proof_preview');

        function removeExistingImage(i, field = null) {
            if (i < 4 && field) {
                const previewExisting = document.getElementById(`preview-existing-${field}-${i}`);
                const removeExisting = document.getElementById(`remove-existing-${field}-${i}`);
                const uploadContainer = document.getElementById(`upload-container-${field}-${i}`);

                if (previewExisting) previewExisting.style.display = 'none';
                if (removeExisting) removeExisting.style.display = 'none';
                if (uploadContainer) uploadContainer.classList.remove('hidden');
            } else {
                const prooff = document.getElementById('prooff');
                const dropContainer = document.getElementById('drop_container');

                if (prooff) prooff.style.display = 'none';
                if (dropContainer) dropContainer.classList.remove('hidden');
            }
        }

        function removeUploadedImage(i, field = null) {
            let removeButton;

            if (i < 4 && field) {
                const fileInput = document.getElementById(`user${i}-${field}`);
                const preview = document.getElementById(`preview-upload-${field}-${i}`);
                const fileNameSpan = document.getElementById(`file-name-${field}-${i}`);
                removeButton = document.getElementById(`remove-upload-${field}-${i}`);

                if (fileInput) fileInput.value = "";
                if (preview) {
                    preview.src = "#";
                    preview.classList.add('hidden');
                }
                if (fileNameSpan) fileNameSpan.textContent = "No file chosen";
            } else {
                const fileInput = document.getElementById('proof_of_payment');
                const previewContainer = document.getElementById('proof_preview');
                const proofImage = document.getElementById('proof_image');
                removeButton = document.getElementById('remove-proof-of-payment');

                if (fileInput) fileInput.value = "";
                fileNameLabel.textContent = "Drag & Drop your Image here or click to upload";
                if (proofImage) proofImage.src = "#";
                if (previewContainer) previewContainer.classList.add('hidden');

                const dropContainer = document.getElementById('drop_container');
                if (dropContainer) dropContainer.classList.remove('hidden');
            }

            if (removeButton) removeButton.classList.add('hidden');
        }


        function handleProofUpload() {
            let removeButton = document.getElementById('remove-proof-of-payment');
            const file = proofInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    proofImg.src = e.target.result;
                    proofPreview.classList.remove('hidden');
                    dropAreaContainer.classList.add('hidden');
                    removeButton.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
                fileNameLabel.textContent = file.name;
            }
        }

        dropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropArea.classList.add('dragover');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('dragover');
        });

        dropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            dropArea.classList.remove('dragover');
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                proofInput.files = files;
                handleProofUpload();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('keydown', (event) => {
                    if (event.key === "ArrowUp" || event.key === "ArrowDown") {
                        event.preventDefault();
                    }
                });
            });

            let currentIndex = 0;
            const formContainer = document.querySelector('.form-container');
            const formSlides = document.querySelectorAll('.form-slide');
            const buttonWrapper = document.querySelector('.button-wrapper');

            formContainer.style.width = `${formSlides.length * 100}%`;

            currentIndex = Array.from(formSlides).findIndex(slide => slide.dataset.firstEmpty === "true");
            if (currentIndex === -1) {
                currentIndex = 0;
            }

            const updateSlide = () => {
                const slideWidth = formSlides[0].clientWidth;
                formContainer.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
                updateButtons();
                trapFocus(formSlides[currentIndex]);
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };

            const updateButtons = () => {
                buttonWrapper.innerHTML = '';
                const leftPlaceholder = document.createElement('div');
                leftPlaceholder.className = 'flex justify-end w-[10%]';
                if (currentIndex > 0) {
                    const prevButton = createButton('', 'prev');
                    const prevIcon = document.createElement('i');
                    prevIcon.className = 'fa-solid fa-chevron-left text-white hover:text-slate-400';
                    prevButton.appendChild(prevIcon);
                    prevButton.addEventListener('click', () => {
                        currentIndex--;
                        updateSlide();
                    });
                    leftPlaceholder.appendChild(prevButton);
                }
                buttonWrapper.appendChild(leftPlaceholder);

                const centerButtons = document.createElement('div');
                centerButtons.className = 'flex gap-4 justify-center w-auto';
                const exitButton = createButton('Exit', 'exit');
                exitButton.addEventListener('click', () => {
                    window.location.href = "{{ route('home') }}";
                });
                centerButtons.appendChild(exitButton);

                const saveButton = createButton('Save', 'save');
                saveButton.addEventListener('click', () => {
                    const data = [];
                    let validationError = '';

                    formSlides.forEach((slide, index) => {
                        let formData = {};
                        let isFormFilled = false;
                        if (index < 4) {
                            formData = {
                                id: document.getElementById(`user${index}-id`)?.value
                                    .trim() ||
                                    '',
                                position: document.getElementById(`user${index}-position`)
                                    ?.value.trim(),
                                name: document.getElementById(`user${index}-name`).value
                                    .trim(),
                                gender: document.getElementById(`user${index}-gender`).value
                                    .trim(),
                                phone_number: document.getElementById(`user${index}-phone`)
                                    .value.trim(),
                                line_id: document.getElementById(`user${index}-line`).value
                                    .trim(),
                                consumption_type: document.getElementById(
                                    `user${index}-consumption`).value.trim(),
                                food_allergy: document.getElementById(
                                    `user${index}-food-allergy`).value.trim(),
                                drug_allergy: document.getElementById(
                                    `user${index}-drug-allergy`).value.trim(),
                                medical_history: document.getElementById(
                                    `user${index}-medical-history`).value.trim(),
                                student_card: document.getElementById(
                                    `user${index}-student_card`).files[0] || null,
                                twibbon: document.getElementById(
                                    `user${index}-twibbon`).files[0] || null,
                            };
                            isFormFilled = formData.name && formData.gender;
                        } else {
                            formData = {
                                proof_of_payment: document.getElementById(
                                    'proof_of_payment').files[0] || null,
                            };
                            isFormFilled = formData.proof_of_payment;
                        }

                        const ordinalSuffix = (n) => {
                            const suffixes = ["th", "st", "nd", "rd"];
                            const v = n % 100;
                            return `${n}${suffixes[(v - 20) % 10] || suffixes[v] || suffixes[0]}`;
                        };

                        if (isFormFilled && !data[index - 1]) {
                            if (index === 1) {
                                validationError =
                                    `You must fill the Leader form before proceeding to the 1st member form.`;
                            } else if (index >= 2 && index <= 3) {
                                validationError =
                                    `You must fill the ${ordinalSuffix(index - 1)} member form before proceeding to the ${ordinalSuffix(index)} member form.`;
                            } else if (index === 4) {
                                validationError =
                                    `You must fill all the forms before uploading proof of payment.`;
                            }
                        }
                        if (isFormFilled || formData.id) {
                            data.push(formData);
                        } else if (index === 0 && !isFormFilled) {
                            validationError = 'You must fill the Leader form.';
                        }
                    });
                    if (validationError) {
                        Swal.fire({
                            title: 'Validation Error',
                            text: validationError,
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonColor: "#56843a",
                        });
                        return;
                    }
                    const formDataObject = new FormData();
                    data.forEach((item, index) => {
                        for (const key in item) {
                            if (key === 'id' && item[key]) {
                                formDataObject.append(`user[${index}][${key}]`, item[key]);
                            } else if (key === 'student_card' && item[key]) {
                                formDataObject.append(`user[${index}][${key}]`, item[key]);
                            } else if (key === 'twibbon' && item[key]) {
                                formDataObject.append(`user[${index}][${key}]`, item[key]);
                            } else if (key !== 'id') {
                                formDataObject.append(`user[${index}][${key}]`, item[key]);
                            }
                        }
                    });
                    Swal.fire({
                        title: 'Saving users...',
                        text: 'Please wait while we process the data.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    fetch("{{ route('user.save') }}", {
                            method: 'POST',
                            body: formDataObject,
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            },
                        })
                        .then((response) => response.json())
                        .then((result) => {
                            Swal.close();
                            if (result.errors) {
                                let errorMessages = '';
                                if (typeof result.errors === 'object') {
                                    Object.entries(result.errors).forEach(([key, errors]) => {
                                        const role = errors
                                            .shift();
                                        errorMessages += `<strong>${role}</strong><ul>`;
                                        errors.forEach((err) => {
                                            errorMessages += `<li>${err}</li>`;
                                        });
                                        errorMessages +=
                                            '</ul><br>';
                                    });
                                } else if (typeof result.errors === 'string') {
                                    errorMessages += `${result.errors}`;
                                }

                                Swal.fire({
                                    title: 'Validation Error',
                                    text: 'Please check the errors and try again.',
                                    icon: 'error',
                                    html: errorMessages,
                                    showConfirmButton: true,
                                    confirmButtonColor: "#56843a",
                                });
                            } else {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Users have been saved successfully.',
                                    icon: 'success',
                                    showConfirmButton: true,
                                    confirmButtonColor: "#56843a",
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'An unexpected error occurred. Please try again later.',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonColor: "#56843a",
                            });
                        });
                });
                centerButtons.appendChild(saveButton);

                buttonWrapper.appendChild(centerButtons);

                const rightPlaceholder = document.createElement('div');
                rightPlaceholder.className = 'flex justify-start w-[10%]';
                if (currentIndex < formSlides.length - 1) {
                    const nextButton = createButton('', 'next');
                    const nextIcon = document.createElement('i');
                    nextIcon.className = 'fa-solid fa-chevron-right text-white hover:text-slate-400';
                    nextButton.appendChild(nextIcon);
                    nextButton.addEventListener('click', () => {
                        currentIndex++;
                        updateSlide();
                    });
                    rightPlaceholder.appendChild(nextButton);
                }
                buttonWrapper.appendChild(rightPlaceholder);
            };


            const createButton = (text, className) => {
                const button = document.createElement('button');
                button.textContent = text;
                if (className === 'save') {
                    button.className =
                        `bg-white text-[var(--cap-green4)] px-4 py-2 rounded-full w-[80px] font-bold transition-all duration-300 hover:bg-slate-300`;
                } else if (className === 'exit') {
                    button.className =
                        `bg-[var(--cap-green4))] border-2 border-white text-white px-4 py-2 rounded-full w-[80px] font-bold transition-all duration-300 hover:bg-[var(--cap-green5)]`;
                } else {
                    button.className = `bg-transparent px-4 py-2 transition-all duration-300`;
                }
                return button;
            };

            const trapFocus = (slide) => {
                const focusableElements = slide.querySelectorAll(
                    'input, button, select, textarea, a[href], [tabindex]:not([tabindex="-1"])'
                );
                const firstElement = focusableElements[2];
                const lastElement = focusableElements[focusableElements.length - 2];

                slide.addEventListener('keydown', (e) => {
                    if (e.key === 'Tab') {
                        if (e.shiftKey) {
                            if (document.activeElement === firstElement) {
                                e.preventDefault();
                                lastElement.focus();
                            }
                        } else {
                            if (document.activeElement === lastElement) {
                                e.preventDefault();
                                firstElement.focus();
                            }
                        }
                    }
                });
            };
            updateSlide();

            document.getElementById('drop_area').addEventListener('mouseover', function(e) {
                e.preventDefault();
                document.getElementById('drop_icon').classList.add('filter');
                document.getElementById('drop_icon').classList.add('animate-pulse');
            })
            document.getElementById('drop_area').addEventListener('mouseleave', function(e) {
                e.preventDefault();
                document.getElementById('drop_icon').classList.remove('filter');
                document.getElementById('drop_icon').classList.remove('animate-pulse');
            })
        });

        function previewImage(event, field, index) {
            const file = event.target.files[0];
            const preview = document.getElementById(`preview-upload-${field}-${index}`);
            const removeButton = document.getElementById(`remove-upload-${field}-${index}`);
            const fileNameElement = document.getElementById(`file-name-${field}-${index}`);

            if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    removeButton.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
                fileNameElement.textContent = file.name;
            } else {
                alert('Please upload a valid JPG or PNG image.');
                event.target.value = '';
                fileNameElement.textContent = "No file chosen";
            }
        }
    </script>
@endsection
