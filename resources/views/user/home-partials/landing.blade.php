<section id="landing" class="relative h-screen w-screen bg-[#a8d3fb] overflow-hidden flex items-center justify-start p-12 sm:p-20 lg:p-28" data-parallax-layers>
    <img src="{{ asset('assets/landing/cloud-1.png')}}" alt=""  loading="eager" data-parallax-layer="1" 
    class="layer10 max-md:w-[275px] md:w-[350px] lg:w-[500px] xl:w-[550px] absolute max-md:top-0 max-md:-right-[20%] md:-top-[17%] md:-right-[25%] lg:-right-[20%] lg:-right-[5%] xl:-top-[35%] xl:-right-[20%] z-[0]">
    <img src="{{ asset('assets/landing/cloud-2.png')}}" alt=""  loading="eager" data-parallax-layer="1" 
    class="layer9 max-md:w-[275px] md:w-[350px] lg:w-[500px] xl:w-[550px] absolute  bottom-[50%]  md:bottom-[35%] lg:bottom-[20%] lg:left-[17%] z-[0]">
    <img src="{{ asset('assets/landing/cloud-3.png')}}" alt=""  loading="eager" data-parallax-layer="1" 
    class="layer10 max-md:w-[275px] md:w-[400px] lg:w-[500px] xl:w-[550px] absolute bottom-[50%] md:bottom-[30%] md:right-[8%] lg:bottom-[20%] lg:right-[14%] z-[0]">
    <img src="{{ asset('assets/landing/cloud-4.png')}}" alt=""  loading="eager" data-parallax-layer="2" 
    class="layer9 max-sm:w-[200px] sm:w-[250px] lg:w-[275px] xl:w-[275px] absolute -top-[5%] sm:-top-[10%] left-[25%] sm:left-[20%] md:left-[30%] z-[0]">
    <img src="{{ asset('assets/landing/cloud-5.png')}}" alt=""  loading="eager" data-parallax-layer="1" 
    class="layer10 max-lg:w-[200px] lg:w-[250px] xl:w-[350px] absolute top-[10%] -left-[20%] md:-left-[3%] z-[0]">
    
    {{-- sun --}}
    <img src="{{ asset('assets/landing/cahaya-sun.png')}}" alt="" loading="eager"  
    class=" w-full absolute top-0 left-0 z-[2] opacity-40">
    <img src="{{ asset('assets/landing/Sun.png')}}" alt="" loading="eager" 
    class="opacity-75 max-md:w-[300px] md:w-[400px] lg:w-[500px] xl:w-[600px] absolute -top-[15%] -left-[25%] md:-top-[30%] md:-left-[23%] lg:-top-[15%] lg:-left-[20%] xl:-top-[40%] xl:-left-[20%] z-[5]">

    {{-- city and backgrass --}}
    <img src="{{ asset('assets/landing/backgrass.png')}}" alt=""  loading="eager"  data-parallax-layer="4" 
    class="layer8 w-full h-full object-cover absolute bottom-0 left-0 z-[2]">
    <img src="{{ asset('assets/landing/City-without-back-grass.png')}}" alt=""  loading="eager"  data-parallax-layer="5" 
    class="layer7 w-full h-full object-cover absolute bottom-0 left-0 z-[3]">

    {{-- overlay --}}
    <div class="absolute inset-0 bg-black z-[2] opacity-20"></div>
    <div class="absolute inset-0 bg-black z-[4] opacity-15" data-parallax-layer="overlay"></div>
    
    {{-- gunung --}}
    <img src="{{ asset('assets/landing/gunung-back.png')}}" alt=""  loading="eager"  data-parallax-layer="6" 
    class="layer8 w-full h-screen object-cover absolute -bottom-[5%] left-0 z-[5]">
    <img src="{{ asset('assets/landing/gunung-front.png')}}" alt=""  loading="eager"  data-parallax-layer="7" 
    class="layer7 w-full h-screen object-cover absolute -bottom-[5%] left-0 z-[6]">
        
    {{-- title --}}
    <div class="flex flex-col">
        <h1 class="landing-title text-6xl sm:text-7xl lg:text-8xl uppercase z-[7] text-white font-oxanium font-black">CAPITAL 2025</h1>
        <h1 class="landing-title max-sm:mt-2 text-3xl lg:text-4xl xl:text-5xl z-[7] text-white font-oxanium font-black">Breaking the Loop for Sustainable Future</h1>
    </div>

</section>