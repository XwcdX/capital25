<style>
    .cropper-view-box,
    .cropper-face {
        border-radius: 50%
    }

    #profileNameInput {
        border: none;
        outline: none;
        background: transparent;
    }

    .greeennn{
      color: var(--cap-green2) !important;
      font-size: 1rem !important;
      gap: 0;
      margin: 0px !important; 
      padding: 12px 0 0 12px  !important; 
    }

    .link-merged {
        color: #ffffff;
        font-size: 20px;
        text-decoration: none;
        padding: 10px 20px;
        margin: 0 5px;
        position: relative;
        display: inline-block;
        transition: all 0.5s;
        border-radius: 8px;
    }

    .link-merged:hover {
        color: #c8e9f0;
        text-shadow: 0 0 10px #c8e9f0, 0 0 20px #c8e9f0, 0 0 30px #c8e9f0, 0 0 40px #c8e9f0;
    }

    .link-merged::after {
        content: "";
        position: absolute;
        width: 0;
        background-color: rgba(255, 255, 255, 0.4);
        left: 50%;
        transform: translateX(-50%);
        bottom: -0.25em;
        height: 2px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .link-merged:hover::after {
        width: 100%;
        animation: pulse11 1s;
        box-shadow: 0 0 0 1em transparent;
    }

    @keyframes pulse11 {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
        }

        100% {
            box-shadow: 0 0 0 1em transparent;
        }
    }

    .navbar {
        width: 100%;
        z-index: 9999;
        position: fixed;
    }

    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 62px;
    }

    .navbar .nav-container li {
        list-style: none;
    }

    .navbar .nav-container a {
        text-decoration: none;
        color: #ffffff;
        /* font-weight: 500; */
        font-size: 1.7rem;
        padding: 0.7rem;
        /* text-shadow: 0 0 2px #ff8c00, 0 0 5px #ff8c00, 0 0 10px #ff8c00; */
    }

    .navbar .nav-container a:hover {
        color: #b1ce58;
        transition: all 0.2s;
    }

    li:hover {
        color: #b1ce58;
        transition: all 0.2s;
    }

    .nav-container {
        display: block;
        position: relative;
        height: 60px;
    }

    .nav-container .checkbox {
        position: fixed;
        display: block;
        height: 32px;
        width: 32px;
        top: 20px;
        left: 20px;
        z-index: 9999;
        opacity: 0;
        cursor: pointer;
    }

    .nav-container .hamburger-lines {
        display: block;
        height: 26px;
        width: 32px;
        position: absolute;
        top: 17px;
        left: 20px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .nav-container .hamburger-lines .line {
        display: block;
        height: 4px;
        width: 100%;
        border-radius: 10px;
        background: #ffffff;
    }

    .nav-container .hamburger-lines .line1 {
        transform-origin: 0% 0%;
        transition: transform 0.4s ease-in-out;
    }

    .nav-container .hamburger-lines .line2 {
        transition: transform 0.2s ease-in-out;
    }

    .nav-container .hamburger-lines .line3 {
        transform-origin: 0% 100%;
        transition: transform 0.4s ease-in-out;
    }

    /* General styles for the menu-items */
    .navbar .menu-items {
        /* padding-top: 120px; */
        background: #25362d;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        height: 100vh;
        width: 100%;
        /* Default full-width for smaller devices */
        transform: translate3d(-150%, 0, 0);
        display: flex;
        flex-direction: column;
        margin-left: -40px;
        /* padding-left: 50px; */
        transition: transform 0.5s ease-in-out;
        will-change: transform;
        text-align: center;
        backdrop-filter: blur(10px);
        z-index: 999;
        position: relative;
    }

    /* Adjust width for laptop devices (min-width: 1024px) */
    @media (min-width: 1024px) {
        .navbar .menu-items {
            width: 30%;
            /* Make the navbar width half of the screen */
            margin-left: 0;
            /* Remove the offset for larger devices */
            /* padding-left: 20px;  */
        }
    }

    .navbar .menu-items li {
        margin-bottom: 1.2rem;
        font-size: 1.5rem;
        font-weight: 500;
        z-index: 999;
    }

    .nav-container input[type="checkbox"]:checked~.menu-items {
        transform: translateX(0);
    }

    .nav-container input[type="checkbox"]:checked~.hamburger-lines .line1 {
        transform: rotate(45deg);
    }

    .nav-container input[type="checkbox"]:checked~.hamburger-lines .line2 {
        transform: scaleY(0);
    }

    .nav-container input[type="checkbox"]:checked~.hamburger-lines .line3 {
        transform: rotate(-45deg);
    }

    .nav-overlay {
        opacity: 0;
        visibility: hidden;
        background: rgba(0, 0, 0, 0.65);
        /* Semi-transparent black */
        position: absolute;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 998;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .nav-container input[type="checkbox"]:checked~.nav-overlay {
        opacity: 1;
        visibility: visible;
    }

    /* standford breath font */
    @font-face {
        font-family: 'Hermona';
        src: url('/fonts/Hermona.otf') format('opentype');
    }

    .hermona {
        font-family: 'Hermona';
    }

    .nav {
        transition: transform 0.3s ease-in-out;
    }

    .-translate-y-full {
        transform: translateY(-100%);
    }
</style>

<div id="navbar" class="">
    <nav class="navbar block md:hidden">
        <div class="container nav-container font-quicksand">
            <input class="checkbox" type="checkbox" name="" id="nav-toggle" />
            <div class="hamburger-lines drop-shadow-md">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>
            <div class="nav-overlay"></div>
            <ul class=" menu-items items-center justify-center gap-6 relative">
                <li><a href="#aboutUs" class=" drop-shadow-lg hover:scale-110 font-extrabold">ABOUT</a></li>
                <li><a href="#timeline" class=" drop-shadow-lg hover:scale-110 font-extrabold">TIMELINE</a></li>
                <li><a href="#prizepool" class=" drop-shadow-lg hover:scale-110 font-extrabold">PRIZE POOL</a></li>
                <li><a href="#faq" class=" drop-shadow-lg hover:scale-110 font-extrabold">FAQ</a></li>
                {{-- ganti route ke regist --}}
                @if (Auth::user())
                    <li class="absolute bottom-2 left-12 flex items-center gap-3 cursor-pointer"
                        id="mobileProfileToggle">
                        <img class="rounded-full h-[50px] w-[50px]"
                            src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('assets/landing/icon-profile.png') }}"
                            alt="Profile">
                        <span class="text-white font-bold">{{ Auth::user()->name }}</span>
                    </li>
                    <ul id="mobileProfileDropdown"
                        class="absolute bottom-[100px] z-[1100] left-12 w-[70%] bg-white shadow-lg rounded-lg opacity-0 invisible transition-all duration-200">
                        <li>
                            <a id="editUserProfile"
                                class="greeennn flex items-center text-[var(--cap-green2)] hover:bg-gray-200 cursor-pointer">
                                <i class="fa-solid fa-user-pen"></i> Edit User Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.regist') }}"
                                class="greeennn flex items-center text-[var(--cap-green2)] hover:bg-gray-200">
                                <i class="fa-solid fa-file-pen"></i> Edit Team Profile
                            </a>
                        </li>
                        <hr class="my-1 border-gray-300">
                        <li>
                            <a href="{{ route('team.logout') }}"
                                class="greeennn flex items-center text-[var(--cap-green2)] hover:bg-gray-200">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </a>
                        </li>
                    </ul>
                @else
                    <li><a href="{{ route('team.login') }}"
                            class="drop-shadow-lg hover:scale-110 font-extrabold">Login</a></li>
                @endif
            </ul>
        </div>
    </nav>

    {{-- desktop nav --}}
    <nav
        class="nav hidden md:block font-quicksand fixed top-0 left-0 z-[80] border-gray-200 w-full bg-transparent backdrop-blur shadow-md">
        <div class="flex flex-wrap items-center justify-end mx-auto px-4 lg:px-8 2xl:px py-4">
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white
              rounded-lg md:hidden focus:ring-2 ring-amber-400"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="borderXwidth flex flex-col py-4 md:p-0  md:flex-row text-white tracking-wide text-md space-x-6">
                    <li><a href="#aboutUs" class=" drop-shadow-lg hover:scale-110 font-extrabold">ABOUT</a></li>
                    <li><a href="#timeline" class=" drop-shadow-lg hover:scale-110 font-extrabold">TIMELINE</a></li>
                    <li><a href="#prizepool" class=" drop-shadow-lg hover:scale-110 font-extrabold">PRIZE POOL</a></li>
                    <li><a href="#faq" class=" drop-shadow-lg hover:scale-110 font-extrabold">FAQ</a></li>
                    {{-- ganti route ke regist --}}
                    @if (Auth::user())
                        <li class="relative">
                            <a id="profileDropdownToggle"
                                class="drop-shadow-lg hover:scale-110 font-extrabold cursor-pointer">
                                <img class="h-[25px] w-[25px] rounded-full"
                                    src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('assets/landing/icon-profile.png') }}"
                                    alt="Profile">
                            </a>
                            <ul id="profileDropdown"
                                class="absolute w-[210px] right-0 p-2 mt-2 w-48 bg-white shadow-lg rounded-lg opacity-0 invisible transition-all duration-200">
                                <li>
                                    <a id="editUserProfile"
                                        class="flex items-center text-[var(--cap-green2)] gap-2 px-4 py-2 hover:bg-gray-200 cursor-pointer">
                                        <i class="fa-solid fa-user-pen"></i> Edit User Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user.regist') }}"
                                        class="flex items-center text-[var(--cap-green2)] gap-2 px-4 py-2 hover:bg-gray-200">
                                        <i class="fa-solid fa-file-pen"></i> Edit Team Profile
                                    </a>
                                </li>
                                <hr class="my-1 border-gray-300">
                                <li>
                                    <a href="{{ route('team.logout') }}"
                                        class="flex items-center text-[var(--cap-green2)] gap-2 px-4 py-2 hover:bg-gray-200">
                                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('team.login') }}"
                                class=" drop-shadow-lg hover:scale-110 font-extrabold">LOGIN</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @if (Auth::user())
        <div id="userProfileModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100] hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
                <div class="relative inline-block">
                    <input type="file" id="profileImageInput" accept="image/png, image/jpeg" hidden>
                    <img id="profileImagePreview" class="w-24 h-24 rounded-full mx-auto cursor-pointer"
                        src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('assets/landing/icon-profile.png') }}"
                        alt="Profile">
                    <i class="fa-solid fa-pen absolute bottom-2 right-2 bg-white p-1 rounded-full shadow-md cursor-pointer"
                        id="editImageIcon"></i>
                </div>
                <div class="mt-4">
                    <h2 class="text-xl font-bold" id="profileNameDisplay">
                        {{ Auth::user()->name }}
                        <i class="fa-solid fa-pen cursor-pointer" id="editNameIcon"></i>
                    </h2>
                    <input type="text" id="profileNameInput" class="hidden text-xl text-center font-bold w-auto"
                        value="{{ Auth::user()->name }}">
                </div>
                <button id="saveProfileChanges" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Save</button>
                <button id="closeModal" class="mt-2 px-4 py-2 bg-red-500 text-white rounded">Close</button>
            </div>
        </div>

        <div id="cropperModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[110] hidden">
            <div class="bg-white p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-bold mb-2">Crop Your Image</h2>
                <div class="w-64 h-64 overflow-hidden">
                    <img id="cropperImage" class="max-w-full">
                </div>
                <div class="mt-4 flex justify-center gap-2">
                    <button id="cropImage" class="px-4 py-2 bg-green-500 text-white rounded">Crop</button>
                    <button id="cancelCrop" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                </div>
            </div>
        </div>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
    <script>
        const mobileProfileToggle = document.getElementById("mobileProfileToggle");
        const dropdown = document.getElementById("mobileProfileDropdown");
        const profileToggle = document.getElementById('profileDropdownToggle');
        const profileDropdown = document.getElementById('profileDropdown');
        document.addEventListener('DOMContentLoaded', function() {
            if (mobileProfileToggle && dropdown) {
                mobileProfileToggle.addEventListener("click", function() {
                    dropdown.classList.toggle("opacity-0");
                    dropdown.classList.toggle("invisible");
                });
            }
            const dropdownLinks = profileDropdown.querySelectorAll('a');
            profileToggle.addEventListener('click', function(event) {
                event.stopPropagation();
                profileDropdown.classList.toggle('opacity-0');
                profileDropdown.classList.toggle('invisible');
            });
            document.addEventListener('click', function(event) {
                if (!profileDropdown.contains(event.target) && !profileToggle.contains(event.target)) {
                    profileDropdown.classList.add('opacity-0');
                    profileDropdown.classList.add('invisible');
                }
            });
            dropdownLinks.forEach(link => {
                link.addEventListener('click', function() {
                    profileDropdown.classList.add('opacity-0');
                    profileDropdown.classList.add('invisible');
                });
            });

            const profileImageInput = document.getElementById('profileImageInput');
            const profileImagePreview = document.getElementById('profileImagePreview');
            const editImageIcon = document.getElementById('editImageIcon');
            const editNameIcon = document.getElementById('editNameIcon');
            const profileNameDisplay = document.getElementById('profileNameDisplay');
            const profileNameInput = document.getElementById('profileNameInput');
            const saveProfileChanges = document.getElementById('saveProfileChanges');
            const cropperModal = document.getElementById('cropperModal');
            const cropperImage = document.getElementById('cropperImage');
            const cropImageBtn = document.getElementById('cropImage');
            const cancelCrop = document.getElementById('cancelCrop');
            let cropper;
            let croppedImageData = null;

            editImageIcon.addEventListener('click', () => profileImageInput.click());
            profileImageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        cropperImage.src = e.target.result;
                        cropperModal.classList.remove('hidden');
                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 1,
                            viewMode: 1,
                            dragMode: 'move',
                            movable: true,
                            scalable: false,
                            zoomable: true,
                            rotatable: false,
                            cropBoxResizable: false,
                            cropBoxMovable: false
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });
            cropImageBtn.addEventListener('click', function() {
                const croppedCanvas = cropper.getCroppedCanvas({
                    width: 200,
                    height: 200
                });
                croppedImageData = croppedCanvas.toDataURL('image/png');
                profileImagePreview.src = croppedImageData;
                cropperModal.classList.add('hidden');
                cropper.destroy();
            });
            cancelCrop.addEventListener('click', function() {
                cropperModal.classList.add('hidden');
                cropper.destroy();
            });

            function enableEditing() {
                profileNameDisplay.classList.add("hidden");
                profileNameInput.classList.remove("hidden");
                profileNameInput.focus();

                const value = profileNameInput.value;
                profileNameInput.value = "";
                profileNameInput.value = value;
            }

            function disableEditing() {
                profileNameDisplay.classList.remove("hidden");
                profileNameInput.classList.add("hidden");
                profileNameDisplay.firstChild.textContent = profileNameInput.value;
            }
            editNameIcon.addEventListener("click", enableEditing);
            profileNameInput.addEventListener("blur", disableEditing);

            function dataURLtoFile(dataurl, filename) {
                let arr = dataurl.split(','),
                    mime = arr[0].match(/:(.*?);/)[1],
                    bstr = atob(arr[1]),
                    n = bstr.length,
                    u8arr = new Uint8Array(n);
                while (n--) {
                    u8arr[n] = bstr.charCodeAt(n);
                }
                return new File([u8arr], filename, {
                    type: mime
                });
            }
            async function updateProfile(formData) {
                try {
                    Swal.fire({
                        title: "Processing...",
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    const response = await fetch("{{ route('team.updateProfile') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!data.success) {
                        throw new Error(data.message || "Server error");
                    }

                    Swal.fire({
                        title: "Updated Successfully!",
                        icon: "success",
                        confirmButtonColor: "#56843a",
                    }).then(() => {
                        location.reload();
                    });

                } catch (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.message,
                        icon: "error",
                        confirmButtonColor: "#56843a",
                    });
                }
            }
            saveProfileChanges.addEventListener('click', function() {
                const formData = new FormData();
                if (croppedImageData) {
                    const file = dataURLtoFile(croppedImageData, 'profile_image.png');
                    formData.append('profile_image', file);
                }
                formData.append('name', profileNameInput.value);
                formData.append('_method', 'PATCH');
                updateProfile(formData);
            });
        });

        document.getElementById('editUserProfile').addEventListener('click', function() {
            document.getElementById('userProfileModal').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('userProfileModal').classList.add('hidden');
        });
        const checkbox = document.getElementById('nav-toggle');
        const menuItems = document.querySelector('.menu-items');

        document.addEventListener('click', function(event) {
            if (!menuItems.contains(event.target) && !checkbox.contains(event.target)) {
                checkbox.checked = false;
            }
            if (!dropdown.contains(event.target) && !mobileProfileToggle.contains(event.target)) {
                dropdown.classList.add('opacity-0');
                dropdown.classList.add('invisible');
            }
        });

        window.addEventListener('scroll', function() {
            checkbox.checked = false;
            if (!profileDropdown.contains(event.target) && !profileToggle.contains(event.target)) {
                profileDropdown.classList.add('opacity-0');
                profileDropdown.classList.add('invisible');
            }
            if (!dropdown.contains(event.target) && !mobileProfileToggle.contains(event.target)) {
                dropdown.classList.add('opacity-0');
                dropdown.classList.add('invisible');
            }
        });

        const menuLinks = menuItems.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                checkbox.checked = false;
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            let lastScrollY = window.scrollY;

            window.addEventListener("scroll", () => {
                const navbar = document.querySelector(".nav");

                if (lastScrollY < window.scrollY) {
                    navbar.classList.add("-translate-y-full");
                } else {
                    navbar.classList.remove("-translate-y-full");
                }

                lastScrollY = window.scrollY;
            });
        });
    </script>
