<style>
    .hidden {
        display: none !important;
    }

    .commodity-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
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
        height: auto;
    }

    @media (min-width: 768px) {
        #tradezone-container-utama {
            height: 550px;
        }
    }

    #tradezone-title {
        margin-top: 5%;
    }

    #cartIcon {
        position: fixed;
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
    }

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
        background: #fff;
        border-radius: 2.5vw;
        width: 90%;
        max-width: 55rem;
        max-height: 90vh;
        padding: 2rem;
        overflow-y: auto;
    }

    .swal2-popup.swal-high-z-index {
        z-index: 100000 !important;
    }
</style>

<div id="tradezone-modal" class="hidden fixed inset-0 z-[1010] flex items-center justify-center bg-[rgba(0,0,0,0.5)]"
    onclick="closeTradezoneModal()">
    <div id="tradezone-wrapper">
        <div id="tradezone-back" class="flex flex-col items-center gap-8 w-full h-full pt-16">
            <div id="tradezone-title" class="relative text-center font-bold text-4xl md:text-6xl text-[#ece7e3]">
                TradeZone
            </div>
            <div id="tradezone-container-utama"
                class="bg-[#ece7e3] flex flex-col justify-center items-center gap-4 rounded-3xl p-6 md:p-10 w-full shadow-2xl mt-4"
                onclick="event.stopPropagation()">
                <h1 class="text-2xl md:text-4xl font-bold text-[#415943] -translate-y-6">
                    Commodity Shop
                </h1>
                <div id="tradezone-scrollable-content"
                    class="h-[430px] overflow-y-scroll overflow-x-hidden w-full max-w-[1400px] px-4 relative">
                    <div id="tradezone-container" class="commodity-grid">
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
                        <img id="tradezone-zoom-image" class="w-40 h-40 object-cover rounded-lg mt-15">
                    </div>
                    <div class="flex flex-col items-center w-full md:w-1/2">
                        <h2 id="tradezone-zoom-title" class="text-xl md:text-3xl font-bold text-[#415943] mb-4"></h2>
                        <p id="tradezone-zoom-price" class="text-lg md:text-2xl font-bold text-[#415943]"></p>
                        <div class="mt-4 flex space-x-4">
                            <button id="buyNowButton" class="bg-green-500 text-white font-bold py-2 px-4 rounded">Buy
                                Now</button>
                            <button id="addToCartButton" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Add
                                to Cart</button>
                        </div>
                    </div>
                </div>
                <button id="tradezone-back-button"
                    class="bg-[#415943] text-white font-bold px-10 md:px-20 py-2 rounded-3xl mt-2 md:mt-3">BACK</button>
            </div>
        </div>
    </div>
</div>

<!-- Cart Icon -->
<div id="cartIcon">
    <i class="fa fa-shopping-cart"></i>
</div>

<!-- Cart Modal -->
<div id="cartModal" class="hidden" onclick="closeCartModal()">
    <div class="modal-content" onclick="event.stopPropagation();">
        <h2 class="text-3xl font-bold text-[#415943] mb-4">Your Cart</h2>
        <div id="cartItems" class="overflow-y-auto h-[50vh]">
        </div>
        <button id="checkoutCartButton" class="bg-green-500 text-white font-bold px-10 py-2 rounded mt-4">
            Checkout
        </button>
        <button id="closeCartButton" class="bg-[#415943] text-white font-bold px-10 py-2 rounded mt-4">
            Close
        </button>
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
                card.classList.add("commodity-card");
                card.innerHTML = `
                    <img src="${item.image}" alt="${item.name}">
                    <h2>${item.name}</h2>
                    <p>Price: ${item.price}</p>
                `;
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
            tradezoneZoomPrice.textContent = "Price: " + item.price;
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

        function renderCart() {
            let cart = JSON.parse(localStorage.getItem("commodityCart") || "[]");
            let html = "";
            if (cart.length === 0) {
                html = "<p>Your cart is empty.</p>";
            } else {
                cart.forEach(item => {
                    html += `<div class="flex justify-between border-b border-gray-300 py-2">
                                <div>
                                    <p class="font-bold">${item.name}</p>
                                    <p>Quantity: ${item.quantity}</p>
                                </div>
                                <div>
                                    <p class="text-[#3e5c49]">Price: ${item.price}</p>
                                </div>
                             </div>`;
                });
            }
            cartItemsContainer.innerHTML = html;
        }

        cartIcon.addEventListener('click', () => {
            renderCart();
            cartModal.classList.remove('hidden');
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
                        Swal.fire("Success", "Checkout successful!", "success")
                            .then(() => {
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
