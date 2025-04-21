<style>
 html, body {
                height: 100%;   
                min-height: 100vh; 
                overflow: auto; 
                overflow-x: hidden;
            }
            .hidden {
                display: none;
            }
            .kotak img {
                width: 80%; 
                height: 80%; 
                object-fit: cover;
                border-radius: 10px; 
            }
            
        

          
            #back {

                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh; 
                
            
            }


            #scrollable-content {
                height: 430px;
                overflow-y: scroll;
                width: 100%;
                max-width: 1400px;
                padding-right: 10px;
                scroll-behavior: smooth;
            }
            #zoom-image {
                width: 300px ;
                height: 300px ;
                margin-right: 3%;
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 15px;
            }

            ::-webkit-scrollbar-thumb {
                background-color: #ece7e3;
                border-radius: 10px;
                height: 50px;
                min-height: 30px;
            }

            ::-webkit-scrollbar-track {
                background: linear-gradient(to bottom, #415943 0%, #415943 var(--scroll-progress), #D4D4D6 var(--scroll-progress), #D4D4D6 100%);
                border-radius: 15px;
                margin: 100px 0;
            }

            .kotak {
                width: 100%;
                max-width: 200px;  
                height: auto;
                aspect-ratio: 1/1; 
                margin-left: 25px;
            }
            .zoomKotak {
                width: 20%;
                max-width: auto;  
                height: auto;
                aspect-ratio: 1/1; 
                margin-left: 25px;
            }


            #container-utama {
                width: 90%;
                max-width: 1600px;
                margin-bottom:20%; 
                min-height: 70%;
            }

            /* Default for Desktop & Laptop */
            #zoom-container .popup-content {
                width: 90vw;
                max-width: 1600px;
                height: auto;
                min-height: clamp(400px, 70vh, 550px);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
                margin-top: 140px;
            }

            /* #inventory-title {
                margin-top: 5%;
            } */

            /* For Tablets */
            @media (max-width: 1024px) {
                #zoom-container .popup-content {
                    width: 90vw;
                    min-height: 30%;
                    padding: 1rem;
                    margin-bottom: 43%;
                    
                    padding-bottom: 7%;
                    padding-top: 10%;
                }
                #container-utama {
                    min-height: 400px;
                    margin-top: 100px;
                }
                #scrollable-content {
                    height: 300px; 
                }
                .kotak {
                    margin-left: 3px;
                }
                #zoom-image {
                    width: 200px ; 
                    margin-right: 3%;
                }
                
            }

            /* For Large Phones and Small Tablets */
            @media (max-width: 768px) {
                #zoom-image {
                width: 200px ; 
                height: 200px ;
                margin-right: 3%;
                }
                #zoom-container .popup-content {
                    display: flex;
                    flex-direction: column; 
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                    width: 90vw;
                    min-height: 30vh;
                    
                    padding: 20px;
                    margin-top: 35%; 
                    padding-bottom: 6%;
                    padding-top: 9%;
                }
                #zoom-title, #zoom-description, #zoom-quantity {
                    text-align: center; 
                }
                #container-utama {
                    min-height: 400px;
                }
                #scrollable-content {
                    height: 300px; 
                }
                .kotak {
                    margin-left: 3px;
                }
                #back-button{
                    margin-top: 5%;
                }
            
            }

            /* For Small Phones */
            @media (max-width: 480px) {
                #zoom-container .popup-content {
                    width: 90%;
                    min-height: 450px;
                    padding: 0.6rem;
                    margin-top: 55%;
                }
                /* #inventory-title {
                    margin-top: 30%;
                } */
                #container-utama {
                    min-height: 350px;
                    margin-bottom: 5%;
                    margin-top: 10px;
                }
                #scrollable-content {
                    height: 370px; 
                }
                .kotak {
                    margin-left: 3px;
                }
                #zoom-image {
                width: 150px ; 
                height: 150px ;
                margin-right: 6%;
                }
            }

            /* For Very Small Phones (320-375px) */
            @media (max-width: 375px) {
                #zoom-container .popup-content {
                    width: 90% ;
                    min-height: 400px;
                    padding: 0.3rem;
                    margin-top: 40%;
                }
                /* #inventory-title {
                    margin-top: 1px;
                    margin-bottom: 10px;
                } */
                #container-utama {
                    min-height: 230px;
                    margin-top: 10px;
                }
                #scrollable-content {
                    height: 310px; 
                }
                .kotak {
                    margin-left: 3px;
                }
                #zoom-image {
                width: 150px ; 
                height: 150px ;
                margin-right: 5%;
                }
            }

            /* For Extra Small Phones (up to 360px) */
            @media (max-width: 360px) {
                #zoom-container .popup-content {
                    max-height: 80vh;
                    width: 80vw;
                    min-height: 300px;
                    padding: 0.2rem;
                    padding-top: 10%;
                    margin-bottom: 23%;
                    padding-bottom: 15%;
                }
                /* #inventory-title {
                    margin-top: 20%;
                } */
                #container-utama {
                    min-height: 200px;
                }
                #scrollable-content {
                    height: 310px; 
                }
                #zoom-image {
                width: 150px ;
                height: 150px ;
                margin-right: 7%;
                }
                
            }
            @media (max-width: 1028px) and (orientation: landscape) {
                
            
                    body {
                        max-height: 90vh;
                        overflow-x: hidden;
                        display: flex; 
                        justify-content: center; 
                        align-items: center; 
                    }

                    #container-utama {
                        position: absolute;
                        min-height: 80vh;
                        width: 90%; 
                        max-width: 800px; 
                        margin: auto; 
                        margin-bottom: 100%;
                        margin-top: -3%;
                        
                    }

                    #zoom-container {
                        height: 100%;
                        
                    }

                    #scrollable-content {
                        height: 50vh;
                    }

                    #zoom-image {
                        width: 50%;
                        height: 50%;
                        margin-right: 5%;
                    }

                    #zoom-title {
                        font-size: 1rem;
                    }

                    #zoom-description {
                        font-size: 0.8rem;
                    }

                    #zoom-quantity {
                        font-size: 1rem;
                    }

                    #back-button {
                        padding: 5px 15px;
                        padding-left: 5%;
                        padding-right: 5%;
                        font-size: 0.9rem;
                    }

                    #zoom-container .popup-content {
                        width: 90vw;
                        min-height: 300px;
                        max-height: 400px;
                        padding: 1.5rem;
                        margin-bottom: 23%;
                        
                        
                    }

                    #zoom-container::-webkit-scrollbar {
                        display: none;
                    }

                    #inventory-title {
                        display: none;
                    }

                    #back {
                        top: 0;
                        left: 0;
                        width: 100vw;
                        height: 100vh;
                    }

                    #back::-webkit-scrollbar {
                        display: none;
                    }

                }
            
        @media (max-width: 667px) and (orientation: landscape) {
    
            body {
                max-height: 90vh;
                overflow-x: hidden;
                display: flex; 
                justify-content: center; 
                align-items: center;
                
            }
         
            #container-utama {
                min-height: 75vh; 
                margin-top: -2%;

            }
            #zoom-container {
        
                height: 100vh; 
                max-height: 100vh; 
                z-index: 10;
            }

            #scrollable-content {
                height: 50vh; 
            }
        
            #zoom-image {
                width: 50%; 
                height: 50%;
                margin-right: 5%;
            }

            #zoom-title {
                font-size: 1rem; 
            }

            #zoom-description {
                font-size: 0.8rem; 
            }

            #zoom-quantity {
                font-size: 1rem; 
            }

            #back-button {
                padding: 5px 15px; 
                padding-left: 5%;
                padding-right: 5%;
                font-size: 0.9rem;
            }
            
            #zoom-container .popup-content {
                width: 90vw; 
                min-height: 300px; 
                max-height: 80vh; 
                padding: 1rem; 
                margin-bottom: 45%;
                
                
                
                
            
                
            }
            #zoom-container::-webkit-scrollbar {
                display: none;
            }

          
            #back {
        
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh; 
    
                z-index: 0;
            
            }
            #back::-webkit-scrollbar {
                display: none; 
            }
           
        }


    
        </style>

