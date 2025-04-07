<style>
    .rule {
        transform: scale(1);
        transition: all .2s ease-out;

    }

    .rule:hover, .fa-lock:hover {
        transform: scale(1.2);
        transition: all .2s;
    }

    .brightness-75 {
        transition: filter 0.25s ease-in;
    }
</style>

<section id="rules"
    class="relative h-screen w-screen bg-[var(--cap-green3)] overflow-hidden flex flex-col items-center md:items-start justify-center p-20">
    {{-- <h1 class="text-6xl lg:text-7xl text-[#14240a] z-[7] text-white font-oxanium font-black ">Rules</h1>     --}}
    <div class="flex max-md:flex-col max-md:space-y-16 md:space-x-8 lg:space-x-20 xl:space-x-28 md:ml-4 lg:ml-12 [@media(min-width:1350px)]:ml-40"
        data-aos="fade-left" data-aos-duration="1000">
        <div class="w-[150px] md:w-[200px] lg:w-[250px] xl:w-[300px] flex flex-col items-center justify-center relative">
            <img id="guidebook-img" class="guidebook relative peer cursor-pointer hover:scale-[1.2] scale-[1] transition-all duration-200  filter"
                src="{{ asset('assets/rules/guidebook.png') }}" alt="">
            <h1
                class="peer-hover:translate-y-8 transition-all duration-200  [text-shadow:0_0_10px_rgba(255,243,102,0.8)] 
            peer-hover:[text-shadow:0_0_20px_rgba(255,243,102,1)] peer-hover:animate-pulse
            font-oxanium font-black text-2xl md:text-3xl lg:text-4xl text-white">
                Guidebook</h1>
            <i class="fa-solid fa-lock absolute inset-0 flex items-center justify-center text-white 
                w-full h-full text-[5rem] md:text-[7rem] lg:text-[9rem] leading-none 
                opacity-0 transition-opacity duration-1000 cursor-pointer"
                id="guidebookLock"></i>
        </div>

        <div class="w-[150px] md:w-[200px] lg:w-[250px] xl:w-[300px] flex flex-col items-center justify-center"
            data-aos="fade-left" data-aos-duration="1000">
            <img id="rules-img" class="rules peer cursor-pointer hover:scale-[1.2] scale-[1] transition-all duration-200"
                src="{{ asset('assets/rules/rules.png') }}" alt="">
            <h1 class="peer cursor-pointer hover:scale-[1.2] scale-[1] transition-all duration-200"
                src="{{ asset('assets/rules/guidebook.png') }}" alt="">
                <h1
                    class="peer-hover:translate-y-8 transition-all duration-200  [text-shadow:0_0_10px_rgba(255,243,102,0.8)] 
                peer-hover:[text-shadow:0_0_20px_rgba(255,243,102,1)] peer-hover:animate-pulse
                font-oxanium font-black text-2xl md:text-3xl lg:text-4xl text-white">
                    Rules</h1>
                <i class="fa-solid fa-lock absolute inset-0 flex items-center justify-center text-white 
                    w-full h-full text-[5rem] md:text-[7rem] lg:text-[9rem] leading-none 
                    opacity-0 transition-opacity duration-1000 cursor-pointer "
                    id="rulesLock"></i>
        </div>
    </div>

    <img class="sprouty absolute z-[20] bottom-0 md:bottom-[15%] lg:bottom-[5%] xl:bottom-0 right-0 w-[165px] md:w-[250px] lg:w-[350px] xl:w-[450px]"
        src="{{ asset('assets/rules/sprouty.png') }}" alt="" data-aos="fade-left" data-aos-offset="-300">
</section>

<script>
    const guidebook = document.getElementById('guidebook-img');
    const rules = document.getElementById('rules-img');
    function showLockMessage(lockElement, img) {
        Swal.fire({
            icon: 'error',
            title: 'Locked',
            text: 'Rules will be unlocked after the technical meeting!',
            showConfirmButton: true,
            confirmButtonColor: "#56843a",
        }).then(() => {
            lockElement.classList.remove('opacity-0');
            lockElement.classList.remove('animate-shake'); 
            void lockElement.offsetWidth; 
            lockElement.classList.add('animate-shake');
            setInterval(() => {
                img.classList.add('brightness-75');
                lockElement.classList.toggle('opacity-0');
            }, 1000);
        });
    }

    document.getElementById("guidebookLock").addEventListener("click", function () {
        showLockMessage(this, guidebook);
    });

    document.getElementById("rulesLock").addEventListener("click", function () {
        showLockMessage(this, rules);
    });
</script>
