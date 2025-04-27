@extends('admin.layout')

@section('style')
    <style>
        .buttons {
            --color: #6c757d;
            font-family: inherit;
            display: inline-block;
            width: 6em;
            height: 2.6em;
            line-height: 2.5em;
            margin: 5px;
            position: relative;
            overflow: hidden;
            border: 2px solid var(--color);
            transition: color .5s;
            z-index: 1;
            font-size: .9rem;
            border-radius: 6px;
            font-weight: 500;
            color: var(--color);
        }

        .buttons:before {
            content: "";
            position: absolute;
            z-index: -1;
            background: var(--color);
            height: 150px;
            width: 200px;
            border-radius: 50%;
            top: 100%;
            left: 100%;
            transition: all .7s;
        }

        .buttons:hover {
            color: #fff;
        }

        .buttons:hover:before {
            top: -30px;
            left: -30px;
        }

        .buttons:active:before {
            background: #5a6268;
        }
    </style>
@endSection

@section('content')
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
        <h1 class="text-center text-4xl uppercase font-bold mb-2">Leaderboard</h1>
    </div>
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
        <div class="px-8 w-full mb-3">
            <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                <input id="advanced-search-input" type="search"
                    class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                    placeholder="Search" aria-label="Search" aria-describedby="button-addon1" />

                <!--Search button-->
                <button
                    class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                    type="button" id="advanced-search-button" data-te-ripple-init data-te-ripple-color="light">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <a href="{{route('admin.export.leaderboard.team')}}" target="_blank">
                <button type="button" data-te-ripple-init data-te-ripple-color="light"
                    class="save w-full inline-block rounded bg-success px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Download Excel Leaderboard
                </button>
            </a>
            <a href="{{route('admin.export.post.detail')}}" target="_blank">
                <button type="button" data-te-ripple-init data-te-ripple-color="light"
                    class="save mt-2 w-full inline-block rounded bg-success px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Download Excel Post Detail
                </button>
            </a>
            <a href="{{route('admin.export.coin.detail')}}" target="_blank">
                <button type="button" data-te-ripple-init data-te-ripple-color="light"
                    class="save mt-2 w-full inline-block rounded bg-success px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Download Excel Coin in Phase 3
                </button>
            </a>
        </div>
        <div id="datatable" class="w-full h-full px-5 py-5" data-te-max-height="460" data-te-fixed-header="true"></div>
    </div>
@endsection()

