
    <section id="quiz-rules" class="absolute inset-0 w-screen h-screen flex items-center justify-center z-[10]">
        <div class="absolute bg-black opacity-70 inset-0 z-[10]"></div>

        <div class="relative z-[11] w-[70%] h-3/4 bg-white rounded-2xl flex flex-col items-center justify-center space-y-8">
            <h1 id="rules-title" class="font-bold text-4xl text-[var(--cap-green4)] font-orbitron">PERATURAN</h1>
            <div id="rules-set" class="w-3/4 h-[60%] overflow-y-auto font-quicksand my-4">
                <ol class="list-decimal list-inside space-y-2">
                    @foreach (\App\Enums\QuizRules::cases() as $rule)
                        <li class="text-xl">{!! $rule->value !!}</li>
                    @endforeach
                </ol>
            </div>

            <div class="buttons flex space-x-5 font-quicksand">
                <button id="start-quiz-btn" class="uppercase font-bold text-white py-2 px-8 bg-[var(--cap-green5)] rounded-full border border-[var(--cap-green5)] transition duration-300 hover:-translate-y-1">START</button>
                <button onclick class="uppercase font-bold text-[var(--cap-green5)] py-2 px-8 border border-[var(--cap-green5)] rounded-full transition duration-300 hover:-translate-y-1">BACK</button>
            </div>
        </div>
    </section>
