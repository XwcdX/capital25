<style>
    .price {
        transform: scale(1);
        transition: all .2s ease-out;

    }
    .price:hover {
        transform: scale(1.2);
        transition: all .2s;
    }
</style>

<section id="prizepool" class="h-screen w-screen bg-[var(--cap-green2)] flex flex-col items-center justify-center ">
    <h1 class="font-oxanium text-4xl md:text-5xl lg:text-7xl text-white text-center font-extrabold mb-12">Prizepool</h1>
    <div class="flex items-center justify-center w-[95%] sm:w-full mb-5 sm:mb-16 space-x-5 sm:space-x-16">
        <div class="group flex flex-col text-center space-y-2 " data-aos="fade-down-right" data-aos-duration="1000">
            <h1 class="group-hover:text-amber-500 group-hover:-translate-y-2 font-oxanium text-white text-2xl sm:text-3xl lg:text-5xl transition-all duration-200">1st Place</h1>
            <h1 class="price font-quicksand font-bold p-3 sm:p-6 bg-[#a8c747] text-white rounded-3xl text-2xl sm:text-3xl lg:text-5xl">
                IDR 3.0 Mio ++
            </h1>
        </div>
        <div class="group flex flex-col text-center space-y-2"  data-aos="fade-down-left" data-aos-duration="1000">
            <h1 class="group-hover:text-gray-400 group-hover:-translate-y-2 font-oxanium text-white text-2xl sm:text-3xl lg:text-5xl transition-all duration-200">2nd Place</h1>
            <h1 class="price font-quicksand font-bold p-3 sm:p-6 bg-[#82b741] text-white rounded-3xl text-2xl sm:text-3xl lg:text-5xl">
                IDR 2.0 Mio ++
            </h1>
        </div>
    </div>
    <div class="group flex flex-col items-center justify-center w-full space-y-2" data-aos="fade-up-left" data-aos-duration="1000">
        <h1 class="group-hover:text-amber-800 group-hover:-translate-y-2 font-oxanium text-white text-2xl sm:text-3xl lg:text-5xl transition-all duration-200">3rd Place</h1>
            <h1 class="price font-quicksand font-bold p-3 sm:p-6 bg-[#56843a] text-white rounded-3xl text-2xl sm:text-3xl lg:text-5xl">
                IDR 1.0 Mio ++
            </h1>
    </div>
</section>