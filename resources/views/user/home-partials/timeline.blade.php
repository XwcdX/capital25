<style>
    @keyframes pulseEffect {
        0% {
            transform: scale(0);
            opacity: 1;
        }

        100% {
            transform: scale(3);
            opacity: 0;
        }
    }

    .pulse {
        position: absolute;
        width: 20px;
        height: 20px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        transform: scale(0);
        animation: pulseEffect 0.6s ease-out;
    }
</style>

<section id="timeline" class="relative h-screen w-screen bg-[#14240a] z-[14] flex flex-col justify-center items-center">
    <h1 class="font-orbitron text-white">Click each boxes for more information</h1>
    <img src="{{ asset('assets/landing/daun-ijo.png') }}" alt="" loading="lazy"
        class="bush w-full scale-[2.5] sm:scale-[1.6] lg:scale-[1.1] object-cover absolute -top-[5%] sm:-top-[10%] md:-top-[8%] lg:-top-[10%] xl:-top-[12%] left-0 z-[14]">

    <div
        class="relative container h-[80%] md:h-[68%] xl:h-[70%] flex items-center justify-center overflow-hidden gap-[4%] 
        w-[90%] sm:w-[85%] lg:w-[80%] transition-all duration-500 mt-5">
        <div class="box relative h-full w-full overflow-hidden flex flex-col items-center justify-center [@media(max-width:400px)]:space-y-2 space-y-5 md:space-y-5 "
            id="leftBox">
            <img class="original-content w-[70px] sm:w-[80px] lg:w-[125px] xl:w-[150px]"
                src="{{ asset('assets/timeline/icon-mic.png') }}" alt="">
            <h1
                class="original-content text-white text-xl md:text-2xl font-extrabold w-[70%] text-center font-quicksand">
                Seminar & Technical Meeting</h1>

            <div
                class="hidden-content text-center w-[80%] sm:w-[80%] lg:w-3/4 hidden opacity-0 h-0 overflow-hidden transition-all duration-500 ease-in-out">
                <h1
                    class="timeline-title text-lg [@media(max-width:400px)]:text-xl sm:text-2xl lg:text-4xl font-oxanium text-black font-bold">
                </h1>
                <p
                    class="timeline-desc text-md [@media(max-width:400px)]:text-base sm:text-lg xl:text-xl font-quicksand text-black my-5 sm:my-5 xl:my-10">
                </p>
                <div class="datetime font-quicksand text-md sm:text-lg xl:text-xl  text-black">
                    <h1 class="timeline-date"></h1>
                    <h1 class="timeline-time"></h1>
                    <h1 class="timeline-loc"></h1>
                </div>
                {{-- <button class="rounded-3xl border border-black border-[2px] bg-transparent text-black font-quicksand font-bold px-5 py-2 mt-5">Guidebook</button> --}}
            </div>
        </div>
        <div class="box relative h-full w-full overflow-hidden flex flex-col items-center justify-center [@media(max-width:400px)]:space-y-2 space-y-5 md:space-y-5"
            id="centerBox">
            <img class="original-content w-[70px] sm:w-[80px] lg:w-[125px] xl:w-[150px]"
                src="{{ asset('assets/timeline/icon-recycle.png') }}" alt="">
            <h1
                class="original-content text-white text-xl md:text-2xl font-extrabold w-[70%] text-center font-quicksand ">
                Lifecycle <br>Simulation</h1>

            <div
                class="hidden-content text-center w-[80%] sm:w-[80%] lg:w-3/4 hidden opacity-0 h-0 overflow-hidden transition-all duration-500 ease-in-out">
                <h1
                    class="timeline-title text-lg [@media(max-width:400px)]:text-xl sm:text-2xl lg:text-4xl font-oxanium text-black font-bold">
                </h1>
                <p
                    class="timeline-desc text-md [@media(max-width:400px)]:text-base sm:text-lg xl:text-xl font-quicksand text-black my-5 sm:my-5 xl:my-10">
                </p>
                <div class="datetime font-quicksand text-md sm:text-lg xl:text-xl text-black">
                    <h1 class="timeline-date"></h1>
                    <h1 class="timeline-time"></h1>
                    <h1 class="timeline-loc"></h1>
                </div>
                <button
                    class="guidebook rounded-3xl border border-black border-[2px] bg-transparent text-black font-quicksand font-bold px-5 py-2 mt-5">Guidebook</button>
            </div>
        </div>
        <div class="box relative h-full w-full overflow-hidden flex flex-col items-center justify-center [@media(max-width:400px)]:space-y-2 space-y-5 md:space-y-5"
            id="rightBox">
            <img class="original-content w-[70px] sm:w-[80px] lg:w-[125px] xl:w-[150px]"
                src="{{ asset('assets/timeline/icon-container.png') }}" alt="">
            <h1
                class="original-content text-white text-xl md:text-2xl font-extrabold w-[70%] text-center font-quicksand">
                Talk Show & Awarding Ceremony</h1>

            <div
                class="hidden-content text-center w-[80%] sm:w-[80%] lg:w-3/4 hidden opacity-0 h-0 overflow-hidden transition-all duration-500 ease-in-out">
                <h1
                    class="timeline-title text-lg [@media(max-width:400px)]:text-xl sm:text-2xl lg:text-4xl font-oxanium text-white font-bold">
                </h1>
                <p
                    class="timeline-desc text-md [@media(max-width:400px)]:text-base sm:text-lg xl:text-xl font-quicksand text-white my-5 sm:my-5 xl:my-10">
                </p>
                <div class="datetime font-quicksand text-md sm:text-lg xl:text-xl text-white">
                    <h1 class="timeline-date"></h1>
                    <h1 class="timeline-time"></h1>
                    <h1 class="timeline-loc"></h1>
                </div>
                {{-- <button class="rounded-3xl border border-white border-[2px] bg-transparent text-white font-quicksand font-bold px-5 py-2 mt-5">Guidebook</button> --}}
            </div>
        </div>
        <button id="closeBtn"
            class="absolute top-4 right-4 bg-white/80 text-gray-900 p-2 text-lg rounded-full opacity-0 pointer-events-none transition-opacity duration-300">
            ❌
        </button>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const boxes = document.querySelectorAll(".box");
        let index = 0;
        let animationActive = true;

       /* function createMultiplePulses(box) {
            const pulseCount = Math.floor(Math.random() * 5) + 2;

            for (let i = 0; i < pulseCount; i++) {
                setTimeout(() => {
                    const pulse = document.createElement("span");
                    pulse.classList.add("pulse");
                    const rect = box.getBoundingClientRect();
                    const x = Math.random() * rect.width;
                    const y = Math.random() * rect.height;

                    pulse.style.left = `${x}px`;
                    pulse.style.top = `${y}px`;
                    box.appendChild(pulse);
                    setTimeout(() => {
                        pulse.remove();
                    }, 600);
                }, i * 100);
            }
        }*/

        // function cycleContent() {
        //     if (!animationActive) return;

        //     boxes.forEach((box) => {
        //         const img = box.querySelector("img.original-content");
        //         const title = box.querySelector("h1.original-content");
        //         if (img) img.style.display = "block";
        //         if (title) {
        //             title.style.transform = "rotate(0deg) scale(1)";
        //             title.style.opacity = "1";
        //             title.style.transition =
        //                 "opacity 1s ease-in-out, transform 1s ease-in-out, font-size 1s ease-in-out";
        //             title.textContent = title.dataset.originalText;
        //         }
        //     });

        //     const currentBox = boxes[index];
        //     const img = currentBox.querySelector("img.original-content");
        //     const title = currentBox.querySelector("h1.original-content");

        //     if (img) img.style.display = "none";
        //     if (title) {
        //         title.style.opacity = "0";
        //         setTimeout(() => {
        //             title.textContent = "CLICK HERE";
        //             title.style.transform = "rotate(45deg) scale(1.3)";
        //             title.style.opacity = "1";
        //             title.style.fontSize = "2rem";
        //             createMultiplePulses(currentBox);
        //         }, 500);
        //     }

        //     index = (index + 1) % boxes.length;

        //     setTimeout(cycleContent, 3000);
        // }

        boxes.forEach((box) => {
            const title = box.querySelector("h1.original-content");
            if (title) {
                title.dataset.originalText = title.textContent;
            }

            box.addEventListener("click", () => {
                animationActive = false;
                boxes.forEach((b) => {
                    const img = b.querySelector("img.original-content");
                    const t = b.querySelector("h1.original-content");
                    if (img) img.style.display = "block";
                    if (t) {
                        t.textContent = t.dataset.originalText;
                        t.style.transform = "rotate(0deg) scale(1)";
                        t.style.opacity = "1";
                        t.style.fontSize = "";
                    }
                });
            });
        });

        cycleContent();
    });
</script>
