@extends('user.layout')
@section('content')
    <div id="black" class="w-screen h-screen absolute inset-0 z-[100] flex justify-center items-center bg-black/50">
        <div class="w-[30vh] h-[30vh] z-[90] absolute flex justify-center items-center top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
            <i id="lock"
                class="fa-solid fa-lock flex items-center justify-center text-white 
            w-full h-full text-[9rem] md:text-[12rem] lg:text-[15rem] leading-none 
            transition-opacity duration-1000 cursor-pointer"></i>
        </div>

        <div id="lockedPopup"
            class="z-[95] bg-[#EBE7E2] hidden opacity-100 w-[90%] md:w-[75%] rounded-3xl flex flex-col justify-center items-center p-3">
            <div class="w-full flex justify-center items-center flex-col">
                <img class="w-1/4"
                src="{{ asset('assets/landing/sun.png') }}" alt="">

                <h1 class="text-[--capi-green5] text-center font-bold md:text-xl py-2 font-return-grid text-sm sm:text-lg">
                    The Transaction Window period is over. If you want to make a purchase, please visit the Central Hub.
                </h1>
            </div>
            <div class="w-full flex justify-center items-center py-2">
                <button id="backPopup"
                    class="w-[180px] transition-all ease-in-out duration-300 py-[6px] border-[#131E6A] hover:bg-[#131E6A] hover:text-[#EBE7E3] hover:border-[#7a83bfd4] rounded-[40px] border-solid border-2 p-2 text-[--capi-green5] text-center font-bold lg:text-xl text-lg">
                    BACK
                </button>
                <style>
                    #back:hover {
                        text-shadow: 2px 2px 3px #a95a42, 0px 0 5px rgba(222, 96, 61, 0.925);
                    }
                </style>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('lock').addEventListener('click', function() {
                document.getElementById('lockedPopup').classList.remove('hidden');
                gsap.set('#lockedPopup',{
                    opacity:1,
                    scale:1,
                    y:0,
                });
                gsap.from('#lockedPopup',{
                    opacity:0,
                    scale:0.6,
                    y:-10,
                    ease:'power4.out',
                    duration:0.5
                });
            });

            document.getElementById('backPopup').addEventListener('click', function() {
                gsap.to('#lockedPopup',{
                    opacity:0,
                    scale:0.6,
                    y:-10,
                    ease:'power4.out',
                    duration:0.5
                }).then(()=>{
                    document.getElementById('lockedPopup').classList.add('hidden');
                });
            });
        });
    </script>

    <div class="w-screen h-screen flex justify-center items-center overflow-hidden">
        <style>
            .abt-stroke {
                -webkit-text-stroke: 5px rgba(255, 255, 255, 0.7);
                paint-order: stroke fill;
            }

            .text-shadow-green {
                text-shadow: 2px 2px 5px rgba(49, 206, 127, 0.902), 0px 0 9px rgba(61, 219, 140, 0.925);
            }
        </style>

        <div class="relative h-[75%] w-[92%] sm:w-[90%] flex flex-col justify-center items-center">
            <h1
                class="abt-stroke text-[42px] md:text-5xl lg:text-7xl xl:text-8xl z-[16] text-shadow-green text-[#608343] font-league font-black text-center md:text-left">
                Trade Zone</h1>
            <div class="w-full h-[80%] rounded-2xl bg-[#EBE7E3] flex justify-center items-center">
                <div id="commoditiesContainer"
                    class="w-[95%] gap-3 p-4 lg:h-[85%] md:h-[70%] sm:h-[70%] h-[80%] justify-center items-center overflow-y-auto grid grid-cols-10 md:grid-cols-9 lg:grid-cols-10">
                    @foreach ($commodities as $commodity)
                        <div class="lg:col-span-2 md:col-span-3 col-span-5 p-3 flex justify-center items-center relative">
                            <div class="w-full flex justify-evenly items-center gap-2 flex-col">
                                <div class="addTo cursor-pointer w-full flex justify-center items-center">
                                    <img class="w-1/2 rounded-xl p-1 border-2 border-[--capi-green5]"
                                        src="{{ asset('assets/landing/cloud-2.png') }}" alt="">
                                </div>
                                <h1
                                    class="font-league text-base lg:text-xl xl:text-2xl z-[6] text-[#608343] font-bold tracking-wide text-center">
                                    {{ $commodity['price'] }}</h1>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="buyContainer"
                    class="w-[95%] relative opacity-0 hidden gap-3 p-4 h-full flex flex-col justify-start items-center">
                    <div class="w-full absolute top-0 right-0 flex justify-end items-center">
                        <div id="backIcon"
                            class="w-8 h-8 cursor-pointer sm:w-10 sm:h-10 lg:w-12 lg:h-12 flex justify-center items-center">
                            <img class="h-full" src="{{ asset('assets/landing/cloud-1.png') }}" alt="">
                        </div>
                        <div id="cartIcon"
                            class="w-8 h-8 cursor-pointer sm:w-10 sm:h-10 lg:w-12 lg:h-12 flex justify-center items-center">
                            <img class="h-full" src="{{ asset('assets/landing/cloud-3.png') }}" alt="">
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 w-full h-[70%] sm:flex-row justify-center items-center">
                        <div class="flex sm:w-2/4 h-[75%] justify-center items-center flex-col w-full">
                            <img id="imgBuy" class="h-full" src="{{ asset('assets/landing/cloud-4.png') }}"
                                alt="">
                            <h1 id="priceBuy"
                                class="w-full font-league text-lg sm:text-xl lg:text-2xl xl:text-3xl z-[6] text-[#608343] font-bold tracking-wide text-center">
                                99999999</h1>
                        </div>

                        <div class="flex flex-col justify-evenly items-center text-center w-full sm:w-2/4 px-2 sm:mt-[10%]">
                            <h1 id="titleBuy"
                                class="w-full font-league text-xl sm:text-2xl lg:text-3xl xl:text-4xl z-[6] text-[#608343] font-bold tracking-wide text-center">
                                Processed Food</h1>

                            <div class="flex items-center z-[6] px-3">
                                <button id="decrease"
                                    class="px-3 py-1 bg-[#608343] text-white font-bold rounded">-</button>
                                <div class="text-xl sm:text-2xl lg:text-3xl xl:text-4xl text-[#608343] font-bold px-2">
                                    <input type="number" name="count" id="count" min="0" value="0"
                                        class="text-center rounded-xl">
                                    <style>
                                        input::-webkit-outer-spin-button,
                                        input::-webkit-inner-spin-button {
                                            -webkit-appearance: none;
                                            margin: 0;
                                        }

                                        input[type=number] {
                                            -moz-appearance: textfield;
                                        }
                                    </style>
                                </div>
                                <button id="increase"
                                    class="px-3 py-1 bg-[#608343] text-white font-bold rounded">+</button>
                            </div>

                        </div>

                    </div>
                    <div class="w-full absolute bottom-3 gap-3 flex flex-row-reverse justify-center items-center">
                        <div id="buyButton"
                            class="flex justify-center rounded-3xl border-2 border-[--cap-green4] bg-[#DEFEC8] p-2 items-center w-2/5 md:w-1/4 text-[--cap-green6] hover:text-[--cap-green1] hover:bg-[#31ce7fe6] hover:border-[--cap-green5] cursor-pointer transition-all ease-in duration-300">
                            <button class="font-oxanium font-bold text-sm sm:text-base md:text-lg">BUY</button>
                        </div>
                        <div id="cartButton"
                            class="flex justify-center rounded-3xl border-2 border-[--cap-green4] bg-[#EBE7E2] p-2 items-center w-2/5 md:w-1/4 text-[--cap-green6] hover:text-[#d1f2bc] hover:bg-[--cap-green6] hover:border-[--cap-green5] cursor-pointer transition-all ease-in duration-300">
                            <button class="font-oxanium font-bold text-sm sm:text-base md:text-lg">ADD TO CART</button>
                        </div>
                    </div>
                </div>

                <div id="checkContainer"
                    class="w-full relative opacity-0 hidden gap-3 p-4 h-[80%] flex flex-col justify-start items-center">
                    <div class="w-full h-[75%] flex flex-col justify-between items-center gap-5">
                        <div class="w-full h-full overflow-y-auto">
                            {{-- isi cart --}}
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-12 text-center">
                                <div class="w-full col-span-2 flex justify-center items-center">
                                    <img class="w-1/2 border-[#323A77]" src="{{ asset('assets/landing/cloud-2.png') }}"
                                        alt="">
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg w-full">
                                        Processed Food</h1>
                                </div>
                                <div class="col-span-2 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalCount">99 pcs</h1>
                                </div>
                                <div class="col-span-4 flex justify-center items-center">
                                    <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg"
                                        id="totalPrice">$9999999</h1>
                                </div>
                            </div>


                        </div>

                        <div class="w-full grid grid-cols-12 text-center">
                            <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg col-span-6">Total
                            </h1>
                            <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg col-span-2"
                                id="totalCount">99 pcs</h1>
                            <h1 class="font-oxanium font-bold text-center text-sm sm:text-base md:text-lg col-span-4"
                                id="totalPrice">$9999999</h1>
                        </div>
                    </div>

                    <div class="w-full absolute bottom-3 gap-3 flex flex-row-reverse justify-center items-center">
                        <div id="checkoutButton"
                            class="flex justify-center rounded-3xl border-2 border-[--cap-green4] bg-[#DEFEC8] p-2 items-center w-2/5 md:w-1/4 text-[--cap-green6] hover:text-[--cap-green1] hover:bg-[#31ce7fe6] hover:border-[--cap-green5] cursor-pointer transition-all ease-in duration-300">
                            <button class="font-oxanium font-bold text-sm sm:text-base md:text-lg">CHECKOUT</button>
                        </div>
                        <div id="cancelButton"
                            class="flex justify-center rounded-3xl border-2 border-[--cap-green4] bg-[#EBE7E2] p-2 items-center w-2/5 md:w-1/4 text-[--cap-green6] hover:text-[#d1f2bc] hover:bg-[--cap-green6] hover:border-[--cap-green5] cursor-pointer transition-all ease-in duration-300">
                            <button class="font-oxanium font-bold text-sm sm:text-base md:text-lg">CANCEL</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    <script>
        let count = 0;
        const countDisplay = document.getElementById("count");

        document.getElementById("decrease").addEventListener("click", function() {
            if (count > 0) {
                count--;
                countDisplay.value = count;
            }
        });

        document.getElementById("increase").addEventListener("click", function() {
            count++;
            countDisplay.value = count;
        })

        document.addEventListener('DOMContentLoaded', function() {
            const commodities = document.querySelectorAll('.addTo');
            commodities.forEach(commodity => {
                commodity.addEventListener('click', function() {
                    gsap.to('#commoditiesContainer', {
                        opacity: 0,
                        duration: 0.25,
                        ease: 'power4.out',
                    }).then(() => {
                        document.getElementById('commoditiesContainer').classList.add(
                            'hidden');
                        document.getElementById('buyContainer').classList.remove('hidden');
                        gsap.to('#buyContainer', {
                            opacity: 1,
                            duration: 0.25,
                            ease: 'power4.in'
                        });
                    });
                });
            });

            document.getElementById('backIcon').addEventListener('click', function() {
                gsap.to('#buyContainer', {
                    opacity: 0,
                    duration: 0.25,
                    ease: 'power4.out',
                }).then(() => {
                    document.getElementById('buyContainer').classList.add(
                        'hidden');
                    document.getElementById('commoditiesContainer').classList.remove('hidden');
                    gsap.set('#commoditiesContainer', {
                        opacity: 0
                    });
                    gsap.to('#commoditiesContainer', {
                        opacity: 1,
                        duration: 0.25,
                        ease: 'power4.in'
                    });
                    countDisplay.value = 0;
                    count = 0;
                });
            });

            document.getElementById('cartIcon').addEventListener('click', function() {
                gsap.to('#buyContainer', {
                    opacity: 0,
                    duration: 0.25,
                    ease: 'power4.out',
                }).then(() => {
                    document.getElementById('buyContainer').classList.add(
                        'hidden');
                    document.getElementById('checkContainer').classList.remove('hidden');
                    gsap.set('#checkContainer', {
                        opacity: 0
                    });
                    gsap.to('#checkContainer', {
                        opacity: 1,
                        duration: 0.25,
                        ease: 'power4.in'
                    });
                });

            });

            document.getElementById('cancelButton').addEventListener('click', function() {
                gsap.to('#checkContainer', {
                    opacity: 0,
                    duration: 0.25,
                    ease: 'power4.out',
                }).then(() => {
                    document.getElementById('checkContainer').classList.add(
                        'hidden');
                    document.getElementById('buyContainer').classList.remove('hidden');
                    gsap.set('#buyContainer', {
                        opacity: 0
                    });
                    gsap.to('#buyContainer', {
                        opacity: 1,
                        duration: 0.25,
                        ease: 'power4.in'
                    });
                });

            });
        });
    </script>
@endsection
