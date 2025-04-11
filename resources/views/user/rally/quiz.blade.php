@extends('user.layout')

@section('style')
    <style>
        .quiz-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: var(--cap-green6);
            padding: 20px;
        }

        #submit-btn {
            display: none !important;
        }

        .submit-btn {
            background: var(--cap-green3);
            color: black;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            font-size: 18px;
        }

        .quiz-container {
            display: flex;
            /* flex-wrap: wrap; */
            flex-direction: row;
            width: 100%;
            min-height: 500px;
            max-width: 1180px;
            justify-content: space-between;
            align-items: flex-start;
            height: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            gap: 20px;
        }

        .question-box {
            flex: 2;
            background: var(--cap-green4);
            border-radius: 10px;
            padding: 20px;
            /* width: 65%; */
            min-height: 350px;
            color: white;
            font-size: 18px;
            /* margin-bottom: 1rem; */
        }

        .options label {
            margin: 15px 0;
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
            transition: 0.3s;
            font-size: 16px;
        }

        .options label:hover {
            font-weight: bold;
        }

        .options input[type="radio"]:checked+label {
            font-weight: bold;
            color: black;
            transform: scale(1.05);
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .sidebar {
            background: var(--cap-green4);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            /* width: 35%; */
            display: flex;
            flex-direction: column;
            /* align-items: center; */
            flex: 1;
            /* min-width: 200px; */
        }

        /* Grid nomor soal */
        .question-grid {
            display: grid;
            /* grid-template-columns: repeat(auto-fit, minmax(50px, 1fr)); */
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            width: 100%;
            padding: 10px;
        }

        .question-number {
            background: var(--cap-green3);
            color: white;
            padding: 12px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-weight: bold;
            transition: 0.3s;
            min-width: 50px;
        }

        .question-number.active {
            background: var(--cap-green1);
            color: black;
            transform: scale(1.1);
        }

        .timer {
            margin-top: 10px;
            font-weight: bold;
            font-size: 40px;
            color: white;
        }


        .finish-btn {
            background: red;
            color: white;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            font-size: 18px;
        }

        .back-btn,
        .next-btn {
            background: var(--cap-green2);
            color: white;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            font-size: 18x;
        }

        .quiz-title {
            text-align: center;
            font-size: 40px;
            font-weight: bold;
            color: white;
            margin-bottom: 15px;
        }

        /* Responsiveness */
        @media (max-width: 1200px) {
            .quiz-container {
                /* align-items: center; */
                min-width: 800px;
            }

            .question-box {
                width: 100%;
                min-height: auto;
                font-size: 18px;
            }

            .question-grid {
                grid-template-columns: repeat(5, 1fr);
            }

            .options p {
                font-size: 16px;
                padding: 8px;
            }

            .question-number {
                padding: 8px;
                font-size: 20px;
            }
        }

        @media (max-width: 900px) {
            .quiz-container {
                /* align-items: center; */
                min-width: 600px;
            }

            .question-box {
                width: 100%;
                min-height: auto;
                font-size: 18px;
                padding: 20px;
            }

            .question-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .options p {
                font-size: 18px;
                padding: 8px;
            }

            .question-number {
                padding: 8px;
                font-size: 18px;
            }

            .quiz-title {
                font-size: 30px;
            }
        }

        @media (max-width: 650px) {
            .quiz-container {
                align-items: center;
                padding: 15px;
                flex-direction: column;
                min-width: 450px;
            }

            .options p {
                font-size: 16px;
                padding: 6px;
            }

            .question-number {
                padding: 6px;
                font-size: 16px;
            }

            .quiz-title {
                font-size: 24px;
            }

            .finish-btn {
                font-size: 18px;
            }

            .sidebar {
                width: 100%;
            }

            .back-btn,
            .next-btn {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .quiz-container {
                padding: 15px;
                flex-direction: column;
                min-width: 250px;
            }

            .options p {
                font-size: 14px;
                padding: 6px;
            }

            .question-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .question-number {
                padding: 6px;
                font-size: 14px;
            }

            .finish-btn {
                font-size: 16px;
            }

            .back-btn,
            .next-btn {
                font-size: 14px;
            }
        }

        .swal-custom-button {
            background-color: rgb(122, 157, 221) !important;
            color: white !important;
            font-weight: bold;
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    <section id="quiz" class="relative w-screen h-screen">
        @if (!session()->has('quiz_end_time'))
            @include('user.rally.quizRules')
        @endif

        <div class="quiz-wrapper flex-col">
            <h2 class="quiz-title font-orbitron">Final Test Capital 2025</h2>
            <div class="quiz-container flex font-quicksand">
                <!-- Soal & Jawaban -->
                <div>
                    <div class="question-box ">
                        <h3 id="question-text">Loading...</h3>
                        <div class="options mt-2 space-y-2" id="options-container"></div>
                        <div class="navigation-buttons">
                            <button class="finish-btn" id="submit-btn" onclick="finishQuiz()" style="display: none;"></button>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <button class="back-btn w-28" onclick="previousQuestion()">Previous</button>
                        <button class="next-btn w-28" id="next-btn" onclick="nextQuestion()">Next</button>
                    </div>
                </div>


                <!-- Sidebar Navigasi & Timer -->
                <div class="sidebar">
                    <div class="question-grid" id="question-grid"></div>
                    <div class="timer" id="timer">00:00:00</div>
                    <button class="finish-btn" onclick="finishQuiz()">Finish Attempt</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        const quizRules = document.getElementById('quiz-rules');
        document.getElementById('start-quiz-btn').addEventListener('click', function() {
            fetch("{{ route('quiz.start') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    quizRules.classList.add('hidden');
                    console.log("Quiz End Time:", data.quiz_end_time);
                    Swal.fire({
                        title: "Quiz started!",
                        text: "You have 30 minutes to finish the quiz.",
                        icon: "info",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: 'swal-custom-button'
                        }
                    })
                    let quizEndTime = new Date(data.quiz_end_time);
                    startCountdown(quizEndTime);
                })
                .catch(error => console.error("Error starting quiz:", error));
        });
    </script>

    <script>
        let currentQuestion = 0;
        let questions = @json($questions);
        let answers = @json($answers);
        let storedAnswers = @json($storedAnswers ?? []); //when page refresh, the selected ans will appear
        const submitButton = document.getElementById("submit-btn");

        function loadQuestion() {
            // html
            const questionText = document.getElementById("question-text");
            const optionsContainer = document.getElementById("options-container");
            const nextButton = document.getElementById("next-btn");
            const currentQ = questions[currentQuestion];

            questionText.innerHTML = `${currentQuestion + 1}. ${currentQ.question}`;
            questionText.classList.add("font-bold");
            optionsContainer.innerHTML = "";

            let filteredAnswers = answers[currentQ.id] || [];
            // const optionLabels = ["A", "B", "C", "D"]; //optional

            filteredAnswers.forEach((answer, index) => {
                let isChecked = storedAnswers[currentQ.id] == answer.id ? "checked" :
                    ""; //to store user previous ans as checked

                let option = document.createElement("div");
                option.classList.add("option");
                option.innerHTML = `
                   <input type="radio" name="answer" id="option${index}" value="${answer.id}" 
                        onchange="tempAnswer('${currentQ.id}', '${answer.id}')" ${isChecked}>
                    <label class="!text-white" for="option${index}">
                        ${answer.answer_text}
                    </label>
                `;
                // <strong>${optionLabels[index]}.</strong> ${answer.answer_text}
                optionsContainer.appendChild(option);
            });

            nextButton.style.display = currentQuestion === questions.length - 1 ? "none" : "inline-block";
            submitButton.style.display = currentQuestion === questions.length - 1 ? "inline-block" : "none";

            updateQuestionGrid();
        }

        function tempAnswer(question_id, answer_id) {
            fetch("{{ route('quiz.save') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        question_id: question_id,
                        answer_id: answer_id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    storedAnswers = data.storedAnswers;
                })
                .catch(error => console.error("Error saving answer:", error));
        }

        function selectAnswer(index) {
            alert(`Anda memilih: ${questions[currentQuestion].options[index]}`);
        }

        function nextQuestion() {
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                loadQuestion();
            }
        }

        function previousQuestion() {
            if (currentQuestion > 0) {
                currentQuestion--;
                loadQuestion();
            }
        }

        function finishQuiz(autoSubmit = false) {
            let answers = Object.values(storedAnswers);

            if (autoSubmit) {
                // Auto-submit tanpa konfirmasi
                submitQuiz(answers);
            } else {
                // Konfirmasi sebelum submit
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once submitted, you cannot change your answers!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, submit!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitQuiz(answers);
                    }
                });
            }
        }

        // Fungsi terpisah untuk submit quiz ke server
        function submitQuiz(answers) {
            fetch("{{ route('quiz.submit') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        answers
                    })
                })
                .then(response => response.json())
                .then(data => {
                     Swal.fire({
                        title: "Quiz Submitted!",
                        text: "Your answers have been recorded.",
                        icon: "success",
                        confirmButtonText: "OK",
                        confirmButtonColor: "3085d6",
                    }).then(() => {
                        window.location.href = "{{ route('home') }}";
                    });
                })
                .catch(error => console.error("Error submitting quiz:", error));
        }


        function updateQuestionGrid() {
            const questionGrid = document.getElementById("question-grid");
            questionGrid.innerHTML = "";
            for (let i = 0; i < questions.length; i++) {
                const questionNumber = document.createElement("div");
                questionNumber.textContent = i + 1;
                questionNumber.classList.add("question-number");
                if (i === currentQuestion) {
                    questionNumber.classList.add("active");
                }
                questionNumber.onclick = () => {
                    currentQuestion = i;
                    loadQuestion();
                };
                questionGrid.appendChild(questionNumber);
            }
        }

        function startCountdown(endTime) {
            let timerDisplay = document.getElementById("timer");

            function updateTimer() {
                let now = new Date();
                let remainingTime = Math.max(0, endTime - now); // Ensure non-negative value

                let minutes = Math.floor(remainingTime / (1000 * 60));
                let seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                // Display time
                timerDisplay.innerHTML = `00:${minutes}:${seconds}`;

                if (remainingTime <= 0) {
                    clearInterval(timerInterval);
                    timerDisplay.innerHTML = "Time's up!";
                    Swal.fire({
                        text: "Time is up! Submitting quiz...",
                        icon: "warning",
                        confirmButtonText: "OK!"
                    })
                    // Auto-submit logic can be added here
                    finishQuiz(true);
                }
            }

            updateTimer(); // Run immediately to prevent 1-second delay
            let timerInterval = setInterval(updateTimer, 1000);
        }
        window.onload = () => {
            loadQuestion();
            const display = document.getElementById("timer");
            // startTimer(30 * 60, display);
        };

        // langsung ke hlm quiz tanpa melalui quizRules jika sudah pernah klik start sebelumnya 
        document.addEventListener("DOMContentLoaded", function() {
            // if (localStorage.getItem("quizStarted")) {
            //     document.getElementById('quiz-rules').classList.add('hidden');
            // } else {
            //     document.getElementById('quiz-rules').classList.remove('hidden');
            // }
        });

        document.getElementById('start-quiz-btn').addEventListener('click', function() {
            fetch("{{ route('quiz.start') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('quiz-rules').classList.add('hidden');

                    let quizEndTime = new Date(data.quiz_end_time);
                    startCountdown(quizEndTime);
                })
                .catch(error => console.error("Error starting quiz:", error));
        });
    </script>
@endsection
