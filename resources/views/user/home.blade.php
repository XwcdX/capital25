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
            transform: scaleY(0);
            transform-origin: top;
        }

        .container {
            border-radius: 40px;
        }

        @media (max-width: 768px) {

            /* Adjust based on your needs */
            .container {
                flex-direction: column;
            }

            .box {
                width: 100%;
            }
        }

        .box:nth-child(1) {
            background: #a8c747;
            border-radius: 40px;
        }

        .box:nth-child(2) {
            background: #82b741;
            border-radius: 40px;
        }

        .box:nth-child(3) {
            background: #56843a;
            border-radius: 40px;
        }

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
    </style>
@endsection


@section('content')
    <div id="full-content relative" class="hidde overflow-x-hidden bg-[var(--cap-green2)]">
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
        AOS.init();
    </script>
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
            }, {
                once: true
            });

            content.classList.remove('hidden');
            setTimeout(() => {
                content.classList.add('visible');
            }, 10);
        }

        async function init() {
            await simulateBackgroundTask();
            showContent();
        }


        window.addEventListener("load", function() {
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
                    {
                        layer: "1",
                        yPercent: 100,
                        xPercent: 30
                    },
                    {
                        layer: "2",
                        yPercent: 100,
                        xPercent: 50
                    },
                    {
                        layer: "3",
                        yPercent: 70,
                        xPercent: 0
                    },
                    {
                        layer: "4",
                        yPercent: 45,
                        xPercent: 0
                    },
                    {
                        layer: "5",
                        yPercent: 29,
                        xPercent: 0
                    },
                    {
                        layer: "6",
                        yPercent: 15,
                        xPercent: 0
                    },
                    {
                        layer: "7",
                        yPercent: 2,
                        xPercent: 0
                    },
                    {
                        layer: "overlay",
                        yPercent: 0,
                        xPercent: 0,
                        opacity: 0.9
                    }
                ];
                layers.forEach((layerObj, idx) => {
                    tl.to(
                        triggerElement.querySelectorAll(
                            `[data-parallax-layer="${layerObj.layer}"]`), {
                            yPercent: layerObj.yPercent,
                            xPercent: layerObj.xPercent,
                            ease: "none",
                            ...(layerObj.opacity !== undefined && {
                                opacity: layerObj.opacity
                            }) // Only adds opacity if it's defined
                        },
                        idx === 0 ? undefined : "<"
                    );
                });
            });

            gsap.to('.overlay', {
                opacity: 0.85,
                scrollTrigger: {
                    trigger: '.overlay',
                    start: "80% bottom",
                    end: "bottom top",
                    scrub: 0,
                }
            })
            gsap.to('.bush', {
                yPercent: -50,
                scrollTrigger: {
                    trigger: '.bush',
                    start: "60% bottom",
                    end: "bottom top",
                    scrub: 0,
                }
            })
            // gsap.to('.waterfall', {
            //     yPercent: -3,
            //     scrollTrigger: {
            //         trigger: '.bush',
            //         start: "bottom bottom",
            //         end: "bottom top",
            //         scrub: 0,
            //     }
            // })
            //moni
            let mm = gsap.matchMedia();
            mm.add("(max-width: 767px)", () => {
                gsap.to('.moni', {
                    yPercent: -70,
                    scrollTrigger: {
                        trigger: '#aboutUs',
                        start: "70% bottom",
                        end: "bottom top",
                        scrub: 0,
                    }
                });
            });

            mm.add("(min-width: 768px)", () => {
                gsap.set('.moni', {
                    yPercent: 80,
                });
                gsap.to('.moni', {
                    yPercent: -60,
                    scrollTrigger: {
                        trigger: '#aboutUs',
                        start: "80% bottom",
                        end: "bottom top",
                        scrub: 0,
                    }
                });
            })
        });

        // timeline
        const boxes = document.querySelectorAll(".box");
        const closeBtn = document.getElementById("closeBtn");
        const container = document.querySelector(".container")

        const contentData = {
            leftBox: {
                title: "Seminar & Technical Meeting",
                description: `Seminar bertema <b>“<i>The Silent Crisis of Irresponsible Production</i>”</b> akan membahas dampak buruk dari produksi yang tidak bertanggung jawab terhadap lingkungan, serta solusi berkelanjutan seperti <i>Circular Economy</i> (CE) dan <i>Life Cycle Assessment</i> (LCA). Setelah seminar, <i>Technical Meeting</i> akan memberikan penjelasan mengenai teknis <i>Lifecycle Simulation</i> yang akan dilaksanakan pada hari kedua.`,
                date: "<b>Tanggal: Senin, 17 Maret 2025</b>",
                time: "<b>Waktu: 17:30 WIB<b>",
                location: "<b>Lokasi: Zoom Meeting</b>"
            },
            centerBox: {
                title: "Lifecycle Simulation",
                description: "<i>Rally game</i> interaktif yang mengajak peserta untuk berperan sebagai <i>ecopreneurs</i> di berbagai sektor industri, menghadapi tantangan lingkungan yang relevan dengan kondisi masa kini. Peserta akan menerapkan solusi ramah lingkungan melalui serangkaian fase, dengan fokus pada pengambilan keputusan yang mendukung keberlanjutan jangka panjang.",
                date: "<b>Tanggal: Senin, Sabtu, 22 Maret 2025</b>",
                time: "<b>Waktu: 09:00 WIB</b>",
                location: "<b>Lokasi: Gedung Q, Petra Christian University</b>"
            },
            rightBox: {
                title: "Talk Show & Awarding Ceremony",
                description: `<i>Talk show</i> bertema <b>“<i>Redefining Profit in a Sustainable World</i>”</b> membahas bagaimana bisnis dapat mencapai profitabilitas berkelanjutan tanpa mengorbankan kelestarian lingkungan. Para narasumber, yang merupakan perwakilan dari perusahaan ramah lingkungan, akan berbagi pengalaman dan studi kasus tentang integrasi keberlanjutan dalam model bisnis mereka. Acara ditutup dengan <i>Awarding Ceremony</i>, di mana tim pemenang <i>Lifecycle Simulation</i> akan menerima penghargaan.`,
                date: "<b>Tanggal: Jumat, 28 Maret 2025</b>",
                time: "<b>Waktu: 16:00 WIB</b>",
                location: "<b>Lokasi: Amphitheatre Gedung Q, Petra Christian University</b>"
            }
        };

        const questionData = {
            questions: [{
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
                    answer: "Biaya pendaftaran bisa dibayarkan dengan transfer melalui <b>Blu by BCA Digital (005737903186) - Pricilla Chealsea Saputra</b>. Bukti transfer dapat diunggah ke halaman Pendaftaran -> Kolom Bukti Transfer.",
                },
                {
                    question: "Apakah peserta harus mengikuti seluruh rangkaian acara CAPITAL 2025 yang ada?",
                    answer: `Peserta <b>diwajibkan</b> untuk mengikuti seluruh rangkaian acara dari CAPITAL 2025 mulai dari Day 1 hingga Day 3. Namun, apabila berhalangan, peserta dapat melakukan perizinan ke Contact Person CAPITAL 2025.`,
                },
                {
                    question: "Apakah seluruh anggota tim wajib hadir pada saat Technical Meeting atau hanya perwakilan saja?",
                    answer: "Seluruh anggota tim diharapkan untuk hadir karena akan ada pemberian materi serta persiapan untuk hari-H Lifecycle Simulation. Namun, apabila berhalangan, peserta dapat melakukan perizinan ke Contact Person CAPITAL 2025.",
                },
                {
                    question: "Jika salah satu anggota tim tidak bisa hadir pada salah satu rangkaian acara,<br> bagaimana prosedur perizinan yang harus dilakukan?",
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

        let tl = gsap.timeline();


        gsap.to(".box", {
            scaleY: 1,
            duration: 1,
            ease: "power2.out",
            stagger: 0.1,
            scrollTrigger: {
                trigger: "#leftBox",
                start: "top 20%",
                end: "bottom top",
                toggleActions: "play none reverse none",
                markers: true,
            }
        });

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
                        tl.to(b, {
                            opacity: 0,
                            duration: 0.4,
                            display: "none"
                        }, "start");
                    }
                });
                tl.to(box.querySelectorAll(".original-content"), {
                    opacity: 0,
                    duration: 0.3,
                    display: "none"
                }, "start"); //hide content

                // Expand the box to fill the container
                tl.to(box, {
                        flex: 10,
                        borderRadius: "0%",
                        duration: 0.6,
                        ease: "power2.inOut"
                    }, "-=0.3")
                    .to(closeBtn, { //make the close button appear
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
            tl.to(boxes, {
                flex: 1,
                opacity: 1,
                borderRadius: "40px",
                display: "flex",
                duration: 0.5
            });
            tl.to(closeBtn, {
                opacity: 0,
                pointerEvents: "none",
                duration: 0.3
            }, "-=0.5");
            tl.to(hidden_content, {
                opacity: 0,
                height: 0,
                duration: 0.2,
                onStart: () => hidden_content.classList.add("hidden")
            }, "-=0.4");
            tl.to(document.querySelectorAll(".original-content"), {
                opacity: 1,
                display: "block",
                duration: 0.3
            }, "-=0.4");
        });

        // faqs
        const faqsContainer = document.getElementById("faqs");
        const toggleButton = document.getElementById("toggleBtn");

        const questionContainers = [];

        questionData.questions.forEach((item, index) => {
            const questionWrapper = document.createElement("div");
            questionWrapper.classList.add("dropdown", "flex", "flex-col", "bg-[#dad7cf]", "relative", "rounded-2xl",
                "hover:bg-[#a8c747]", "transition-all", "duration-200");

            questionWrapper.innerHTML = `
            <p class="number font-oxanium px-2 bg-[#14240a] text-white text-left rounded-full absolute top-2 left-3">1</p>
        `;
            const questionElement = document.createElement("li");
            questionElement.classList.add("accordion", "p-2", "flex", "items-center", "justify-center",
                "rounded-2xl", "font-oxanium", "h-[120px]", "md:h-[80px]", "hover:text-black", "cursor-pointer",
                "p-8");

            questionElement.innerHTML = `
            <p class="number font-oxanium px-2 bg-[#14240a] text-white text-center rounded-full absolute top-2 left-3">${index+1}</p>
            
            <p class="question font-oxanium w-full h-full font-extrabold text-base sm:text-lg lg:text-xl text-left flex items-center justify-start opacity-100 ml-6">${item.question}</p>
            <i class="fa-solid fa-angle-down cursor-pointer text-white"></i>     
        `;

            const answerElement = document.createElement("div");
            answerElement.classList.add("dropdown-wrapper");

            answerElement.innerHTML = `
            <div class="dropdown-content lg:px-10 mb-8">
                <p class="font-quicksand w-full h-full text-base lg:text-lg text-center flex items-start justify-center">${item.answer}</p>
            </div>
        `

            questionWrapper.appendChild(questionElement);
            questionWrapper.appendChild(answerElement);

            faqsContainer.appendChild(questionWrapper);
            questionContainers.push(questionWrapper);
        });

        const plusBtns = document.querySelectorAll('.accordion');
        const contentWrappers = document.querySelectorAll(".dropdown-wrapper");

        plusBtns.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                // Toggle the "active" class for the corresponding content wrapper
                contentWrappers[index].classList.toggle("active");
                // btn.classList.toggle('rotate-180');
                const icon = btn.querySelector('.fa-solid');
                if (icon) {
                    icon.classList.toggle('rotate-180');
                }
            });
        });


        const lenis = new Lenis()
        lenis.on('scroll', (e) => {})
        lenis.on('scroll', ScrollTrigger.update)
        gsap.ticker.add((time) => {
            lenis.raf(time * 1000)
        })
        gsap.ticker.lagSmoothing(0)
    </script>
@endsection
