<style>
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
        overflow-x: hidden;
        width: 100%;
        max-width: 1400px;
        padding-right: 10px;
        scroll-behavior: smooth;
    }

    #zoom-image {
        width: 300px;
        height: 300px;
        margin-right: 3%;
    }

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
        margin-bottom: 20%;
        height: auto;
    }

    @media (min-width: 768px) {
        #container-utama {
            height: 550px;
        }
    }

    #inventory-title {
        margin-top: 5%;
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
                        <img id="zoom-image" class="w-40 h-40 object-cover rounded-lg mt-15">
                        <span id="zoom-quantity" class="text-lg md:text-2xl font-bold text-[#415943] mt-4"></span>
                    </div>
                    <div class="flex flex-col items-center w-full md:w-1/2">
                        <h2 id="zoom-title" class="text-xl md:text-3xl font-bold text-[#415943] mb-4"></h2>
                        <p id="zoom-description" class="text-sm md:text-xl text-[#82b741]">
                            Penjelasan tentang komoditas.
                        </p>
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
                        <img src="${barang.gambar}" alt="${barang.nama}" class="rounded-lg shadow-md mb-2">
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
            inventoryModal.classList.add("hidden");
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
        };
    })();
</script>
