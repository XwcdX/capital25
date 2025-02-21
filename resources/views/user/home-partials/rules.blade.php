<style>
 .rule {
    transform: scale(1);
    transition: all .2s ease-out;

}
.rule:hover {
    transform: scale(1.2);
    transition: all .2s;
}
</style>

<section id="rules" class="relative h-screen w-screen bg-[var(--cap-green3)] overflow-hidden flex flex-col items-start justify-center p-20">
    {{-- <h1 class="text-6xl lg:text-7xl text-[#14240a] z-[7] text-white font-oxanium font-black ">Rules</h1>     --}}
    <div class="flex max-sm:flex-col max-sm:space-y-4 sm:space-x-28 ml-40">
        <div class="w-[250px] h-[250px] md:w-[300px] flex flex-col items-center justify-center">
            <img class="guidebook peer cursor-pointer hover:scale-[1.2] scale-[1] transition-all duration-200" src="{{ asset('assets/rules/guidebook.png')}}" alt="">
            <h1 class="peer-hover:translate-y-8 transition-all duration-200  [text-shadow:0_0_10px_rgba(255,243,102,0.8)] 
            peer-hover:[text-shadow:0_0_20px_rgba(255,243,102,1)] peer-hover:animate-pulse
            font-oxanium font-black text-2xl md:text-3xl lg:text-4xl text-white">Guidebook</h1>
        </div>

        <div class="w-[250px] h-[250px] md:w-[300px] flex flex-col items-center justify-center">
            <img class="rules peer cursor-pointer hover:scale-[1.2] scale-[1] transition-all duration-200" src="{{ asset('assets/rules/rules.png')}}" alt="">
            <h1 class="peer cursor-pointer hover:scale-[1.2] scale-[1] transition-all duration-200" src="{{ asset('assets/rules/guidebook.png')}}" alt="">
                <h1 class="peer-hover:translate-y-8 transition-all duration-200  [text-shadow:0_0_10px_rgba(255,243,102,0.8)] 
                peer-hover:[text-shadow:0_0_20px_rgba(255,243,102,1)] peer-hover:animate-pulse
                font-oxanium font-black text-2xl md:text-3xl lg:text-4xl text-white">Rules</h1>
    </div> 
    </div>
   
    <img class="sprouty absolute z-[20] bottom-0 right-0 w-[450px]" src="{{ asset('assets/rules/sprouty.png')}}" alt=""
    data-aos="fade-left" data-aos-offset="-300">
</section>