@extends('user.layout')

@section('style')
    <style>
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
    </style>
@endsection

@section('content')
    @if (session('users') == [])
        @include('utils.welcome')
    @endif
    <div class="container flex justify-center mx-auto mt-10 p-5 z-[-1]">
        <div class="form-wrapper overflow-hidden border rounded-lg bg-white shadow-lg w-full lg:w-[60%]">
            <div class="form-container flex transition-transform duration-500">
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
                    <div id="form-{{ $i + 1 }}" class="form-slide grid grid-cols-12 gap-2 p-5 w-full"
                        @if ($firstEmptyIndex === $i) data-first-empty="true" @endif>
                        <h2 class="text-4xl font-bold mb-4 col-span-12">
                            Team Profile ({{ $i === 0 ? 'Leader' : $i . ordinal($i) . ' Member' }})
                        </h2>
                        @php
                            $user = session('users')[$i] ?? [];
                            if ($firstEmptyIndex === null && empty($user)) {
                                $firstEmptyIndex = $i;
                            }
                        @endphp
                        <input type="hidden" id="user{{ $i }}-id" name="user[{{ $i }}][id]"
                            value="{{ $user['id'] ?? '' }}">
                        <input type="hidden" id="user{{ $i }}-position"
                            name="user[{{ $i }}][position]" value="{{ $i }}">
                        <div class="col-span-6">
                            <label for="user{{ $i }}-name" class="mb-2">Name:</label>
                            <input type="text" id="user{{ $i }}-name" name="user[{{ $i }}][name]"
                                value="{{ $user['name'] ?? '' }}" class="mb-4 p-2 border rounded w-full">
                        </div>

                        <div class="col-span-6 relative">
                            <label for="user{{ $i }}-gender" class="mb-2">Gender:</label>
                            <select id="user{{ $i }}-gender" name="user[{{ $i }}][gender]"
                                class="mb-4 p-2 border rounded w-full appearance-none pr-10 bg-white">
                                <option value="0"
                                    {{ isset($user['gender']) && $user['gender'] == '0' ? 'selected' : '' }}>Male
                                </option>
                                <option value="1"
                                    {{ isset($user['gender']) && $user['gender'] == '1' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                            <div class="absolute top-[55%] right-3 transform -translate-y-1/2 pointer-events-none">
                                <svg width="13" height="13" viewBox="0 0 69 60" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M64.2982 0.80514C67.4549 0.736127 69.4433 4.18018 67.8052 6.87942L36.9564 57.7117C35.379 60.311 31.593 60.2696 30.0728 57.6365L1.4751 8.10384C-0.0451357 5.47073 1.81203 2.17126 4.85177 2.1048L64.2982 0.80514Z"
                                        fill="rgb(0,0,0)" />
                                </svg>
                            </div>
                        </div>

                        <div class="col-span-12">
                            <label for="user{{ $i }}-phone" class="mb-2">Phone:</label>
                            <input type="number" id="user{{ $i }}-phone"
                                name="user[{{ $i }}][phone_number]" value="{{ $user['phone_number'] ?? '' }}"
                                class="mb-4 p-2 border rounded w-full">
                        </div>

                        <div class="col-span-6">
                            <label for="user{{ $i }}-line" class="mb-2">Line ID:</label>
                            <input type="text" id="user{{ $i }}-line"
                                name="user[{{ $i }}][line_id]" value="{{ $user['line_id'] ?? '' }}"
                                class="mb-4 p-2 border rounded w-full">
                        </div>

                        <div class="col-span-6 relative">
                            <label for="user{{ $i }}-consumption" class="mb-2">Consumption Type:</label>
                            <select id="user{{ $i }}-consumption"
                                name="user[{{ $i }}][consumption_type]"
                                class="mb-4 p-2 border rounded w-full appearance-none pr-10 bg-white">
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
                            <div class="absolute top-[55%] right-3 transform -translate-y-1/2 pointer-events-none">
                                <svg width="13" height="13" viewBox="0 0 69 60" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M64.2982 0.80514C67.4549 0.736127 69.4433 4.18018 67.8052 6.87942L36.9564 57.7117C35.379 60.311 31.593 60.2696 30.0728 57.6365L1.4751 8.10384C-0.0451357 5.47073 1.81203 2.17126 4.85177 2.1048L64.2982 0.80514Z"
                                        fill="rgb(0,0,0)" />
                                </svg>
                            </div>
                        </div>

                        <div class="col-span-12">
                            <label for="user{{ $i }}-food-allergy" class="mb-2">Food Allergy:</label>
                            <textarea id="user{{ $i }}-food-allergy" name="user[{{ $i }}][food_allergy]"
                                class="mb-4 p-2 border rounded w-full resize-none">{{ $user['food_allergy'] ?? '-' }}</textarea>
                        </div>

                        <div class="col-span-12">
                            <label for="user{{ $i }}-drug-allergy" class="mb-2">Drug Allergy:</label>
                            <textarea id="user{{ $i }}-drug-allergy" name="user[{{ $i }}][drug_allergy]"
                                class="mb-4 p-2 border rounded w-full resize-none">{{ $user['drug_allergy'] ?? '-' }}</textarea>
                        </div>

                        <div class="col-span-12">
                            <label for="user{{ $i }}-medical-history" class="mb-2">Medical
                                History:</label>
                            <textarea id="user{{ $i }}-medical-history" name="user[{{ $i }}][medical_history]"
                                class="mb-4 p-2 border rounded w-full resize-none">{{ $user['medical_history'] ?? '-' }}</textarea>
                        </div>

                        <div class="col-span-12">
                            <label for="user{{ $i }}-student-card" class="mb-2">Student Card:</label>
                            @if (!empty($user['student_card']))
                                <div class="mb-4">
                                    <img id="preview-existing-{{ $i }}"
                                        src="{{ asset($user['student_card']) }}" alt="Student Card"
                                        class="w-32 h-auto rounded">
                                </div>
                            @endif
                            <div class="mb-4">
                                <img id="preview-upload-{{ $i }}" src="#" alt="Preview"
                                    class="w-32 h-auto rounded hidden">
                            </div>
                            <input type="file" id="user{{ $i }}-student-card"
                                name="user[{{ $i }}][student_card]" accept="image/png, image/jpeg"
                                class="mb-4 p-2 border rounded w-full"
                                onchange="previewImage(event, {{ $i }})">
                        </div>

                    </div>
                @endfor
                @php
                    if ($firstEmptyIndex === null && !$proof) {
                        $firstEmptyIndex = 4;
                    }
                @endphp

                <div id="form-4" class="form-slide p-5 w-full flex flex-col items-center justify-center"
                    @if ($firstEmptyIndex === 4) data-first-empty="true" @endif>
                    <h2 class="text-4xl font-bold mb-4 col-span-12">
                        Informasi Pembayaran
                    </h2>
                    <div class="w-[80%] bg-slate-300 flex flex-col items-center">
                        <h1>Jumlah Transfer: Rp150.000,00</h1>
                        <p>Silahkan lakukan pembayaran dari jumlah yang ditentukan ke akun berikut:</p>
                        <p class="text-center">Nomor Rekening BCA: 82927779282<br>atas nama Pricilla Chealsea</p>
                        <p>Ketentuan:</p>
                        <ol class="list-decimal pl-5">
                            <li>Masukkan 'NAMA TIM_CAPITAL 2025' sebagai berita transfer</li>
                            <li>File bukti transfer diunggah dalam format JPG, PNG, atau PDF</li>
                        </ol>
                        @if (isset($proof))
                            <img src="{{ asset($proof) }}" alt="" class="w-32 h-auto rounded">
                        @endif
                        <div id="drop_container"
                            class="w-full justify-center items-center flex flex-col h-[200px] pb-[40px] pt-[20px]">
                            <div id="drop_area"
                                class="rounded-sm h-full md:w-[65%] flex items-center justify-center relative py-1 md:p-0 px-2">
                                <label for="proof_of_payment"
                                    class="h-full w-full font-return-grid text-white select-none cursor-pointer md:tracking-[1.25px] flex flex-col-reverse items-center justify-center font-serif">
                                    <p id="file_name"
                                        class="h-2/5 px-2 font-return-grid text-white leading-[20px] text-shadow-white select-none md:text-[18px]">
                                        Drag
                                        & Drop your Image here or click to
                                        upload</p>

                                    <svg class="h-1/2 drop-shadow-[0_0_10px_rgba(255,255,255,1)]" fill="white"
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
                            class="hidden w-full overflow-y-hidden flex items-center justify-center relative mb-5">
                            <img id="proof_image" src="#" alt="Preview Bukti Transfer"
                                class="w-[250px] h-auto object-cover border rounded select-none cursor-pointer md:tracking-[1.25px]">
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-wrapper flex justify-center items-center mt-5"></div>
        </div>
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

        function handleProofUpload() {
            console.log('click');

            const file = proofInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    proofImg.src = e.target.result;
                    proofPreview.classList.remove('hidden');
                    dropAreaContainer.classList.add('hidden');
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
            let currentIndex = 0;
            const formContainer = document.querySelector('.form-container');
            const formSlides = document.querySelectorAll('.form-slide');
            const buttonWrapper = document.querySelector('.button-wrapper');

            formContainer.style.width = `${formSlides.length * 100}%`;

            currentIndex = Array.from(formSlides).findIndex(slide => slide.dataset.firstEmpty === "true");

            const updateSlide = () => {
                const slideWidth = formSlides[0].clientWidth;
                formContainer.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
                updateButtons();
                trapFocus(formSlides[currentIndex]);
            };

            const updateButtons = () => {
                buttonWrapper.innerHTML = '';
                const leftPlaceholder = document.createElement('div');
                leftPlaceholder.className = 'flex justify-end w-[10%]';
                if (currentIndex > 0) {
                    const prevButton = createButton('', 'prev');
                    const prevIcon = document.createElement('i');
                    prevIcon.className = 'fa-solid fa-chevron-left';
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
                                    `user${index}-student-card`).files[0] || null,
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
                            } else if (key !== 'id') {
                                formDataObject.append(`user[${index}][${key}]`, item[key]);
                            }
                        }
                    });
                    for (const pair of formDataObject.entries()) {
                        console.log(pair[0] + ": " + pair[1]);
                    }
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
                                });
                            } else {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Users have been saved successfully.',
                                    icon: 'success',
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
                    nextIcon.className = 'fa-solid fa-chevron-right';
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
                if (className === 'save' || className === 'exit') {
                    button.className =
                        `bg-blue-500 text-white px-4 py-2 rounded-full w-[80px] transition-all duration-300 hover:bg-blue-600`;
                } else {
                    button.className = `bg-transparent text-slate-900 px-4 py-2 transition-all duration-300`;
                }
                return button;
            };

            const trapFocus = (slide) => {
                const focusableElements = slide.querySelectorAll(
                    'input, button, select, textarea, a[href], [tabindex]:not([tabindex="-1"])'
                );
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];
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

        function previewImage(event, index) {
            const file = event.target.files[0];
            const preview = document.getElementById(`preview-upload-${index}`);

            if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                alert('Please upload a valid JPG or PNG image.');
                event.target.value = '';
            }
        }
    </script>
@endsection
