<x-app-layout>
    <!-- Product Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- Product Images -->
            <div class="space-y-4">
                @php
                    $resolveImageUrl = function ($path) {
                        if (! $path) {
                            return null;
                        }
                        return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])
                            ? $path
                            : asset($path);
                    };
                    $rawMainImage = $product->main_image
                        ?? $product->images->first()->image_path
                        ?? 'https://images.unsplash.com/photo-1603796847227-9183fd69e884';
                    $mainImage = $resolveImageUrl($rawMainImage);
                @endphp
                <div class="product-image bg-white rounded-lg overflow-hidden shadow-sm">
                    <img id="main-image" src="{{ $mainImage }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover">
                </div>
                @if($product->images && $product->images->count() > 1)
                    <div id="thumbnail-grid" class="grid grid-cols-4 gap-2">
                        @foreach($product->images->take(4) as $image)
                            <div
                                class="product-image bg-white rounded cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                                @php
                                    $thumbUrl = $resolveImageUrl($image->image_path);
                                @endphp
                                <img src="{{ $thumbUrl }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover" onclick="changeMainImage('{{ $thumbUrl }}')">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <h1 id="product-title" class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-4">
                        @php
                            $currentPrice = $product->current_price;
                            $hasDiscount = $product->isOnSale();
                        @endphp
                        <span id="product-price"
                            class="text-2xl font-bold text-amber-600">৳{{ number_format($currentPrice) }}</span>
                        @if($hasDiscount)
                            <span id="original-price"
                                class="text-lg text-gray-500 line-through">৳{{ number_format($product->price) }}</span>
                            <span id="discount-badge"
                                class="bg-red-100 text-red-800 text-sm px-2 py-1 rounded">-{{ $product->discount_percentage }}%</span>
                        @else
                            <span id="original-price" class="text-lg text-gray-500 line-through hidden">৳0</span>
                            <span id="discount-badge"
                                class="bg-red-100 text-red-800 text-sm px-2 py-1 rounded hidden">-0%</span>
                        @endif
                    </div>
                </div>

                <!-- Product Variants -->
                @php
                    $completeVariants = $product->variants->filter(function ($variant) {
                        return $variant->size_id !== null && $variant->color_id !== null && $variant->size && $variant->color;
                    });
                @endphp
                @if($completeVariants->count() > 0)
                                <div id="product-variants" class="space-y-4">
                                    <!-- Variants data for JavaScript -->
                                    <script>
                                        window.productVariants = {!! json_encode($product->variants->filter(function ($variant) {
                        return $variant->size_id !== null &&
                            $variant->color_id !== null &&
                            $variant->size &&
                            $variant->color;
                    })->map(function ($variant) {
                        return [
                            'id' => $variant->id,
                            'size_id' => $variant->size_id,
                            'size_name' => $variant->size->name,
                            'color_id' => $variant->color_id,
                            'color_name' => $variant->color->name,
                            'color_code' => $variant->color->code,
                            'price' => (float) $variant->current_price,
                            'stock' => (int) $variant->stock_quantity,
                            'sku' => $variant->sku,
                        ];
                    })->values()->toArray(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!};
                                    </script>

                                    <div class="space-y-4">
                                        <label class="text-sm font-medium text-gray-700">Select Size:</label>
                                        <div class="flex flex-wrap gap-2" id="size-buttons">
                                            @php
                                                $availableSizes = $completeVariants->unique('size_id')->sortBy('size.name');
                                            @endphp
                                            @foreach($availableSizes as $variant)
                                                <button
                                                    class="size-btn px-4 py-2 border rounded hover:border-amber-600 hover:text-amber-600 transition"
                                                    data-size-id="{{ $variant->size->id ?? '' }}"
                                                    data-size-name="{{ $variant->size->name ?? 'Unknown' }}"
                                                    onclick="selectSize('{{ $variant->size->id ?? 0 }}', '{{ $variant->size->name ?? 'Unknown' }}')">
                                                    {{ $variant->size->name ?? 'Unknown' }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Color selection (shown after size is selected) -->
                                    <div id="color-selection" class="space-y-2 hidden">
                                        <label class="text-sm font-medium text-gray-700">Select Color:</label>
                                        <div class="flex flex-wrap gap-2" id="color-buttons">
                                            <!-- Colors will be populated by JavaScript -->
                                        </div>
                                    </div>

                                    <!-- Selected variant info -->
                                    <div id="selected-variant" class="hidden">
                                        <div class="text-sm text-gray-600">
                                            Selected: <span id="selected-info" class="font-medium text-gray-900"></span>
                                        </div>
                                    </div>
                                </div>
                @endif

                <!-- Stock Status -->
                <div class="border-t pt-6 space-y-2 text-sm text-gray-600">
                    <div><strong>SKU:</strong> <span id="product-sku">{{ $product->sku }}</span></div>
                    <div><strong>Availability:</strong>
                        @if($product->isInStock())
                            <span id="stock-status" class="text-green-600">In Stock</span>
                        @else
                            <span id="stock-status" class="text-red-600">Out of Stock</span>
                        @endif
                    </div>
                    <div><strong>Category:</strong> <span
                            id="product-category">{{ $product->category->name ?? 'N/A' }}</span></div>
                    @if($product->brand)
                        <div><strong>Brand:</strong> {{ $product->brand->name }}</div>
                    @endif
                </div>

                <!-- Quantity and Actions -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <label class="text-sm font-medium text-gray-700">Quantity:</label>
                        <div class="flex items-center border rounded">
                            <button id="qty-minus" class="px-3 py-2 hover:bg-gray-100">-</button>
                            <input id="quantity" type="number" value="1" min="1"
                                class="w-16 text-center border-0 focus:ring-0">
                            <button id="qty-plus" class="px-3 py-2 hover:bg-gray-100">+</button>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button id="add-to-cart"
                            class="flex-1 bg-amber-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-amber-700 transition">
                            Add to Cart
                        </button>
                        <button id="buy-now"
                            class="flex-1 bg-gray-900 text-white py-3 px-6 rounded-lg font-medium hover:bg-gray-800 transition">
                            Buy Now
                        </button>
                    </div>
                </div>

                <!-- Product Tabs -->
                <div class="mt-16">
                    <div class="border-b border-gray-200">
                        <nav class="flex space-x-8">
                            <button
                                class="tab-btn py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium active"
                                data-tab="description">
                                Description
                            </button>
                            @if($product->specifications)
                                <button
                                    class="tab-btn py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium"
                                    data-tab="specifications">
                                    Specifications
                                </button>
                            @endif
                            @if($product->reviews && $product->reviews->count() > 0)
                                <button
                                    class="tab-btn py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium"
                                    data-tab="reviews">
                                    Reviews ({{ $product->reviews->count() }})
                                </button>
                            @endif
                        </nav>
                    </div>

                    <div class="py-8">
                        <!-- Description Tab -->
                        <div id="description" class="tab-content active">
                            <div class="prose max-w-none">
                                <div id="product-description">
                                    @if($product->description)
                                        {!! nl2br(e($product->description)) !!}
                                    @elseif($product->short_description)
                                        {!! nl2br(e($product->short_description)) !!}
                                    @else
                                        <p class="text-gray-500">No description available for this product.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Specifications Tab -->
                        @if($product->specifications)
                            <div id="specifications" class="tab-content">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div id="product-specs">
                                        @php
                                            $specs = is_array($product->specifications) ? $product->specifications : json_decode($product->specifications, true);
                                        @endphp
                                        @if($specs && is_array($specs))
                                            <div class="space-y-3">
                                                @foreach($specs as $key => $value)
                                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                                        <span class="font-medium text-gray-700">{{ $key }}:</span>
                                                        <span class="text-gray-600">{{ $value }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-gray-500">No specifications available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Reviews Tab -->
                        @if($product->reviews && $product->reviews->count() > 0)
                            <div id="reviews" class="tab-content">
                                <div class="space-y-6">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-xl font-semibold">Customer Reviews</h3>
                                        <button class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">
                                            Write a Review
                                        </button>
                                    </div>
                                    <div class="space-y-4">
                                        @foreach($product->reviews as $review)
                                            <div class="border rounded-lg p-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="text-amber-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                                                        <span
                                                            class="font-medium">{{ $review->customer->name ?? 'Anonymous' }}</span>
                                                    </div>
                                                    <span
                                                        class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                                </div>
                                                @if($review->comment)
                                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
            @push('scripts')
                <script>
                    // Tab functionality
                    document.querySelectorAll('.tab-btn').forEach(btn => {
                        btn.addEventListener('click', () => {
                            const tabId = btn.dataset.tab;

                            // Remove active class from all tabs and buttons
                            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));

                            // Add active class to clicked button and corresponding tab
                            btn.classList.add('active');
                            document.getElementById(tabId).classList.add('active');
                        });
                    });

                    // Change main image when thumbnail is clicked
                    function changeMainImage(imageSrc) {
                        const mainImg = document.getElementById('main-image');
                        if (mainImg) {
                            mainImg.src = imageSrc;
                        }
                    }

                    // Variant selection functionality
                    let selectedVariant = null;
                    let selectedSizeId = null;

                    function selectSize(sizeId, sizeName) {
                        selectedSizeId = sizeId;

                        // Update size button states
                        document.querySelectorAll('.size-btn').forEach(btn => {
                            btn.classList.remove('bg-amber-600', 'text-white', 'border-amber-600');
                            btn.classList.add('border-gray-300', 'text-gray-700');
                        });

                        // Highlight selected size
                        const selectedSizeBtn = document.querySelector(`[data-size-id="${sizeId}"]`);
                        if (selectedSizeBtn) {
                            selectedSizeBtn.classList.remove('border-gray-300', 'text-gray-700');
                            selectedSizeBtn.classList.add('bg-amber-600', 'text-white', 'border-amber-600');
                        }

                        // Show color selection
                        const colorSelection = document.getElementById('color-selection');
                        const selectedVariantInfo = document.getElementById('selected-variant');
                        const colorButtons = document.getElementById('color-buttons');

                        // Filter colors for this size
                        const availableColors = window.productVariants ? window.productVariants.filter(variant =>
                            variant.size_id === parseInt(sizeId) && variant.color_id !== null
                        ) : [];

                        // Clear previous colors
                        colorButtons.innerHTML = '';

                        if (availableColors.length > 0) {
                            colorSelection.classList.remove('hidden');

                            // Add color buttons
                            availableColors.forEach(variant => {
                                const colorBtn = document.createElement('button');
                                colorBtn.className = 'color-btn px-4 py-2 border rounded hover:border-amber-600 hover:text-amber-600 transition flex items-center space-x-2';
                                colorBtn.setAttribute('data-variant-id', variant.id);
                                colorBtn.setAttribute('data-color-id', variant.color_id);
                                colorBtn.setAttribute('data-price', variant.price);
                                colorBtn.setAttribute('data-stock', variant.stock);
                                colorBtn.onclick = () => selectColor(variant.id, variant.color_name, variant.price, variant.stock);

                                // Add color indicator if available
                                let colorIndicator = '';
                                if (variant.color_code) {
                                    colorIndicator = `<div class="w-4 h-4 rounded-full border border-gray-300" style="background-color: ${variant.color_code}"></div>`;
                                }

                                colorBtn.innerHTML = `
                                        ${colorIndicator}
                                        <span>${variant.color_name}</span>
                                    `;

                                colorButtons.appendChild(colorBtn);
                            });
                        } else {
                            // No colors available for this size
                            colorSelection.classList.add('hidden');
                            if (selectedVariantInfo) {
                                selectedVariantInfo.classList.add('hidden');
                            }
                            selectedVariant = null;

                            // Reset buttons
                            const addToCartBtn = document.getElementById('add-to-cart');
                            if (addToCartBtn) {
                                addToCartBtn.disabled = true;
                                addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                            const stockStatus = document.getElementById('stock-status');
                            if (stockStatus) {
                                stockStatus.textContent = 'Please select options';
                                stockStatus.className = 'text-gray-500';
                            }
                        }

                        // Update selected info
                        const selectedInfo = document.getElementById('selected-info');
                        if (selectedInfo) {
                            selectedInfo.textContent = `${sizeName}`;
                        }
                        if (selectedVariantInfo) {
                            selectedVariantInfo.classList.remove('hidden');
                        }
                    }

                    function selectColor(variantId, colorName, price, stock) {
                        selectedVariant = variantId;

                        // Update color button states
                        document.querySelectorAll('.color-btn').forEach(btn => {
                            btn.classList.remove('bg-amber-600', 'text-white', 'border-amber-600');
                            btn.classList.add('border-gray-300', 'text-gray-700');
                        });

                        // Highlight selected color
                        const selectedColorBtn = document.querySelector(`[data-variant-id="${variantId}"]`);
                        if (selectedColorBtn) {
                            selectedColorBtn.classList.remove('border-gray-300', 'text-gray-700');
                            selectedColorBtn.classList.add('bg-amber-600', 'text-white', 'border-amber-600');
                        }

                        // Update price
                        if (price > 0) {
                            const productPrice = document.getElementById('product-price');
                            if (productPrice) {
                                productPrice.textContent = '৳' + Number(price).toLocaleString();
                            }
                        }

                        // Update stock status
                        const stockStatus = document.getElementById('stock-status');
                        const addToCartBtn = document.getElementById('add-to-cart');
                        if (stockStatus && addToCartBtn) {
                            if (stock > 0) {
                                stockStatus.textContent = 'In Stock';
                                stockStatus.className = 'text-green-600';
                                addToCartBtn.disabled = false;
                                addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            } else {
                                stockStatus.textContent = 'Out of Stock';
                                stockStatus.className = 'text-red-600';
                                addToCartBtn.disabled = true;
                                addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                        }

                        // Update selected info
                        const sizeName = document.querySelector('.size-btn.bg-amber-600')?.dataset?.sizeName || 'Unknown Size';
                        const selectedInfo = document.getElementById('selected-info');
                        if (selectedInfo) {
                            selectedInfo.textContent = `${sizeName} - ${colorName}`;
                        }

                        console.log('Selected variant:', variantId, 'Price:', price, 'Stock:', stock);
                    }

                    // Quantity controls
                    const qtyMinusBtn = document.getElementById('qty-minus');
                    const qtyPlusBtn = document.getElementById('qty-plus');
                    const qtyInput = document.getElementById('quantity');

                    if (qtyMinusBtn) {
                        qtyMinusBtn.addEventListener('click', () => {
                            if (qtyInput && qtyInput.value > 1) {
                                qtyInput.value = parseInt(qtyInput.value) - 1;
                            }
                        });
                    }

                    if (qtyPlusBtn) {
                        qtyPlusBtn.addEventListener('click', () => {
                            if (qtyInput) {
                                qtyInput.value = parseInt(qtyInput.value) + 1;
                            }
                        });
                    }

                    // Add to cart functionality
                    const addToCartBtn = document.getElementById('add-to-cart');
                    if (addToCartBtn) {
                        addToCartBtn.addEventListener('click', () => {
                            if (!selectedVariant) {
                                alert('Please select both size and color options.');
                                return;
                            }

                            const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
                            const originalText = addToCartBtn.textContent;

                            addToCartBtn.disabled = true;
                            addToCartBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Adding...';

                            // Make API call to add to cart
                            fetch('{{ route("cart.add") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    product_id: {{ $product->id }},
                                    variant_id: selectedVariant,
                                    quantity: quantity,
                                }),
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Update cart count in header
                                        updateCartCount(data.cart_count);

                                        // Show success message
                                        showNotification('Product added to cart successfully!', 'success');

                                        // Reset button
                                        addToCartBtn.disabled = false;
                                        addToCartBtn.textContent = originalText;
                                    } else {
                                        showNotification(data.message || 'Failed to add product to cart', 'error');
                                        addToCartBtn.disabled = false;
                                        addToCartBtn.textContent = originalText;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error adding to cart:', error);
                                    showNotification('Failed to add product to cart. Please try again.', 'error');
                                    addToCartBtn.disabled = false;
                                    addToCartBtn.textContent = originalText;
                                });
                        });
                    }

                    // Buy now functionality
                    const buyNowBtn = document.getElementById('buy-now');
                    if (buyNowBtn) {
                        buyNowBtn.addEventListener('click', () => {
                            if (!selectedVariant) {
                                alert('Please select both size and color options.');
                                return;
                            }

                            const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
                            const originalText = buyNowBtn.textContent;

                            buyNowBtn.disabled = true;
                            buyNowBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Processing...';

                            // Make API call for buy now
                            fetch('{{ route("checkout.buy-now") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    product_id: {{ $product->id }},
                                    variant_id: selectedVariant,
                                    quantity: quantity,
                                }),
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Redirect to order confirmation
                                        if (data.redirect) {
                                            window.location.href = data.redirect;
                                        } else {
                                            showNotification('Order placed successfully!', 'success');
                                            buyNowBtn.disabled = false;
                                            buyNowBtn.textContent = originalText;
                                        }
                                    } else {
                                        if (data.redirect) {
                                            // Redirect to login if not authenticated
                                            window.location.href = data.redirect;
                                        } else {
                                            showNotification(data.message || 'Failed to place order', 'error');
                                            buyNowBtn.disabled = false;
                                            buyNowBtn.textContent = originalText;
                                        }
                                    }
                                })
                                .catch(error => {
                                    console.error('Error placing order:', error);
                                    showNotification('Failed to place order. Please try again.', 'error');
                                    buyNowBtn.disabled = false;
                                    buyNowBtn.textContent = originalText;
                                });
                        });
                    }

                    // Initialize on page load
                    document.addEventListener('DOMContentLoaded', function () {
                        // Make sure description tab is active by default
                        const descriptionTab = document.querySelector('[data-tab="description"]');
                        const descriptionContent = document.getElementById('description');

                        if (descriptionTab && descriptionContent) {
                            // Remove active from all tabs
                            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

                            // Activate description tab
                            descriptionTab.classList.add('active');
                            descriptionContent.classList.add('active');
                        }

                        // Initialize cart buttons state
                        if ({{ $completeVariants->count() > 0 ? 'true' : 'false' }}) {
                            const addToCartBtn = document.getElementById('add-to-cart');
                            const stockStatus = document.getElementById('stock-status');
                            if (addToCartBtn) {
                                addToCartBtn.disabled = true;
                                addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                            if (stockStatus) {
                                stockStatus.textContent = 'Please select options';
                                stockStatus.className = 'text-gray-500';
                            }
                        }
                    });

                    // Helper function to update cart count in header
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

                    // Helper function to show notifications
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

                    // Helper function to show notifications
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
