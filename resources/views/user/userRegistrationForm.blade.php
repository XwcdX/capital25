@extends('user.layout')

@section('style')
    <style>
        i {
            font-size: 2.5em;
        }
    </style>
@endsection

@section('content')
    @include('utils.welcome')
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
                @endphp
                @for ($i = 0; $i < 4; $i++)
                    <div id="form-{{ $i + 1 }}" class="form-slide grid grid-cols-12 gap-2 p-5 w-full">
                        <h2 class="text-4xl font-bold mb-4 col-span-12">
                            Team Profile ({{ $i === 0 ? 'Leader' : $i . ordinal($i) . ' Member' }})
                        </h2>
                        @php
                            $user = session('users')[$i] ?? [];
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
                            <input type="text" id="user{{ $i }}-phone"
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
            </div>

            <div class="button-wrapper flex justify-center items-center mt-5"></div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentIndex = 0;
            const formContainer = document.querySelector('.form-container');
            const formSlides = document.querySelectorAll('.form-slide');
            const buttonWrapper = document.querySelector('.button-wrapper');

            formContainer.style.width = `${formSlides.length * 100}%`;

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
                        const formData = {
                            id: document.getElementById(`user${index}-id`)?.value.trim() ||
                                '',
                            position: document.getElementById(`user${index}-position`)
                                ?.value.trim(),
                            name: document.getElementById(`user${index}-name`).value.trim(),
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
                                `user${index}-student-card`).files[0],
                        };
                        const isFormFilled = formData.name && formData.gender;
                        if (index > 0 && isFormFilled && !data[index - 1]) {
                            validationError =
                                `You must fill the ${index-1} member form before proceeding to the ${index} member form.`;
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
