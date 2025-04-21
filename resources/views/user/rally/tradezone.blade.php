<style>
    .hidden {
        display: none !important;
    }

    /* .commodity-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    } */
    .custom-success-popup {
        width: 400px !important;
        padding: 30px;
        border-radius: 20px;
        background-color: #f4f0ea;
        font-family: 'Poppins', sans-serif;
        text-align: center;
    }

    .custom-success-confirm {
        background-color: #2c473e;
        color: white;
        border: none;
        padding: 12px 30px;
        font-weight: bold;
        border-radius: 30px;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        margin-top: 20px;
    }

    .custom-swal-popup {
        width: 40%;
        height: 50%;
        border-radius: 12px;
        padding: 20px;
        background-color: #f4f0ea; /* atau sesuai warna background */
        font-family: 'Poppins', sans-serif;
    }

    .custom-swal-confirm {
        background-color: #2c473e;
        color: white;
        border: none;
        padding: 10px 25px;
        font-weight: bold;
        border-radius: 25px;
        margin-right: 10px;
        font-family: 'Poppins', sans-serif;
    }

    .custom-swal-cancel {
        background-color: transparent;
        color: #2c473e;
        border: 2px solid #2c473e;
        padding: 10px 25px;
        font-weight: bold;
        border-radius: 25px;
        font-family: 'Poppins', sans-serif;
    }

    .commodity-card img {
        width: 80%;
        height: 80%;
        object-fit: cover;
        border-radius: 10px;
    }

    #tradezone-back {
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
    }

    #tradezone-scrollable-content {
        height: 430px;
        overflow-y: scroll;
        overflow-x: hidden;
        width: 100%;
        max-width: 1400px;
        padding-right: 10px;
        scroll-behavior: smooth;
    }

    #tradezone-zoom-image {
        width: 300px;
        height: 300px;
        margin-right: 3%;
    }
    
    #tradezone-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        padding: 1rem;
        box-sizing: border-box;
    }

    #tradezone-zoom-container .popup-content {
        max-width: 90vw;
        height: 80vh;    
        padding: 2vw 3vw;
    }

    
    #tradezone-back {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        padding: 2rem 1rem;
        gap: 2rem;
        box-sizing: border-box;
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

    .commodity-card {
        width: 100%;
        max-width: 200px;
        height: auto;
        aspect-ratio: 1/1;
        margin-left: 25px;
        cursor: pointer;
    }

    #tradezone-container-utama {
        width: 90%;
        max-width: 1600px;
        margin-bottom: 20%;
        margin: auto;
        height: auto;

    }



    #tradezone-title {
        margin-top: 5%;
    }

    #cartIcon {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: #007bff;
        color: #fff;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        cursor: pointer;
        z-index: 1020;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    } */

    #cartModal {
        position: fixed;
        inset: 0;
        z-index: 1025;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #cartModal .modal-content {
        background: #ece7e3;
        border-radius: 2.5vw;
        width: 50%;
        max-width: 100%;
        max-height: 90vh;
        padding: 2rem;
        overflow-y: auto;
    }

    #cartModalOverlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.8);
        z-index: 1024; 
    }

    .swal2-popup.swal-high-z-index {
        z-index: 100000 !important;
    }

    @media (max-width: 768px) {
        .custom-success-popup,
        .custom-swal-popup,
        #cartModal .modal-content {
            width: 90% !important;
            padding: 5%;
            border-radius: 5%;
        }

        #tradezone-zoom-image {
            width: 40vw;
            height: 40vw;
            margin-right: 0;
            margin-bottom: 5%;
        }

        .popup-content {
            flex-direction: column;
            gap: 5%;
            height: auto !important;
        }

        #cartIcon img {
            width: 10vw;
            height: 10vw;
        }

        #tradezone-title {
            font-size: 6vw;
            margin-top: 10%;
        }

        .commodity-card {
            margin-left: 3%;
            max-width: 30vw;
        }

        #tradezone-scrollable-content {
            height: 40vh;
        }

        #tradezone-container-utama {
            margin-top: 0;
            width: 95%;
            padding: 5%;
        }

        #tradezone-zoom-container {
            padding-top: 10vh;
            padding-bottom: 10vh;
        }

        #tradezone-zoom-title {
            font-size: 4vw;
            text-align: center;
        }

        #tradezone-zoom-price {
            font-size: 3.5vw;
            text-align: center;
        }

        #buyNowButton,
        #addToCartButton {
            font-size: 3vw;
            padding: 2% 5%;
            
        }

        #tradezone-back-button img,
        #cartIcon img {
            width: 8vw;
            height: 8vw;
        }

        #tradezone-back-button img {
            width: 10vw;
            height: 10vw;
            margin-left: 50%;
            
        }

        #tradezone-back-button {
            display: flex;
            align-items: center; 
            justify-content: flex-start;
            
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1rem;
        }
    }

    @media (orientation: landscape) and (max-height: 500px) {
        #tradezone-back {
            padding-top: 2vh;
            padding-bottom: 2vh;
        }

        #tradezone-title {
            font-size: 4vw;
            margin-top: 0;
            text-align: center;
        }

        #tradezone-container-utama {
            margin: 0 auto;
            padding: 2vh 2vw;
            width: 85%;
            height: 80%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .commodity-card {
            max-width: 18vw;
            padding: 1vh 1vw;
            margin: 1vh 1vw;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #tradezone-scrollable-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            overflow-y: auto;
            max-height: 60vh;
            gap: 2vh 2vw;
            padding: 2vh 1vw;
        }

        #tradezone-zoom-container .popup-content {
            height:80vh;
            max-height: 120%;
            padding: 12%;
            padding-top: 15%;
        
        }

        #tradezone-zoom-image {
            width: 20vw; /* ubah dari 20vw jadi 30vw untuk ukuran yang lebih nyaman */
            height: 20vw; /* pastikan tetap square */
            margin: 2vh auto; /* center gambar secara vertikal */
            display: block;
        }

        #tradezone-zoom-title,
        #tradezone-zoom-price {
            font-size: 3vw;
            text-align: center;
        }

        #buyNowButton,
        #addToCartButton {
            font-size: 1.5vw;
            padding: 1.5% 3%;
            margin-top: 20%;
           
        
        }


        #tradezone-header-icons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 2vh 3vw;
        }

        #tradezone-back-button,
        #cartIcon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 5vw;      
            height: 5vw;
            
        }

        #tradezone-back-button img,
        #cartIcon img {
            width: 100%;
            height: auto;
        }

        #tradezone-back-button img {
            width: 7vw;
            height: 7vw;
            margin-top: 1.5vh;
            
        
            
        }

        #cartModal .modal-content {
            width: 90% !important;
            max-height: 80vh !important;
            padding: 3vw 4vw;
            border-radius: 4vw;
            overflow-y: auto;
        }

        #cartItems {
            max-height: 40vh;
        }

        #cartModal h2 {
            font-size: 5vw;
            text-align: center;
        }

        #checkoutCartButton,
        #closeCartButton {
            font-size: 3vw;
            padding: 1vw 3vw;
        }


    }

    @media (min-width: 600px) and (max-width: 1024px) and (orientation: portrait) {
        #cartModal .modal-content {
            width: 80% !important;
            max-height: 80vh;
            padding: 5% 6%;
            border-radius: 3vw;
            overflow-y: auto;
        }

        #cartItems {
            max-height: 50vh;
        }

        #cartModal h2 {
            font-size: 5vw;
            text-align: center;
        }

        #checkoutCartButton,
        #closeCartButton {
            font-size: 3vw;
            padding: 2% 5%;
        }
    }

    /* Tablet Landscape (tinggi layar kecil) */
    @media (min-width: 768px) and (orientation: landscape) and (max-height: 600px) {
        #cartModal .modal-content {
            width: 85% !important;
            max-height: 75vh;
            padding: 4vw;
            border-radius: 2vw;
            overflow-y: auto;
        }

        #cartItems {
            max-height: 40vh;
        }

        #cartModal h2 {
            font-size: 4vw;
            text-align: center;
        }

        #checkoutCartButton,
        #closeCartButton {
            font-size: 2.5vw;
            padding: 1.5vw 4vw;
        }
    }

   

