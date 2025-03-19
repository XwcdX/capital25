<style>
.abt-stroke {
    -webkit-text-stroke: 5px rgba(255, 255, 255, 0.9);
    paint-order: stroke fill;
    line-height: 1.4; 
}   

@media (max-width: 768px) {
    .abt-stroke {
        -webkit-text-stroke: 2px rgba(255, 255, 255, 0.9);
        line-height: 1.2; 
    }
}
</style>

<section id="aboutUs" class="relative h-screen w-screen z-[13] p-10 lg:p-16 xl:p-28 flex items-center justify-center
 font-league overflow-visible">
    <img src="{{ asset('assets/landing/waterfall.png')}}" alt="" loading="eager"  
    class="waterfall w-full h-[120vh] object-cover lg:object-fill absolute -top-[20%] left-0 z-[14] ">

    {{-- overlay --}}
    <div class="overlay h-[120vh] absolute -top-[20%] left-0 right-0 bottom-0 bg-black opacity-0 z-[15]"></div>

    {{-- <img src="{{ asset('assets/landing/daun-ijo.png')}}" alt="" loading="lazy" 
    class="bush w-[150vh] md:w-[150%] lg:w-full xl:w-full object-cover absolute -bottom-[10%] left-0 z-[23]"> --}}

    <div class="flex max-md:flex-col max-md:flex-col-reverse z-[16] justify-center space-x-4 w-full xl:w-[90%]">
        {{-- moni --}}
        <img  class="hidden md:block object-cover h-[200px] md:h-[350px] lg:h-[500px] my-auto moni" src=" {{ asset('assets/about/moni.png')}}" alt="">
        <img class="moni block md:hidden absolute z-[16] h-[300px] -bottom-[30%] left-1/2 -translate-x-1/2 object-cover"
         src="{{ asset('assets/about/moni.png')}}" alt="">

        <div class="about-us flex flex-col justify-center max-md:text-center">
            <h1 data-aos="fade-left" data-aos-duration="1000" class="abt-stroke text-6xl md:text-7xl lg:text-7xl xl:text-8xl text-[#14240a] z-[16] text-[#608343] font-league font-black text-center md:text-left">About Us</h1>
            <h1 data-aos="fade-down" data-aos-duration="1500" class="abt-stroke text-lg md:text-xl xl:text-2xl z-[6] text-[#608343] font-bold mt-4 md:mt-12 md:mt-4 lg:mt-8 tracking-wider text-center md:text-left">
                Rangkaian acara CAPITAL 2025 memberikan kesempatan bagi siswa dan siswi SMA untuk berkolaborasi, berpikir strategis, serta mempersiapkan diri menjadi entrepreneur masa depan yang mampu menghadapi tantangan global. Dengan menggabungkan kompetisi yang menantang dan sesi diskusi yang inspiratif, CAPITAL 2025 bertujuan menciptakan generasi Ecopreneurs yang tidak hanya inovatif, tetapi juga bertanggung jawab secara sosial dan lingkungan.
            </h1>
        </div> 
    </div>
</section>