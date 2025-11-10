<x-app-layout title="Shopping Cart">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Shopping Cart</h1>
            <p class="text-gray-600">{{ $cartCount }} item(s) in your cart</p>
        </div>


        @if($cartItems->isEmpty())
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5.4M7 13v6a2 2 0 002 2h8a2 2 0 002-2v-6M9 19h6m-6 0v-3m6 3v-3"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-6">Add some products to get started!</p>
                <a href="{{ route('home') }}" class="bg-amber-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-amber-700 transition">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold text-gray-900">Cart Items</h2>
                        </div>

                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    <!-- Product Image -->
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($item->product->main_image)
                                            <img src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-medium text-gray-900 truncate">
                                            <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-amber-600">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>

                                        @if($item->variant)
                                        <div class="mt-1 text-sm text-gray-500">
                                            @if($item->variant->color)
                                            <span>{{ $item->variant->color->name }}</span>
                                            @endif
                                            @if($item->variant->size)
                                            <span class="ml-2">{{ $item->variant->size->name }}</span>
                                            @endif
                                        </div>
                                        @endif

                                        <div class="mt-2 flex items-center space-x-4">
                                            <span class="text-lg font-semibold text-amber-600">
                                                ৳{{ number_format($item->unit_price) }}
                                            </span>
                                            @if($item->product->isOnSale() && $item->product->price > $item->unit_price)
                                            <span class="text-sm text-gray-500 line-through">
                                                ৳{{ number_format($item->product->price) }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center border rounded">
                                            <button class="px-3 py-2 hover:bg-gray-100 cart-qty-minus"
                                                    data-cart-id="{{ $item->id }}">-</button>
                                            <input type="number" value="{{ $item->quantity }}"
                                                   class="w-16 text-center border-0 focus:ring-0 cart-qty-input"
                                                   data-cart-id="{{ $item->id }}" min="1" max="100">
                                            <button class="px-3 py-2 hover:bg-gray-100 cart-qty-plus"
                                                    data-cart-id="{{ $item->id }}">+</button>
                                        </div>
                                    </div>

                                    <!-- Item Total -->
                                    <div class="text-right">
                                        <div class="text-lg font-semibold text-gray-900">
                                            ৳{{ number_format($item->total_price) }}
                                        </div>
                                        <button class="text-sm text-red-600 hover:text-red-800 mt-1 cart-remove"
                                                data-cart-id="{{ $item->id }}">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm sticky top-6">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold text-gray-900">Order Summary</h2>
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="flex justify-between text-gray-600">
                                <span id="cart-subtotal-label">Subtotal ({{ $cartCount }} items)</span>
                                <span id="cart-subtotal">৳{{ number_format($cartTotal) }}</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span id="cart-shipping">
                                    @if($cartTotal > 1000)
                                        Free
                                    @else
                                        ৳100
                                    @endif
                                </span>
                            </div>

                            <hr class="border-gray-200">

                            <div class="flex justify-between text-lg font-semibold text-gray-900">
                                <span>Total</span>
                                <span id="cart-total">
                                    ৳{{ number_format($cartTotal + ($cartTotal > 1000 ? 0 : 100)) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 border-t">
                            <form action="{{ route('checkout.index') }}" method="GET" class="w-full">
                                <button type="submit"
                                   class="w-full bg-amber-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-amber-700 transition text-center block">
                                    Proceed to Checkout
                                </button>
                            </form>

                            <a href="{{ route('home') }}"
                               class="w-full bg-gray-100 text-gray-900 py-3 px-6 rounded-lg font-medium hover:bg-gray-200 transition text-center block mt-3">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @push('scripts')
    <script>
    function formatCurrency(amount) {
        return Math.round(amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function updateSubtotalCount(count) {
        const subtotalText = document.getElementById('cart-subtotal-label');
        if (subtotalText) {
            subtotalText.textContent = `Subtotal (${count} items)`;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Quantity update functionality
        document.querySelectorAll('.cart-qty-minus').forEach(btn => {
            btn.addEventListener('click', function() {
                const cartId = this.dataset.cartId;
                const input = document.querySelector(`.cart-qty-input[data-cart-id="${cartId}"]`);
                const currentValue = parseInt(input.value);

                if (currentValue > 1) {
                    updateCartQuantity(cartId, currentValue - 1);
                }
            });
        });

        document.querySelectorAll('.cart-qty-plus').forEach(btn => {
            btn.addEventListener('click', function() {
                const cartId = this.dataset.cartId;
                const input = document.querySelector(`.cart-qty-input[data-cart-id="${cartId}"]`);
                const currentValue = parseInt(input.value);

                if (currentValue < 100) {
                    updateCartQuantity(cartId, currentValue + 1);
                }
            });
        });

        document.querySelectorAll('.cart-qty-input').forEach(input => {
            input.addEventListener('change', function() {
                const cartId = this.dataset.cartId;
                const newValue = parseInt(this.value);
                console.log('Input change - cartId:', cartId, 'newValue:', newValue, 'raw value:', this.value);

                if (newValue >= 1 && newValue <= 100) {
                    updateCartQuantity(cartId, newValue);
                } else {
                    console.log('Invalid value, resetting to 1');
                    // Reset to previous value if invalid
                    this.value = 1;
                    updateCartQuantity(cartId, 1);
                }
            });
        });

        // Remove item functionality
        document.querySelectorAll('.cart-remove').forEach(btn => {
            btn.addEventListener('click', function() {
                const cartId = this.dataset.cartId;

                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    removeCartItem(cartId);
                }
            });
        });
    });

    function updateCartQuantity(cartId, quantity) {
        // Show loading state
        const input = document.querySelector(`.cart-qty-input[data-cart-id="${cartId}"]`);
        const originalValue = input.value;
        input.disabled = true;

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Make the request with JSON data
        fetch(`/cart/${cartId}/update`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                quantity: quantity,
                _token: csrfToken,
                _method: 'PATCH'
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('AJAX response data:', data);
            if (data.success) {
                console.log('Setting input value to:', quantity);
                // Update the input value
                input.value = quantity;

                // Update the item total on the page
                const itemRow = input.closest('.p-6');
                console.log('itemRow found:', !!itemRow);
                if (itemRow) {
                    const itemTotalElement = itemRow.querySelector('.text-right .text-lg.font-semibold');
                    console.log('itemTotalElement found:', !!itemTotalElement);
                    if (itemTotalElement) {
                        const newItemTotal = parseFloat(data.item_total);
                        console.log('Setting item total to:', '৳' + formatCurrency(newItemTotal));
                        itemTotalElement.textContent = '৳' + formatCurrency(newItemTotal);
                    }

                    // Update the order summary
                    console.log('Calling updateOrderSummary with:', data.cart_total);
                    updateOrderSummary(data.cart_total);

                    // Update cart count if available
                    if (data.cart_count !== undefined) {
                        updateCartCount(data.cart_count);
                        updateSubtotalCount(data.cart_count);
                    }

                    showNotification('Cart updated successfully', 'success');
                }
            } else {
                throw new Error(data.message || 'Failed to update cart');
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
            input.value = originalValue; // Revert to original value on error
            showNotification(error.message || 'Failed to update cart. Please try again.', 'error');
        })
        .finally(() => {
            input.disabled = false;
        });
    }

    function removeCartItem(cartId) {
        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Make the request with JSON data
        fetch(`/cart/${cartId}/remove`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _token: csrfToken,
                _method: 'DELETE'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the item from the DOM
                const itemElement = document.querySelector(`.cart-remove[data-cart-id="${cartId}"]`).closest('.p-6');
                itemElement.remove();

                // Update the order summary
                updateOrderSummary(data.cart_total);

                // Update the cart count
                updateCartCount(data.cart_count);
                updateSubtotalCount(data.cart_count);

                // Check if cart is empty
                const remainingItems = document.querySelectorAll('.cart-remove');
                if (remainingItems.length === 0) {
                    location.reload(); // Reload page to show empty cart message
                }
            } else {
                showNotification(data.message || 'Failed to remove item', 'error');
            }
        })
        .catch(error => {
            console.error('Error removing item:', error);
            showNotification('Failed to remove item. Please try again.', 'error');
        });
    }

    function updateOrderSummary(cartTotal) {
        console.log('updateOrderSummary called with cartTotal:', cartTotal, typeof cartTotal);

        // Ensure cartTotal is a number
        const parsedCartTotal = parseFloat(cartTotal);
        console.log('parsedCartTotal:', parsedCartTotal);

        if (isNaN(parsedCartTotal)) { // Check if the parsed value is not a number
            console.error('Could not parse cartTotal. Original value:', cartTotal);
            return; // Exit if parsing fails
        }

        const shipping = parsedCartTotal > 1000 ? 0 : 100;
        const total = parsedCartTotal + shipping;
        console.log('shipping:', shipping, 'total:', total);

        // Get elements by ID
        const subtotalElement = document.getElementById('cart-subtotal');
        const shippingElement = document.getElementById('cart-shipping');
        const totalElement = document.getElementById('cart-total');
        console.log('Elements found - subtotal:', !!subtotalElement, 'shipping:', !!shippingElement, 'total:', !!totalElement);

        // Update the elements if they exist
        if (subtotalElement) {
            subtotalElement.textContent = `৳${formatCurrency(parsedCartTotal)}`;
        }
        if (shippingElement) {
            shippingElement.textContent = shipping === 0 ? 'Free' : `৳${formatCurrency(shipping)}`;
        }
        if (totalElement) {
            totalElement.textContent = `৳${formatCurrency(total)}`;
        }
    }

    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count, [data-cart-count]');
        cartCountElements.forEach(element => {
            if (element.tagName === 'SPAN' || element.tagName === 'DIV') {
                element.textContent = count;
            } else {
                element.setAttribute('data-cart-count', count);
            }
        });
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;

        if (type === 'success') {
            notification.className += ' bg-green-500 text-white';
        } else if (type === 'error') {
            notification.className += ' bg-red-500 text-white';
        } else {
            notification.className += ' bg-blue-500 text-white';
        }

        notification.textContent = message;

        // Add to page
        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    </script>
    @endpush
</x-app-layout>