</style>

<div id="tradezone-modal" class="hidden fixed inset-0 z-[1010] flex items-center justify-center bg-[rgba(0,0,0,0.5)]"
    onclick="closeTradezoneModal()">
    <div id="tradezone-wrapper " class="flex items-center justify-center w-full h-full">
        <div id="tradezone-back" class="flex flex-col items-center gap-8 w-full h-full pt-16">
            <div id="tradezone-title" class="relative text-center font-bold text-4xl md:text-6xl text-[#ece7e3]">
                TradeZone
            </div>
            <div id="tradezone-container-utama"
                class="bg-[#ece7e3] flex flex-col justify-center items-center gap-4 rounded-3xl p-6 md:p-10 w-full shadow-2xl mt-4"
                onclick="event.stopPropagation()">
                <h1 class="text-2xl mt-10 md:text-4xl font-bold text-[#415943] -translate-y-6">
                    Commodity Shop
                </h1>
                <div id="tradezone-scrollable-content"
                    class="h-[430px] overflow-y-scroll overflow-x-hidden w-full max-w-[1400px] px-4 relative">
                    <div id="tradezone-container"
                        class="commodity-grid grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4 w-full">
                    </div>
                </div>
            </div>
        </div>
        <!-- Zoom (Detail) Modal -->
        <div id="tradezone-zoom-container"
            class="hidden fixed inset-0 z-60 flex items-center justify-center pt-20 pb-5 bg-[rgba(0,0,0,0.5)]"
            onclick="closeTradezoneZoom()">
            <div class="popup-content bg-[#ece7e3] flex flex-col items-center justify-center rounded-3xl p-6 md:p-10 w-full max-w-[1600px] h-auto md:h-[550px] shadow-2xl relative"
                onclick="event.stopPropagation()">
                <div class="flex flex-col md:flex-row w-full h-full items-center justify-center">
                    <div class="flex flex-col items-center w-full md:w-1/2">
                        <img id="tradezone-zoom-image" class="w-40 h-40 object-cover rounded-lg mt-15 shadow-xl border-[3px] border-[#415943]">
                        <p id="tradezone-zoom-price" class="text-lg md:text-2xl font-bold text-[#415943]"></p>
                    </div>
                    <div class="flex flex-col items-center w-full md:w-1/2">
                        <h2 id="tradezone-zoom-title" class="text-xl md:text-3xl font-bold text-[#415943] mb-4"></h2>


                    </div>
                </div>
                <div class="mt-6 flex space-x-4">
                    <button id="buyNowButton" class="bg-[#415943] text-white font-bold py-2 px-6 rounded-3xl">BUY
                        NOW</button>
                    <button id="addToCartButton"
                        class="border border-[#415943] text-[#415943] font-bold py-2 px-6 rounded-3xl">ADD TO
                        CART</button>
                </div>

                <!-- Back Button -->
                <button id="tradezone-back-button" class="absolute top-3 right-20 z-50">
                    <img src="/assets/undo.png" alt="Back" class="w-16 h-16">
                </button>

                <!-- Cart Icon -->
                <button id="cartIcon" class="absolute top-4 right-6 z-50">
                    <img src="/assets/shopping-cart.png" alt="Cart" class="w-12 h-12">
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Cart Modal -->
<div id="cartModal" class="hidden" onclick="closeCartModal()">
    <div class="modal-content " onclick="event.stopPropagation();">
        <h2 class="text-3xl font-bold text-[#415943] mb-4">Your Cart</h2>
        <div id="cartItems" class="overflow-y-auto h-[50vh]">
        </div>
        <div class="flex justify-center mt-4 space-x-4">
            <button id="checkoutCartButton" class="bg-[#415943] text-white font-bold py-2 px-6 rounded-3xl">Checkout</button>
            <button id="closeCartButton"
                class="border border-[#415943] text-[#415943] font-bold py-2 px-6 rounded-3xl">Close</button>
        </div>

    </div>