@section('script')
    <script>
        const customDatatable = document.getElementById("datatable");
        let data = @json($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        data = typeof data === 'string' ? JSON.parse(data) : data;

        data = Array.isArray(data) ? data.map(dt => {
            dt.users = Array.isArray(dt.users) && dt.users.length > 0 ?
                `<button class="buttons" data-users='${JSON.stringify(dt.users)
            .replace(/'/g, "&apos;")
            .replace(/"/g, "&quot;")}' onclick='showUserDetail(this)'>Team Detail</button>` :
                "";
            return dt;
        }) : [];

        const instance = new te.Datatable(
            customDatatable, {
                columns: [{
                        label: "Nama",
                        field: "name",
                        sort: true
                    },
                    {
                        label: "Email",
                        field: "email",
                        sort: true
                    },
                    {
                        label: "Sekolah",
                        field: "school",
                        sort: true
                    },
                    {
                        label: "Domisili",
                        field: "domicile",
                        sort: true
                    },
                    {
                        label: "Green point",
                        field: "green_points",
                        sort: true
                    },
                    {
                        label: "Coin",
                        field: "coin",
                        sort: true
                    },
                    {
                        label: "Anggota Team",
                        field: "users",
                        sort: false,
                        html: true
                    }
                ],
                rows: data,
            }, {
                hover: true,
                stripped: true
            },
        );

        const advancedSearchInput = document.getElementById('advanced-search-input');

        const search = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
                columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instance.search(phrase, columns);
        };

        advancedSearchInput.addEventListener("input", (e) => {
            search(e.target.value);
        });

        document
            .getElementById("advanced-search-button")
            .addEventListener("click", (e) => {
                search(advancedSearchInput.value);
            });

        advancedSearchInput.addEventListener("keydown", (e) => {
            search(e.target.value);
        });

        let lastSwalContent = null;

        function showUserDetail(button) {
            const usersJson = button.getAttribute("data-users");
            const users = JSON.parse(usersJson);

            let content = "";
            users.forEach(user => {
                content += `
                    <div class="mb-4 p-3 sm:p-4 border border-gray-300 rounded-lg shadow-sm bg-white w-full max-w-md sm:max-w-lg mx-auto">
                        <strong class="text-lg sm:text-xl block text-left">${getPosition(user.position)}</strong>
                        <div class="mt-2 text-sm sm:text-base">
                            <div class="flex items-center">
                                <div class="w-32 sm:w-40 flex justify-between">
                                    <span>Name</span><span>:</span>
                                </div>
                                <span class="ml-2">${user.name}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-32 sm:w-40 flex justify-between">
                                    <span>Gender</span><span>:</span>
                                </div>
                                <span class="ml-2">${user.gender === 0 ? 'Male' : 'Female'}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-32 sm:w-40 flex justify-between">
                                    <span>Phone Number</span><span>:</span>
                                </div>
                                <span class="ml-2">${user.phone_number}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-32 sm:w-40 flex justify-between">
                                    <span>Line ID</span><span>:</span>
                                </div>
                                <span class="ml-2">${user.line_id}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-32 sm:w-40 flex justify-between">
                                    <span>Consumption Type</span><span>:</span>
                                </div>
                                <span class="ml-2">${getConsumptionType(user.consumption_type)}</span>
                            </div>
                        </div>
                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                            ${user.food_allergy !== null && user.food_allergy !== "-" ? `
                                        <button class="w-full px-3 col-span-1 md:col-span-2 sm:px-5 py-2 sm:py-3 text-sm sm:text-base bg-blue-500 text-white rounded-md hover:bg-blue-600 transition"
                                            onclick="showTextModal('Food Allergy', '${user.food_allergy}')">Food Allergy</button>
                                            ` : ''}
                            ${user.drug_allergy !== null && user.drug_allergy !== "-" ? `
                                        <button class="w-full px-3 col-span-1 md:col-span-2 sm:px-5 py-2 sm:py-3 text-sm sm:text-base bg-green-500 text-white rounded-md hover:bg-green-600 transition"
                                            onclick="showTextModal('Drug Allergy', '${user.drug_allergy}')">Drug Allergy</button>
                                            ` : ''}
                            ${user.medical_history !== null && user.medical_history !== "-" ? `
                                        <button class="w-full px-3 col-span-1 md:col-span-2 sm:px-5 py-2 sm:py-3 text-sm sm:text-base bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition"
                                            onclick="showTextModal('Medical History', '${user.medical_history}')">Medical History</button>
                                            ` : ''}
                            ${user.student_card !== null && user.student_card !== "-" ? `
                                        <button class="w-full px-3 col-span-1 md:col-span-2 sm:px-5 py-2 sm:py-3 text-sm sm:text-base bg-orange-500 text-white rounded-md hover:bg-orange-600 transition"
                                            onclick="showImageModal('Student Card', '${user.student_card}')">Student Card</button>
                                            ` : ''}
                            ${user.twibbon !== null && user.twibbon !== "-" ? `
                                        <button class="w-full px-3 col-span-1 md:col-span-2 sm:px-5 py-2 sm:py-3 text-sm sm:text-base bg-red-500 text-white rounded-md hover:bg-red-600 transition"
                                            onclick="showImageModal('Twibbon', '${user.twibbon}')">Twibbon</button>
                                            ` : ''}
                        </div>
                    </div>
                `;
            });

            lastSwalContent = content;
            let width = window.matchMedia("(orientation: landscape)").matches ? '60%' : '80%';
            Swal.fire({
                title: 'Team Details',
                html: content,
                width: width,
                confirmButtonText: 'Close',
                confirmButtonColor: "#56843a",
            });
        }

        function getPosition(position) {
            const positions = ['Leader', '1st Member', '2nd Member', '3rd Member'];
            return positions[position] || 'Unknown';
        }

        function getConsumptionType(type) {
            const types = ['Normal', 'Vegetarian', 'Vegan'];
            return types[type] || 'Unknown';
        }

        function showTextModal(title, text) {
            Swal.fire({
                title: title,
                text: text,
                confirmButtonText: 'Close',
                confirmButtonColor: "#56843a",
            }).then(() => {
                if (lastSwalContent) {
                    Swal.fire({
                        title: 'Team Details',
                        html: lastSwalContent,
                        width: '80%',
                        confirmButtonText: 'Close',
                        confirmButtonColor: "#56843a",
                    });
                }
            });
        }

        function showImageModal(title, imagePath) {
            Swal.fire({
                title: title,
                imageUrl: `{{ asset('${imagePath}') }}`,
                imageAlt: title,
                confirmButtonText: 'Close',
                confirmButtonColor: "#56843a",
                imageWidth: 400,
            }).then(() => {
                if (lastSwalContent) {
                    Swal.fire({
                        title: 'Team Details',
                        html: lastSwalContent,
                        width: '80%',
                        confirmButtonText: 'Close',
                        confirmButtonColor: "#56843a",
                    });
                }
            });
        }
    </script>
@endSection
