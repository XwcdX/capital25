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

<section id="rules" class="relative h-screen w-screen bg-[var(--cap-green2)] overflow-hidden flex max-sm:flex-col items-center justify-center max-sm:space-y-4 sm:space-x-4">
    {{-- <h1 class="text-6xl lg:text-7xl text-[#14240a] z-[7] text-white font-oxanium font-black ">Rules</h1>     --}}
    <div class="w-[250px] h-[250px] md:w-[250px] flex flex-col items-center justify-center">
        <img src="{{ asset('assets/rules/guidebook.png')}}" alt="">
        <h1 class="font-oxanium font-black text-2xl md:text-3xl lg:text-4xl text-[#14240a]">Guidebook</h1>
    </div>

    <div class="w-[250px] h-[250px] md:w-[250px] flex flex-col items-center justify-center">
        <img src="{{ asset('assets/rules/rules.png')}}" alt="">
        <h1 class="font-oxanium font-black text-2xl md:text-3xl lg:text-4xl text-[#14240a]">Rules</h1>

    </div>

    <img class="sprouty absolute z-[20] bottom-0 right-0 w-[350px]" src="{{ asset('assets/rules/sprouty.png')}}" alt="">
</section>