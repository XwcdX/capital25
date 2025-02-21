<style>
.dropdown-wrapper{
    padding-inline:2rem;
    max-height:0;
    overflow:hidden;
    transition:max-height 0.5s ease-in-out;
    font-size:0.9rem;
}

.dropdown-wrapper.active{
  max-height:1000px;
}
/* 
#faqs{
    scrollbar-width: thin;
} */
</style>

<section id="faq" class="relative h-screen w-screen bg-[#14240a] flex flex-col items-center justify-center p-4 lg:p-10">
    <h1 class="font-oxanium text-4xl md:text-5xl lg:text-7xl text-[#dad7cf] text-center font-extrabold mb-12">Frequently Asked Question</h1>
    
    <div id="faqs" class="grid grid-cols-1 rounded-xl md:grid-cols-1 gap-6 p-6 md:p-12 w-[full] lg:w-[80%] bg-[#82b741] h-[70%] overflow-y-auto">

    </div>    
    
    {{-- <svg id="toggleBtn" class="absolute bottom-5 left-1/2 transform -translate-x-1/2 arrow cursor-pointer" xmlns="http://www.w3.org/2000/svg" 
    width="24" height="24" fill="#dad7cf"><path d="M12 17.414 3.293 8.707l1.414-1.414L12 14.586l7.293-7.293 1.414 1.414L12 17.414z"/>
    </svg> --}}
</section>