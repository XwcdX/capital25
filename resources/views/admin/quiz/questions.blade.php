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

        #datatable {
            table-layout: fixed;
            width: 100%;
        }

        #datatable td:nth-child(2),
        #datatable th:nth-child(2) {
            white-space: normal; 
            word-wrap: break-word; 
            overflow-wrap: break-word;
        }
        textarea {
            scrollbar-width: none; 
            -ms-overflow-style: none;
        }

        textarea::-webkit-scrollbar {
            display: none;
        }
    </style>
@endSection

@section('content')
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
        <h1 class="text-center text-4xl uppercase font-bold mb-2">Quiz Questions</h1>
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
            {{-- <a href="{{route('export.registeredTeam')}}" target="_blank">
                <button type="button" data-te-ripple-init data-te-ripple-color="light"
                    class="save w-full inline-block rounded bg-success px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Download Excel
                </button>
            </a> --}}
        </div>
        <div id="datatable" class="w-full h-full px-5 py-5" data-te-max-height="460" data-te-fixed-header="true"></div>
    </div>
@endsection()

@section('script')
    <script>
        const customDatatable = document.getElementById("datatable");
        let data = @json($groupedQuestions, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        data = typeof data === 'string' ? JSON.parse(data) : data;
        console.log(data);
        let questions = data.map((dt, index) => ({
            index: index + 1,  
            name: dt.question,  
            answer: `
                <button class="answer-btn bg-green-700 hover:bg-green-800 w-20 text-white py-1 rounded-lg" 
                    onclick='showAnswers(${JSON.stringify(dt.choices)}, "${dt.correct}")'>View<br> Choices</button>
            `,
            actions: `
                <div class="flex flex-col space-y-2">
                    <button class="edit-btn bg-blue-700 hover:bg-blue-800 w-16 text-white py-1 rounded-lg" 
                        onclick="editQuestion('${dt.id}', '${dt.question}')">Edit</button>
                    <button class="delete-btn bg-[#d33] hover:bg-red-800 w-16 text-white py-1 rounded-lg" 
                        onclick="deleteQuestion(${index})">Delete</button>
                </div>
            `
        }));

        const instance = new te.Datatable(
            customDatatable, {
                columns: [{
                        label: "No.",
                        field: "index",
                        sort: false, 
                        attributes: { style: "width: 50px; text-align: center;" }
                    },
                    {
                        label: "Question",
                        field: "name",
                        sort: false,
                        // attributes: { style: "width: 150px !important; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" }
                    },
                    {
                        label: "Answer",
                        field: "answer",
                        sort: false,
                        html: true
                    },
                    {
                        label: "Actions",
                        field: "actions",
                        sort: false,
                        html: true
                    }
                ],
                rows: questions,
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

        function showAnswers(choices, correctAns) {
            const labels = ["A", "B", "C", "D"];
            Swal.fire({
                title: "Answer Choices",
                width: 600,
                html: choices.map((choice, index) =>
                    `<p>${labels[index]}. ${choice.text === correctAns ? `<b>${choice.text}</b>` : choice.text}</p> <br>`
                ).join(""),
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Edit",
                cancelButtonText: "Close",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    editChoices(choices, correctAns);
                }
            });
        }

        function editChoices(choices, correctAns) {
            Swal.fire({
                title: "Edit Answer Choices",
                html: `
                        <div>
                        ${choices.map((choice, index) => `
                            <div class="flex items-center">
                                <label class="font-bold">${String.fromCharCode(65 + index)}:</label>
                                <textarea id="choice-${choice.id}" class="swal2-textarea !m-2 !w-[90%] !h-24 !text-base"
                                    placeholder="Choice ${String.fromCharCode(65 + index)}">${choice.text}</textarea>
                            </div>
                        `).join("")}

                        <div class="flex items-center mt-3">                       
                            <h1>Correct Answer</h1>
                            <select id="correctChoice" class="swal2-select">
                                ${choices.map(choice => `
                                    <option value="${choice.id}" ${choice.correct ? "selected" : ""}>
                                        ${String.fromCharCode(65 + choices.indexOf(choice))}
                                    </option>
                                `).join("")}
                            </select>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: "Save",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                preConfirm: () => {
                    const updatedChoices = choices.map(choice => ({
                        id: choice.id,
                        answer_text: document.getElementById(`choice-${choice.id}`).value.trim()
                    }));

                    const newCorrectAnsId = document.getElementById("correctChoice").value;

                    if (updatedChoices.some(choice => choice.text === "")) {
                        Swal.showValidationMessage("All choices must be filled!");
                        return false;
                    }

                    return { updatedChoices, newCorrectAnsId };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('admin.editAnswer') }}", { 
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },  
                        body: JSON.stringify({
                            choices: result.value.updatedChoices,
                            correct_answer_id: result.value.newCorrectAnsId,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire("Success!", "Choices have been updated.", "success");
                    })
                    .catch(error => {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    });
                }
            });
        }

        function editQuestion(id, question) {
            Swal.fire({
                title: "Edit the Question",
                input: "text",
                inputLabel: "New Question:",
                inputValue: question, 
                showCancelButton: true,
                confirmButtonText: "Update",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                preConfirm: (newQuestion) => {
                    if (!newQuestion) {
                        Swal.showValidationMessage("Question cannot be empty!");
                        return false;
                    }
                    return newQuestion;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('admin.editQuestion', '__ID__') }}`.replace('__ID__', id), {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            question: result.value,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: "Updated!",
                                text: data.message,
                                icon: "success",
                                confirmButtonColor: "#3085d6"
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Error!", data.message, "error");
                        }
                    })
                    .catch(error => {
                        Swal.fire("Error!", "Something went wrong!", "error");
                    });
                }
            });
        }

        function deleteQuestion(id){
            
        }
    </script>
@endSection