<div id="inventory-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-[rgba(0,0,0,0.5)] z-[1001]">
    <!-- Inventory Wrapper (remove stopPropagation from here) -->
    <div id="inventory-wrapper">
        <!-- Inventory Listing (container-utama) with stopPropagation -->
        <div id="back" class="flex flex-col items-center gap-8 w-full h-full pt-16">
            <div id="inventory-title" class="relative text-center font-bold text-4xl md:text-6xl text-[#ece7e3]">
                Inventory
            </div>
            <div id="container-utama"
                class="bg-[#ece7e3] flex flex-col justify-center items-center gap-4 rounded-3xl p-6 md:p-10 w-full shadow-2xl mt-4"
                onclick="event.stopPropagation()">
                <h1 class="text-2xl md:text-4xl font-bold text-[#415943] -translate-y-6">
                    Komoditas
                </h1>
                <div id="scrollable-content"
                    class="h-[430px] overflow-y-scroll overflow-x-hidden w-full max-w-[1400px] px-4 relative">
                    <div id="inventory-container"
                        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4 w-full">
                    </div>
                </div>
            </div>
        </div>
        <!-- Zoom (Detail) Modal with its own stopPropagation on popup content -->
        <div id="zoom-container"
            class="hidden fixed inset-0 z-60 flex items-center justify-center pt-20 pb-5 bg-[rgba(0,0,0,0.5)]"
            onclick="closeZoom()">
            <div class="popup-content bg-[#ece7e3] flex flex-col items-center justify-center rounded-3xl p-6 md:p-10 w-full max-w-[1600px] h-auto md:h-[550px] shadow-2xl relative"
                onclick="event.stopPropagation()">
                <div class="flex flex-col md:flex-row w-full h-full items-center justify-center">
                    <div class="flex flex-col items-center w-full md:w-1/2">
                        <img id="zoom-image" class="w-40 h-40 object-cover rounded-lg mt-15 shadow-xl border-[3px] border-[#415943]">
                        <span id="zoom-quantity" class="text-lg md:text-2xl font-bold text-[#415943] mt-4"></span>
                    </div>
                    <div class="flex flex-col items-center w-full md:w-1/2">
                        <h2 id="zoom-title" class="text-xl md:text-3xl font-bold text-[#415943] mb-4"></h2>
                        {{-- <p id="zoom-description" class="text-sm md:text-xl text-[#82b741]">
                            Penjelasan tentang komoditas.
                        </p> --}}
                    </div>
                </div>
                <button id="back-button"
                    class="bg-[#415943] text-white font-bold px-10 md:px-20 py-2 rounded-3xl mt-2 md:mt-3">
                    BACK
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    (function() {
        window.assetPath = "{{ asset('') }}";
        const inventoryData = @json($inventories);

        const formattedInventory = inventoryData.map(item => {
            return {
                nama: item.name,
                jumlah: item.pivot.quantity,
                gambar: window.assetPath + item.image
            };
        });

        // Cache DOM elements
        const inventoryModal = document.getElementById('inventory-modal');
        const inventoryContainer = document.getElementById('inventory-container');
        const zoomContainer = document.getElementById('zoom-container');
        const zoomImage = document.getElementById('zoom-image');
        const zoomTitle = document.getElementById('zoom-title');
        const zoomQuantity = document.getElementById('zoom-quantity');
        const backButton = document.getElementById('back-button');
        const containerUtama = document.getElementById('container-utama');
        const scrollableContent = document.getElementById('scrollable-content');

        function updateScrollbar() {
            let scrollTop = scrollableContent.scrollTop;
            let scrollHeight = scrollableContent.scrollHeight - scrollableContent.clientHeight;
            let scrollPercentage = (scrollTop / scrollHeight) * 100;
            document.documentElement.style.setProperty('--scroll-progress', scrollPercentage + '%');
        }
        scrollableContent.addEventListener('scroll', updateScrollbar);
        updateScrollbar();

        function renderInventory() {
            inventoryContainer.innerHTML = "";
            formattedInventory
                .filter(barang => barang.jumlah > 0)
                .forEach(barang => {
                    const item = document.createElement('div');
                    item.classList.add("kotak", "flex", "flex-col", "items-center", "justify-center",
                        "rounded-lg", "cursor-pointer");
                    item.innerHTML = `
                        <img src="${barang.gambar}" alt="${barang.nama}" class="rounded-lg shadow-xl mb-2 border-[3px] border-[#415943]">
                        <span class="text-lg md:text-xl font-bold text-[#415943]">${barang.jumlah}</span>
                    `;
                    item.addEventListener('click', () => {
                        renderDetail(barang);
                    });
                    inventoryContainer.appendChild(item);
                });
        }
        renderInventory();

        function renderDetail(item) {
            zoomImage.src = item.gambar;
            zoomTitle.textContent = item.nama;
            zoomQuantity.textContent = item.jumlah;
            zoomContainer.classList.remove('hidden');
            containerUtama.classList.add('hidden');
        }

        backButton.addEventListener('click', () => {
            zoomContainer.classList.add('hidden');
            containerUtama.classList.remove('hidden');
            window.scrollTo(0, 0);
        });

        function closeZoom() {
            zoomContainer.classList.add('hidden');
        }

        function closeInventoryModal() {
             document.getElementById('inventory-modal').classList.add("hidden");
        }

        // New event listener: Close the modal when clicking outside the visible container
        inventoryModal.addEventListener("click", function(e) {
            // If the inventory listing is visible
            if (!containerUtama.classList.contains('hidden')) {
                if (!containerUtama.contains(e.target)) {
                    closeInventoryModal();
                }
            }
            // Otherwise, if the zoom detail is visible
            else if (!zoomContainer.classList.contains('hidden')) {
                if (!zoomContainer.contains(e.target)) {
                    closeInventoryModal();
                }
            }
        });

        window.openInventoryModal = function() {
            containerUtama.classList.remove('hidden');
            zoomContainer.classList.add('hidden');
            renderInventory();
            inventoryModal.classList.remove('hidden');
            updateScrollbar();
        };
    })();
</script>
