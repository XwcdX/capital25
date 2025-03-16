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

        .quiz-container {
            display: flex;
            flex-direction: row;
            min-width: 1180px;
            min-height: 500px;
            justify-content: space-between;
            align-items: flex-start;
            height: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            flex-wrap: wrap;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            gap: 20px;
        }

        .question-box {
            flex-grow: 2;
            background: var(--cap-green4);
            border-radius: 10px;
            padding: 20px;
            min-width: 65%;
            min-height: 250px;
            color: white;
            font-size: 24px;
        }

        .options p {
            margin: 15px 0;
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
            background: var(--cap-green3);
            transition: 0.3s;
            font-size: 24px;
        }

        .options p:hover {
            background: var(--cap-green2);
            color: black;
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
            min-width: 30%;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
            min-width: 200px;
        }

        /* Grid nomor soal */
        .question-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(50px, 1fr));
            gap: 8px;
            width: 100%;
            padding: 10px;
        }

        .question-number {
            background: var(--cap-green3);
            color: white;
            padding: 12px;
            font-size: 24px;
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

        .finish-btn,
        .back-btn,
        .next-btn {
            background: var(--cap-green2);
            color: white;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            font-size: 20px;
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
                align-items: center;
                min-width: 800px;
            }

            .question-box {
                width: 100%;
                min-height: auto;
                font-size: 20px;
            }

            .sidebar {
                width: 100%;
                margin-top: 20px;
            }

            .question-grid {
                grid-template-columns: repeat(5, 1fr);
            }

            .options p {
                font-size: 20px;
                padding: 8px;
            }

            .question-number {
                padding: 8px;
                font-size: 20px;
            }
        }

        @media (max-width: 900px) {
            .quiz-container {
                align-items: center;
                min-width: 600px;
            }

            .question-box {
                width: 100%;
                min-height: auto;
                font-size: 18px;
                padding: 20px;
            }

            .sidebar {
                width: 100%;
                margin-top: 20px;
            }

            .question-grid {
                grid-template-columns: repeat(5, 1fr);
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
                padding: 15px;
                flex-direction: column;
                min-width: 450px;
            }

            .options p {
                font-size: 16px;
                padding: 6px;
            }

            .question-grid {
                grid-template-columns: repeat(4, 1fr);
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
    </style>
@endsection

@section('content')
    <section id="quiz" class="relative w-screen h-screen">
        @include('user.rally.quizRules')
        <div class="quiz-wrapper">
            <div>
                <h2 class="quiz-title">Final Test Capital 2025</h2>
                <div class="quiz-container">
                    <!-- Soal & Jawaban -->
                    <div class="question-box">
                        <h3 id="question-text">Loading...</h3>
                        <div class="options" id="options-container"></div>
                        <div class="navigation-buttons">
                            <button class="back-btn" onclick="previousQuestion()">Previous</button>
                            <button class="next-btn" id="next-btn" onclick="nextQuestion()">Next</button>
                            <button class="finish-btn" id="submit-btn" onclick="finishQuiz()"
                                style="display: none;">Submit</button>
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
                alert("Quiz started! You have 30 minutes.");

                let quizEndTime = new Date(data.quiz_end_time);
                startCountdown(quizEndTime);
            })
            .catch(error => console.error("Error starting quiz:", error));
        });
    </script>
    
    <script>
        let currentQuestion = 0;

        function loadQuestion() {
            const questionText = document.getElementById("question-text");
            const optionsContainer = document.getElementById("options-container");
            const nextButton = document.getElementById("next-btn");
            const submitButton = document.getElementById("submit-btn");

            questionText.textContent = `${currentQuestion + 1}. ${questions[currentQuestion].text}`;
            optionsContainer.innerHTML = "";
            questions[currentQuestion].options.forEach((option, index) => {
                const optionElement = document.createElement("p");
                optionElement.textContent = `${String.fromCharCode(97 + index)}. ${option}`;
                optionElement.onclick = () => selectAnswer(index);
                optionsContainer.appendChild(optionElement);
            });

            nextButton.style.display = currentQuestion === questions.length - 1 ? "none" : "inline-block";
            submitButton.style.display = currentQuestion === questions.length - 1 ? "inline-block" : "none";

            updateQuestionGrid();
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

        function finishQuiz() {
            alert("Quiz selesai!");
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
                timerDisplay.innerHTML = `Time Left: ${minutes}m ${seconds}s`;

                if (remainingTime <= 0) {
                    clearInterval(timerInterval);
                    timerDisplay.innerHTML = "Time's up!";
                    alert("Time is up! Submitting quiz...");
                    // Auto-submit logic can be added here
                }
            }

            updateTimer(); // Run immediately to prevent 1-second delay
            let timerInterval = setInterval(updateTimer, 1000);
        }
        window.onload = () => {
            // loadQuestion();
            const display = document.getElementById("timer");
            // startTimer(30 * 60, display);
        };
    </script>
@endsection
