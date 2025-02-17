@extends('user.layout')


@section('style')
<style>
.fade-out {
    opacity: 0;
    transition: opacity 0.5s ease-out;
    display: hidden;
}
.landing-title {
    -webkit-text-stroke: 4px black;
    paint-order: stroke fill;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.74);
}
.box {
    flex: 1;
    color: white;
    cursor: pointer;
    transition: background 0.3s;
}
.container {
    border-radius: 40px;
}

@media (max-width: 768px) { /* Adjust based on your needs */
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

.flip-inner::-webkit-scrollbar {
    display: none;
}

/* faq */
.question-container {
    max-height: 0; 
    overflow: hidden;
    transition: max-height 0.5s ease-in-out;
}
.expanded {
    max-height: 1000px; 
}
</style>
@endsection


@section('content')
    {{-- <div id="loader" class="loader h-screen w-screen flex justify-center items-center bg-[#25352d]" >
        @include('user.loader')
    </div> --}}

    <div id="full-content relative" class="hidde overflow-x-hidden">
        {{-- <div class="nav-overlay bg-black opacity-0 absolute top-0 left-0 w-screen h-[700vh] z-[8000]"></div> --}}
        @include('components.nav')
        @include('user.home-partials.landing')
        @include('user.home-partials.about')
        @include('user.home-partials.timeline')
        @include('user.home-partials.prizepool')
        @include('user.home-partials.faq')
        @include('user.home-partials.rules')
        @include('components.footer')
        </div>
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
        window.onbeforeunload = function () {
            window.scrollTo(0, 0);
        }

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
                { layer: "6", yPercent: 10, xPercent:0},
                { layer: "7", yPercent: 2, xPercent:0 }, 
                { layer: "overlay", yPercent: 0, xPercent:0, opacity:0.9 } 
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

        gsap.to('.overlay', {
            opacity: 0.75,
            scrollTrigger: {
                trigger: '.overlay',
                start: "bottom 90%",
                end: "bottom top",
                scrub: 0,
            }
        })
        gsap.to('.bush', {
            yPercent: -50,
            scrollTrigger: {
                trigger: '.bush',
                start: "bottom bottom",
                end: "bottom top",
                scrub: 0,
                markers: true,
            }
        })
    });
    
    // timeline
    const boxes = document.querySelectorAll(".box");
    const closeBtn = document.getElementById("closeBtn");
    const container = document.querySelector(".container")

    const contentData = {
        leftBox: {
            title: "Seminar & Technical Meeting",
            description: `Seminar bertema “The Silent Crisis of Irresponsible Production” akan membahas dampak buruk dari produksi yang tidak bertanggung jawab terhadap lingkungan, serta solusi berkelanjutan seperti Circular Economy (CE) dan Life Cycle Assessment (LCA). Setelah seminar, Technical Meeting akan memberikan penjelasan mengenai teknis Lifecycle Simulation yang akan dilaksanakan pada hari kedua.`,
            date: "Tanggal: Senin, 17 Maret 2025",
            time: "Waktu: 17:30 WIB",
            location: "Lokasi: Zoom Meeting"
        },
        centerBox: {
            title: "Lifecycle Simulation",
            description: "Rally game interaktif yang mengajak peserta untuk berperan sebagai ecopreneurs di berbagai sektor industri, menghadapi tantangan lingkungan yang relevan dengan kondisi masa kini. Peserta akan menerapkan solusi ramah lingkungan melalui serangkaian fase, dengan fokus pada pengambilan keputusan yang mendukung keberlanjutan jangka panjang.",
            date: "Tanggal: Senin, Sabtu, 22 Maret 2025",
            time: "Waktu: 09:00 WIB",
            location: "Lokasi: Gedung Q, Petra Christian University"
        },
        rightBox: {
            title: "Talk Show & Awarding Ceremony",
            description: `Talk show bertema “Redefining Profit in a Sustainable World” membahas bagaimana bisnis dapat mencapai profitabilitas berkelanjutan tanpa mengorbankan kelestarian lingkungan. Para narasumber, yang merupakan perwakilan dari perusahaan ramah lingkungan, akan berbagi pengalaman dan studi kasus tentang integrasi keberlanjutan dalam model bisnis mereka. Acara ditutup dengan Awarding Ceremony, di mana tim pemenang Lifecycle Simulation akan menerima penghargaan.`,
            date: "Tanggal: Jumat, 28 Maret 2025",
            time: "Waktu: 16:00 WIB",
            location: "Lokasi: Amphitheatre Gedung Q, Petra Christian University"
        }
    };

    const questionData = {
        questions: [
            {
                question: "Apa makna dari tema “Breaking the Loop For the Sustainable Future”?",
                answer: "Tema ini berfokus untuk memutus siklus produksi yang merusak lingkungan dan menggantinya dengan pendekatan yang berfokus pada sustainability untuk masa depan yang lebih hijau."
            },
            {
                question: "Bagaimana ketentuan pembuatan tim untuk berpartisipasi di Lifecycle Simulation CAPITAL 2025?",
                answer: "Setiap tim beranggotakan 4 orang dan diperbolehkan dari angkatan yang berbeda, tetapi harus berasal dari sekolah yang sama.",
            },
            {
                question: "Apakah peserta perlu membayar biaya tambahan untuk mengikuti seminar selain biaya pendaftaran?",
                answer: "Tidak, biaya pendaftaran telah mencakup seminar, lomba, dan talk show CAPITAL 2025.",
            },
            {
                question: "Setelah mengisi formulir pendaftaran, langkah apa selanjutnya yang perlu dilakukan?",
                answer: "Setelah mengisi formulir pendaftaran, ketua tim akan mendapatkan email konfirmasi bahwa pendaftaran telah masuk ke database panitia. Jika data sudah lengkap, ketua tim akan menerima email validasi maksimal H+3 hari kerja, menandakan bahwa data yang diberikan sudah sesuai dengan ketentuan. Kemudian, seluruh anggota tim akan diundang ke Grup Besar Peserta di LINE melalui link yang akan diberikan lewat email.",
            },
            {
                question: "Bagaimana cara melakukan pembayaran biaya pendaftaran?",
                answer: "Biaya pendaftaran bisa dibayarkan dengan transfer melalui Blu by BCA Digital (005737903186) - Pricilla Chealsea Saputra. Bukti transfer dapat diunggah ke halaman Pendaftaran -> Kolom Bukti Transfer.",
            },
            {
                question: "Apakah peserta harus mengikuti seluruh rangkaian acara CAPITAL 2025 yang ada?",
                answer: "Peserta diwajibkan untuk mengikuti seluruh rangkaian acara dari CAPITAL 2025 mulai dari Day 1 hingga Day 3. Namun, apabila berhalangan, peserta dapat melakukan perizinan ke Contact Person CAPITAL 2025.",
            },
            {
                question: "Apakah seluruh anggota tim wajib hadir pada saat Technical Meeting atau hanya perwakilan saja?",
                answer: "Seluruh anggota tim diharapkan untuk hadir karena akan ada pemberian materi serta persiapan untuk hari-H Lifecycle Simulation. Namun, apabila berhalangan, peserta dapat melakukan perizinan ke Contact Person CAPITAL 2025.",
            },
            {
                question: "Jika salah satu anggota tim tidak bisa hadir pada salah satu rangkaian acara, bagaimana prosedur perizinan yang harus dilakukan?",
                answer: `Prosedur perizinan dapat dilakukan dengan menghubungi Contact Person OA LINE ataupun WhatsApp dengan format : <br>
                    Nama Tim : …………………<br>
                    Nama Anggota : ……………<br>
                    Berhalangan hadir pada acara : (Seminar & Technical Meeting / Lifecycle Simulation / Talk Show & Awarding Ceremony)<br>
                    Alasan : …………….………<br>
                    Selanjutnya, kalian bisa menunggu panitia untuk mengonfirmasi perizinan kalian.`,
            },
            {
                question: "Apa saja benefit atau keuntungan yang bisa kalian dapatkan dengan mengikuti CAPITAL 2025?",
                answer: "Kalian akan mendapatkan pengalaman simulasi bisnis yang dapat meningkatkan pemahaman mengenai pentingnya keberlanjutan dalam bidang entrepreneurship. Selain itu, kalian juga akan diajak untuk melatih kemampuan berpikir dan menerapkan solusi strategis yang tidak hanya memperhatikan profit, tetapi juga masyarakat dan lingkungan. Selain itu, seminar dan talk show yang dibawakan oleh para aktivis lingkungan dan praktisi perusahaan, akan memberikan kalian insight lebih mendalam mengenai Sustainable Production Pattern. Tidak kalah menarik, kalian juga berkesempatan untuk mendapatkan hadiah jutaan rupiah.",
            },
            {
                question: "Apakah ada barang yang wajib Anda bawa saat Lifecycle Simulation?",
                answer: "Pada saat Technical Meeting, akan dibagikan guidebook yang berisi semua informasi mengenai Lifecycle Simulation, termasuk informasi terkait barang bawaan.",
            },
        ]
    }
    let hidden_content = '';

    boxes.forEach((box) => {
        box.addEventListener("click", () => {
            let tl = gsap.timeline();
            hidden_content = box.querySelector('.hidden-content');
            let timeline_title = box.querySelector('.timeline-title');
            let timeline_desc = box.querySelector('.timeline-desc');
            let timeline_date = box.querySelector('.timeline-date');
            let timeline_time = box.querySelector('.timeline-time');
            let timeline_loc = box.querySelector('.timeline-loc');
            
            if (hidden_content.classList.contains("hidden")) {
                timeline_title.innerHTML = contentData[box.id].title;
                timeline_desc.innerHTML = contentData[box.id].description;
                timeline_date.innerHTML = contentData[box.id].date;
                timeline_time.innerHTML = contentData[box.id].time;
                timeline_loc.innerHTML = contentData[box.id].location;
            }
            // Hide all boxes except the clicked one
            boxes.forEach(b => {
                if (b !== box) {
                    tl.to(b, { opacity: 0, duration: 0.4, display: "none" }, "start");
                }
            });
            tl.to(box.querySelectorAll(".original-content"), { opacity: 0, duration: 0.3, display: "none" }, "start"); //hide content

            // Expand the box to fill the container
            tl.to(box, { 
                flex: 10, 
                borderRadius: "0%", 
                duration: 0.6, 
                ease: "power2.inOut"
            }, "-=0.3")
            .to(closeBtn, {  //make the close button appear
                opacity: 1,
                pointerEvents: "auto", 
                duration: 0.3 
            }, "-=0.3")
            .to(hidden_content, {
                opacity: 1,
                height: "auto", 
                duration: 0.1,
                ease: "power2.out",
                onStart: () => hidden_content.classList.remove("hidden"), 
            })
        });
    });

    closeBtn.addEventListener("click", () => {
        let tl = gsap.timeline();
        tl.to(boxes, { flex: 1, opacity: 1, borderRadius: "40px", display: "flex", duration: 0.5 });
        tl.to(closeBtn, { opacity: 0, pointerEvents: "none", duration: 0.3 }, "-=0.5");
        tl.to(hidden_content, { opacity: 0, height: 0, duration: 0.2, onStart: () => hidden_content.classList.add("hidden") }, "-=0.4");
        tl.to(document.querySelectorAll(".original-content"), { opacity: 1, display: "block", duration: 0.3 }, "-=0.4");
    });

    // faqs
    const faqsContainer = document.getElementById("faqs");
    const toggleButton = document.getElementById("toggleBtn");

    const questionsToShow = window.innerWidth >= 768 ? 6 : 4; // determine how many questions appear initially
    const questionContainers = [];

    questionData.questions.forEach((item, index) => {
        const questionWrapper = document.createElement("div");
        questionWrapper.classList.add("question-wrapper");

        const questionElement = document.createElement("div");
        questionElement.classList.add("questions", "relative", "h-[150px]", "text-black", "bg-[#dad7cf]", "p-8", "w-full", "rounded-2xl");

        questionElement.innerHTML = `
            <p class="number font-oxanium px-2 bg-[#14240a] text-white text-center rounded-full absolute top-2 left-3">${index+1}</p>
            <div class="front font-oxanium w-full h-full font-extrabold md:text-xl text-center flex items-center justify-center opacity-100 cursor-pointer">
                ${item.question}
            </div>
            <div class="hidden back font-quicksand w-full h-full md:text-lg text-center flex items-start justify-center overflow-y-auto cursor-pointer">
                ${item.answer}
            </div>
        `;

        questionWrapper.appendChild(questionElement);
        const front = questionElement.querySelector(".front");
        const back = questionElement.querySelector(".back");

        front.addEventListener("click", () => {
            front.classList.add("hidden");
            back.classList.remove("hidden");
        });

        back.addEventListener("click", () => {
            back.classList.add("hidden");
            front.classList.remove("hidden");
        });

        if (index >= questionsToShow) {
            questionWrapper.classList.add("question-container"); 
        }

        faqsContainer.appendChild(questionWrapper);
        questionContainers.push(questionWrapper);
    });

    let isExpanded = false;

    toggleButton.addEventListener("click", () => {
        questionContainers.forEach((q, index) => {
            if (index >= questionsToShow) {
                q.classList.toggle("expanded");
            }
        });

        isExpanded = !isExpanded;
        
        if (isExpanded) {
            toggleButton.classList.add('rotate-180');
        } else {
            toggleButton.classList.remove('rotate-180');
        }
    });

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