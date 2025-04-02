@extends('user.layout')

@section('style')
    <style>
        .commodity-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .commodity-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .commodity-card h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .commodity-card p {
            margin-bottom: 15px;
        }

        .commodity-card button {
            margin: 5px;
        }

        .cart-icon {
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-center text-4xl font-bold mb-6">Commodity Shop (Phase: {{ $currentPhase->phase }})</h1>

        <div class="commodity-grid">
            @foreach ($commodities as $commodity)
                <div class="commodity-card" data-id="{{ $commodity->id }}" data-price="{{ $commodity->price }}"
                    data-name="{{ $commodity->name }}">
                    <h2>{{ $commodity->name }}</h2>
                    <p>Price: {{ $commodity->price }}</p>

                    <div>
                        <button class="buy-now-button btn btn-primary" data-id="{{ $commodity->id }}">Buy Now</button>
                        <button class="add-to-cart-button btn btn-secondary" data-id="{{ $commodity->id }}">Add to
                            Cart</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="cart-icon" id="cartIcon">
        <i class="fa fa-shopping-cart"></i>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Echo.channel("phase-updates")
                .listen(".PhaseUpdated", (event) => {
                    window.location.reload();
                });
        })
        function getCart() {
            let cart = localStorage.getItem('commodityCart');
            return cart ? JSON.parse(cart) : [];
        }

        function setCart(cart) {
            localStorage.setItem('commodityCart', JSON.stringify(cart));
        }

        function addToCart(commodity) {
            let cart = getCart();
            let existing = cart.find(item => item.commodity_id === commodity.commodity_id);
            if (existing) {
                existing.quantity += commodity.quantity;
            } else {
                cart.push(commodity);
            }
            setCart(cart);
        }

        function showCheckout() {
            let cart = getCart();
            if (cart.length === 0) {
                Swal.fire('Cart is empty', 'Please add items to cart.', 'info');
                return;
            }
            let html = '<ul style="text-align:left;">';
            cart.forEach(function(item) {
                html += `<li>${item.name} - Quantity: ${item.quantity} - Price: ${item.price}</li>`;
            });
            html += '</ul>';

            Swal.fire({
                title: 'Checkout',
                html: html,
                showCancelButton: true,
                confirmButtonText: 'Checkout Now',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    checkoutCart(cart);
                }
            });
        }

        function checkoutCart(cart) {
            fetch("{{ route('buy.multiple.commodities') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        items: cart
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success == 0) {
                        Swal.fire('Error', data.message, 'error');
                    }
                    Swal.fire('Success', data.message, 'success');
                    localStorage.removeItem('commodityCart');
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'An error occurred while processing checkout.', 'error');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.buy-now-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const card = this.closest('.commodity-card');
                    const commodity_id = card.getAttribute('data-id');
                    const price = card.getAttribute('data-price');
                    const name = card.getAttribute('data-name');

                    Swal.fire({
                        title: 'Enter Quantity',
                        input: 'number',
                        inputAttributes: {
                            min: 1,
                            step: 1
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Next'
                    }).then((result) => {
                        if (result.isConfirmed && result.value) {
                            let quantity = parseInt(result.value);
                            if (quantity < 1) {
                                Swal.fire('Error', 'Quantity must be at least 1.', 'error');
                                return;
                            }
                            let cartItem = {
                                commodity_id: commodity_id,
                                quantity: quantity,
                                price: parseFloat(price),
                                name: name
                            };
                            localStorage.setItem('commodityCart', JSON.stringify([
                                cartItem]));
                            showCheckout();
                        }
                    });
                });
            });

            document.querySelectorAll('.add-to-cart-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const card = this.closest('.commodity-card');
                    const commodity_id = card.getAttribute('data-id');
                    const price = card.getAttribute('data-price');
                    const name = card.getAttribute('data-name');

                    Swal.fire({
                        title: 'Enter Quantity',
                        input: 'number',
                        inputAttributes: {
                            min: 1,
                            step: 1
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Add to Cart'
                    }).then((result) => {
                        if (result.isConfirmed && result.value) {
                            let quantity = parseInt(result.value);
                            if (quantity < 1) {
                                Swal.fire('Error', 'Quantity must be at least 1.', 'error');
                                return;
                            }
                            let cartItem = {
                                commodity_id: commodity_id,
                                quantity: quantity,
                                price: parseFloat(price),
                                name: name
                            };
                            addToCart(cartItem);
                            Swal.fire('Added', `${name} added to cart`, 'success');
                        }
                    });
                });
            });

            document.getElementById('cartIcon').addEventListener('click', function() {
                showCheckout();
            });
        });
    </script>
@endsection