</div>


<script>
    (function() {
        let currentTradeItem = null;
        window.assetPath = "{{ asset('') }}";
        const tradezoneData = @json($commodities);
        const formattedTradezoneItems = tradezoneData.map(item => ({
            id: item.id,
            name: item.name,
            price: item.price,
            image: window.assetPath + item.image
        }));

        // Tradezone modal elements
        const tradezoneModal = document.getElementById('tradezone-modal');
        const tradezoneContainer = document.getElementById('tradezone-container');
        const tradezoneZoomContainer = document.getElementById('tradezone-zoom-container');
        const tradezoneZoomImage = document.getElementById('tradezone-zoom-image');
        const tradezoneZoomTitle = document.getElementById('tradezone-zoom-title');
        const tradezoneZoomPrice = document.getElementById('tradezone-zoom-price');
        const tradezoneBackButton = document.getElementById('tradezone-back-button');
        const tradezoneContainerUtama = document.getElementById('tradezone-container-utama');
        const tradezoneScrollableContent = document.getElementById('tradezone-scrollable-content');

        // Cart modal elements
        const cartIcon = document.getElementById('cartIcon');
        const cartModal = document.getElementById('cartModal');
        const cartItemsContainer = document.getElementById('cartItems');
        const closeCartButton = document.getElementById('closeCartButton');

        function updateTradezoneScrollbar() {
            let scrollTop = tradezoneScrollableContent.scrollTop;
            let scrollHeight = tradezoneScrollableContent.scrollHeight - tradezoneScrollableContent.clientHeight;
            let scrollPercentage = (scrollTop / scrollHeight) * 100;
            document.documentElement.style.setProperty('--scroll-progress', scrollPercentage + '%');
        }
        tradezoneScrollableContent.addEventListener('scroll', updateTradezoneScrollbar);
        updateTradezoneScrollbar();

        // Render commodity cards in the grid
        function renderTradezoneItems() {
            tradezoneContainer.innerHTML = "";
            formattedTradezoneItems.forEach(item => {
                const card = document.createElement('div');
                card.classList.add("commodity-card", "flex", "flex-col", "items-center", "justify-center",
                    "rounded-lg");
                card.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="rounded-lg shadow-xl mb-2 border-[3px] border-[#415943]">
                    <p class="text-lg md:text-xl font-bold text-[#415943]">$${item.price}</p>
                `;
                // <h2>${item.name}</h2>
                card.addEventListener('click', () => {
                    renderTradezoneDetail(item);
                });
                tradezoneContainer.appendChild(card);
            });
        }
        renderTradezoneItems();

        // Display detail modal for selected commodity
        function renderTradezoneDetail(item) {
            currentTradeItem = item;
            tradezoneZoomImage.src = item.image;
            tradezoneZoomTitle.textContent = item.name;
            tradezoneZoomPrice.textContent = "$" + item.price;
            tradezoneZoomContainer.classList.remove('hidden');
            tradezoneContainerUtama.classList.add('hidden');
        }

        // Back button in detail modal
        tradezoneBackButton.addEventListener('click', () => {
            tradezoneZoomContainer.classList.add('hidden');
            tradezoneContainerUtama.classList.remove('hidden');
            window.scrollTo(0, 0);
        });

        // Close modal functions
        function closeTradezoneZoom() {
            tradezoneZoomContainer.classList.add('hidden');
        }

        function closeTradezoneModal() {
            tradezoneModal.classList.add("hidden");
        }

        function closeCartModal() {
            cartModal.classList.add("hidden");
            cartModalOverlay.classList.add('hidden');
        }
        window.closeCartModal = closeCartModal;

        tradezoneModal.addEventListener("click", closeTradezoneModal);
        cartModal.addEventListener("click", closeCartModal);
        closeCartButton.addEventListener("click", closeCartModal);

        window.openTradezoneModal = function() {
            tradezoneContainerUtama.classList.remove('hidden');
            tradezoneZoomContainer.classList.add('hidden');
            renderTradezoneItems();
            tradezoneModal.classList.remove('hidden');
        };

        function deleteCartItem(index) {
            let cart = JSON.parse(localStorage.getItem("commodityCart") || "[]");
            cart.splice(index, 1);
            localStorage.setItem("commodityCart", JSON.stringify(cart));
            renderCart();
        }
        window.deleteCartItem = deleteCartItem;

        function renderCart() {
            let cart = JSON.parse(localStorage.getItem("commodityCart") || "[]");
            let html = "";
            let totalQty = 0;
            let totalPrice = 0;
            if (cart.length === 0) {
                html = "<p class='text-center text-xl md:text-2xl font-bold text-gray-500'>Your cart is empty.</p>";
            } else {
                cart.forEach((item, index) => {
                    let itemTotal = item.price * item.quantity;
                    totalQty += item.quantity;
                    totalPrice += itemTotal;

                    html += `
                        <div class="flex flex-col md:flex-row justify-between items-center py-3 border-b border-gray-300">
                            <!-- Gambar Produk -->
                            <div class="flex items-center space-x-3 md:space-x-5 w-full md:w-auto mb-3 md:mb-0">
                                <img src="${item.image}" alt="${item.name}" class="w-16 h-16 md:w-24 md:h-24 rounded-lg shadow-md border-2 border-[#415943]">
                                
                                <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                                    <p class="text-sm md:text-lg font-semibold text-[#415943]">${item.name}</p>
                                </div>

                                <div class="text-sm md:text-lg font-semibold text-[#415943] w-full text-center md:text-center md:w-auto">
                                    ${item.quantity} pcs
                                </div>
                            </div>
                            <!-- Harga + Tombol Delete -->
                            <div class="flex justify-between md:justify-end items-center w-full md:w-auto space-x-3 md:space-x-5">
                                <p class="text-sm md:text-lg font-semibold text-[#415943]">$${item.price}</p>
                                <button onclick="deleteCartItem(${index})" class="text-red-500 text-xs md:text-sm font-bold">Delete</button>
                            </div>
                        </div>
                    `;
                });

                html += `
                     <div class="grid grid-cols-3 gap-2 items-center font-bold mt-4 pt-4 border-t border-gray-400">
                        <div class="text-sm md:text-lg font-semibold text-[#415943] text-left">Total</div>
                        <div class="text-sm md:text-lg font-semibold text-[#415943] text-center">${totalQty} pcs</div>
                        <div class="text-sm md:text-lg font-semibold text-[#415943] text-right">$${totalPrice.toLocaleString()}</div>
                    </div>
                `;
            }

            cartItemsContainer.innerHTML = html;
        }

        cartIcon.addEventListener('click', () => {
            
            tradezoneModal.classList.add('hidden');
            tradezoneZoomContainer.classList.add('hidden');
            tradezoneContainerUtama.classList.add('hidden');
            renderCart();
            cartModal.classList.remove('hidden');
            cartModalOverlay.classList.remove('hidden');
        });

        document.getElementById("checkoutCartButton").addEventListener("click", function() {
            let cart = JSON.parse(localStorage.getItem("commodityCart") || "[]");
            if (cart.length === 0) {
                Swal.fire("Cart Empty", "Your cart is empty. Please add some items before checking out.",
                    "info");
                return;
            }
           

            let payloadItems = cart.map(item => ({
                commodity_id: item.id,
                quantity: item.quantity
            }));

            let totalPrice = 0;
            cart.forEach(item => {
                totalPrice += item.price * item.quantity;
            });
  // Cek apakah uang mencukupi
    let userBalance = {{ $team->coin }};
    if (totalPrice < userBalance) {
        // Jika uang mencukupi, tampilkan konfirmasi
        Swal.fire({
    title: '',
    html: `
        <div class="text-lg md:text-xl font-bold text-[#415943]">Are you sure you want to make the purchase?</div>
        <div class="text-lg md:text-xl font-bold text-[#415943]">Make sure to double-check before proceeding!</div>
    `,
    showCancelButton: true,
    confirmButtonText: "YES",
    cancelButtonText: "NO",
    customClass: {
        popup: 'custom-swal-popup',
        confirmButton: 'custom-swal-confirm',
        cancelButton: 'custom-swal-cancel'
    },
    buttonsStyling: false

        }).then((result) => {
            if (result.isConfirmed) {
                let payloadItems = cart.map(item => ({
                    commodity_id: item.id,
                    quantity: item.quantity
                }));

                // Proses pembelian
                fetch("{{ route('buy.multiple.commodities') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            items: payloadItems
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                            title: '',
                            html: `
                                <div class="text-lg md:text-xl font-bold text-[#415943]">Great choice!</div>
                                <div class="text-lg md:text-xl font-bold text-[#415943]">The item has been added to your cart!</div>
                            `,
                            showConfirmButton: true,
                            confirmButtonText: "OKAY",
                            customClass: {
                                popup: 'custom-success-popup',
                                confirmButton: 'custom-success-confirm'
                            },
                            buttonsStyling: false
                        }).then(() => {
                                localStorage.removeItem("commodityCart");
                                window.location.reload();
                            });
                        } else {
                            Swal.fire("Error", data.message, "error");
                        }
                    })
                    .catch(error => {
                        Swal.fire("Error", "An error occurred during checkout.", "error");
                    });
            }
        });
    }
});


        document.getElementById("buyNowButton").addEventListener("click", function() {
            Swal.fire({
                title: "Confirm Purchase",
                text: "Enter the quantity for " + currentTradeItem.name,
                input: 'number',
                inputAttributes: {
                    min: 1,
                    step: 1
                },
                inputValue: 1,
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Buy Now",
                cancelButtonText: "Cancel",
                customClass: {
                    popup: 'swal-high-z-index'
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const quantity = parseInt(result.value);
                    const payload = {
                        items: [{
                            commodity_id: currentTradeItem.id,
                            quantity: quantity
                        }]
                    };
                    fetch("{{ route('buy.multiple.commodities') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: "Success",
                                    text: "Purchase successful!",
                                    icon: "success",
                                    customClass: {
                                        popup: 'swal-high-z-index'
                                    }
                                }).then(() => window.location.reload());
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: data.message,
                                    icon: "error",
                                    customClass: {
                                        popup: 'swal-high-z-index'
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: "Error",
                                text: "An error occurred.",
                                icon: "error",
                                customClass: {
                                    popup: 'swal-high-z-index'
                                }
                            });
                        });
                }
            });
        });

        document.getElementById("addToCartButton").addEventListener("click", function() {
            Swal.fire({
                title: "Add to Cart",
                text: "Enter quantity for " + currentTradeItem.name,
                input: 'number',
                inputAttributes: {
                    min: 1,
                    step: 1
                },
                inputValue: 1,
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Add to Cart",
                cancelButtonText: "Cancel",
                customClass: {
                    popup: 'swal-high-z-index'
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const quantity = parseInt(result.value);
                    let cart = JSON.parse(localStorage.getItem("commodityCart") || "[]");
                    let existingItem = cart.find(i => i.id === currentTradeItem.id);
                    if (existingItem) {
                        existingItem.quantity += quantity;
                    } else {
                        cart.push({
                            id: currentTradeItem.id,
                            name: currentTradeItem.name,
                            price: currentTradeItem.price,
                            image: currentTradeItem.image,
                            quantity: quantity
                        });
                    }
                    localStorage.setItem("commodityCart", JSON.stringify(cart));
                    Swal.fire({
                        title: "Added",
                        text: currentTradeItem.name + " has been added to your cart.",
                        icon: "success",
                        customClass: {
                            popup: 'swal-high-z-index'
                        }
                    });
                }
            });
        });
    })();
</script>
