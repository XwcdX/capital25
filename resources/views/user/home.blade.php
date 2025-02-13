@extends('user.layout')


@section('style')
<style>
.fade-out {
    opacity: 0;
    transition: opacity 0.5s ease-out;
    display: hidden;
}

.box {
    flex: 1;
    color: white;
    cursor: pointer;
    transition: background 0.3s;
}
.container {
    border-radius: 40px;
    width: clamp(65%, 80vw, 80%);
}
@media (max-width: 1024px) { /* Adjust based on your needs */
    .container {
        flex-direction: column;
    }

    .box {
        width: 100%; 
    }
}
.box:nth-child(1) { background: #dedbd3; border-radius: 40px; }
.box:nth-child(2) { background: #bdbdbb; border-radius: 40px; }
.box:nth-child(3) { background: #646361; border-radius: 40px; }

.close-btn {
    position: absolute;
    top: -10px;
    right: -10px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
    display: none;
    z-index: 10;
}
</style>
@endsection


@section('content')
    {{-- <div id="loader" class="loader h-screen w-screen flex justify-center items-center bg-[#25352d]" >
        @include('user.loader')
    </div> --}}

    <div id="full-content" class="hidde">
        @include('components.nav')
        @include('user.home-partials.landing')
        @include('user.home-partials.about')
        @include('user.home-partials.timeline')
        @include('user.home-partials.prizepool')
        @include('user.home-partials.faq')
        @include('user.home-partials.rules')
        @include('components.footer')

    </div>

@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="https://unpkg.com/lenis@1.1.20/dist/lenis.min.js"></script> 

<script>
    function simulateBackgroundTask() {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve();
            }, 3500); 
        });
    }

    // Function to hide the loader and show the content
    function showContent() {
        const loader = document.getElementById('loader');
        const content = document.getElementById('full-content');

        loader.classList.add('fade-out');
        loader.addEventListener('transitionend', () => {
            loader.classList.add('hidden'); 
        }, { once: true });

        content.classList.remove('hidden');
        setTimeout(() => {
            content.classList.add('visible');
        }, 10); 
    }

    async function init() {
        await simulateBackgroundTask();
        showContent();
    }

 
    window.addEventListener("load", function () {
        // init();
    });
    

   document.addEventListener("DOMContentLoaded", () => {
       //landing
        // window.onbeforeunload = function () {
        //     window.scrollTo(0, 0);
        // }

        gsap.registerPlugin(ScrollTrigger);
        // Parallax Layers
        document.querySelectorAll('[data-parallax-layers]').forEach((triggerElement) => {
            let tl = gsap.timeline({
            scrollTrigger: {
                trigger: triggerElement,
                start: "top top",
                end: "bottom top",
                scrub: 0
            }
            });
            const layers = [
                // higher x => higher speed, higher y => lower speed
                { layer: "1", yPercent: 100, xPercent:30 },  
                { layer: "2", yPercent: 100, xPercent:50 },
                { layer: "3", yPercent: 70, xPercent:0 },
                { layer: "4", yPercent: 45, xPercent:0 },
                { layer: "5", yPercent: 29, xPercent:0 },
                { layer: "6", yPercent: 15, xPercent:0},
                { layer: "7", yPercent: 5, xPercent:0 }, 
                { layer: "overlay", yPercent: 0, xPercent:0, opacity:0.75 } 
            ];
            layers.forEach((layerObj, idx) => {
            tl.to(
                triggerElement.querySelectorAll(`[data-parallax-layer="${layerObj.layer}"]`),
                {
                yPercent: layerObj.yPercent,
                xPercent: layerObj.xPercent,
                ease: "none",
                ...(layerObj.opacity !== undefined && { opacity: layerObj.opacity }) // Only adds opacity if it's defined
                },
                idx === 0 ? undefined : "<"
            );
            });
        });
    });
    
    // timeline
    const boxes = document.querySelectorAll(".box");
    const closeBtn = document.getElementById("closeBtn");
    const container = document.querySelector(".container")

    const contentData = {
        leftBox: {
            title: "Seminar & Technical Meeting",
            description: `Seminar bertema “The Silent Crisis of Irresponsible Production” akan membahas dampak buruk dari produksi yang tidak bertanggung jawab terhadap lingkungan, serta solusi berkelanjutan seperti Circular Economy (CE) dan Life Cycle Assessment (LCA). Setelah seminar, Technical Meeting akan memberikan penjelasan mengenai teknis Lifecycle Simulation yang akan dilaksanakan pada hari kedua.`,
            date: "Senin, 17 Maret 2025",
            time: "17:30 WIB",
            location: "Zoom Meeting"
        },
        centerBox: {
            title: "Lifecycle Simulation",
            description: "Rally game interaktif yang mengajak peserta untuk berperan sebagai ecopreneurs di berbagai sektor industri, menghadapi tantangan lingkungan yang relevan dengan kondisi masa kini. Peserta akan menerapkan solusi ramah lingkungan melalui serangkaian fase, dengan fokus pada pengambilan keputusan yang mendukung keberlanjutan jangka panjang.",
            date: "Senin, Sabtu, 22 Maret 2025",
            time: "09:00 WIB",
            location: "Gedung Q, Petra Christian University"
        },
        rightBox: {
            title: "Talk Show & Awarding Ceremony",
            description: `Talk show bertema “Redefining Profit in a Sustainable World” membahas bagaimana bisnis dapat mencapai profitabilitas berkelanjutan tanpa mengorbankan kelestarian lingkungan. Para narasumber, yang merupakan perwakilan dari perusahaan ramah lingkungan, akan berbagi pengalaman dan studi kasus tentang integrasi keberlanjutan dalam model bisnis mereka. Acara ditutup dengan Awarding Ceremony, di mana tim pemenang Lifecycle Simulation akan menerima penghargaan.`,
            date: "Jumat, 28 Maret 2025",
            time: "16:00 WIB",
            location: "Amphitheatre Gedung Q, Petra Christian University"
        }
    };
    
    boxes.forEach((box) => {
        box.addEventListener("click", () => {
            let tl = gsap.timeline();

            // Hide other boxes except the clicked one
            boxes.forEach(b => {
                if (b !== box) {
                    tl.to(b, { opacity: 0, duration: 0.4, display: "none" }, "start");
                }
            });

            // Expand the clicked box to fill the container
            tl.to(box, { 
                flex: 10, 
                borderRadius: "0%", 
                duration: 0.6, 
                ease: "power2.inOut"
            }, "-=0.3")
            .to(closeBtn, { 
                opacity: 1,
                pointerEvents: "auto", 
                duration: 0.3 
            }, "-=0.3");
        });
    });

    closeBtn.addEventListener("click", () => {
        let tl = gsap.timeline();
        tl.to(boxes, { flex: 1, opacity: 1, borderRadius: "40px", display: "flex", duration: 0.5 });
        tl.to(closeBtn, { opacity: 0, pointerEvents: "none", duration: 0.3 }, "-=0.5");
    });
    
    /* Lenis smooth scroll */
    const lenis = new Lenis()
    lenis.on('scroll', (e) => {})
    lenis.on('scroll', ScrollTrigger.update)
    gsap.ticker.add((time) => {
        lenis.raf(time * 1000)
    })
    gsap.ticker.lagSmoothing(0)
</script>


<script>
     

    
</script>

@endsection