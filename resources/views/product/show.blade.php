<x-app-layout title="Product Details">
    <!-- Product Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- Product Media -->
            <div class="space-y-4 w-full overflow-hidden">
                @php
                    $resolveImageUrl = function ($path) {
                        if (!$path) {
                            return null;
                        }
                        return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])
                            ? $path
                            : asset($path);
                    };

                    // Build media array: video first, then images
                    $mediaItems = collect();
                    $videoId = null;

                    // Add video if available
                    if ($product->video_url) {
                        // Extract video ID from YouTube URL (improved regex for multiple formats)
                        $url = trim($product->video_url);

                        // Match various YouTube URL formats
                        if (
                            preg_match(
                                '/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
                                $url,
                                $matches,
                            )
                        ) {
                            $videoId = $matches[1];
                        }

                        if ($videoId) {
                            $mediaItems->push([
                                'type' => 'video',
                                'videoId' => $videoId,
                                'url' => "https://www.youtube-nocookie.com/embed/{$videoId}?rel=0&modestbranding=1",
                                'watchUrl' => "https://www.youtube.com/watch?v={$videoId}",
                                'thumbnail' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg",
                                'alt' => $product->name . ' - Video',
                            ]);
                        }
                    }

                    // Add main image if available
                    if ($product->main_image) {
                        $mediaItems->push([
                            'type' => 'image',
                            'url' => $resolveImageUrl($product->main_image),
                            'thumbnail' => $resolveImageUrl($product->main_image),
                            'alt' => $product->name,
                        ]);
                    }

                    // Add additional images
                    if ($product->images) {
                        foreach ($product->images as $image) {
                            $mediaItems->push([
                                'type' => 'image',
                                'url' => $resolveImageUrl($image->image_path),
                                'thumbnail' => $resolveImageUrl($image->image_path),
                                'alt' => $product->name,
                            ]);
                        }
                    }

                    // Set default media if no video or images
                    if ($mediaItems->isEmpty()) {
                        $mediaItems->push([
                            'type' => 'image',
                            'url' => 'https://images.unsplash.com/photo-1603796847227-9183fd69e884',
                            'thumbnail' => 'https://images.unsplash.com/photo-1603796847227-9183fd69e884',
                            'alt' => $product->name,
                        ]);
                    }

                    $currentMedia = $mediaItems->first();
                @endphp

                <!-- Main Media Display -->
                <div id="main-media-container"
                    style="background-color: white; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); width: 100%; position: relative; aspect-ratio: 10 / 7;">
                    <!-- Left Navigation Arrow -->
                    @if ($mediaItems->count() > 1)
                        <button id="preview-prev-btn"
                            style="position: absolute; left: 0.5rem; top: 50%; transform: translateY(-50%); z-index: 20; background-color: rgba(0, 0, 0, 0.7); color: white; border-radius: 9999px; padding: 0.5rem; transition: all 0.3s; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: none; cursor: pointer;"
                            aria-label="Previous image">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                    @endif

                    @if ($currentMedia['type'] === 'video')
                        <div class="aspect-video relative bg-gray-900 w-full h-full" id="video-container">
                            <!-- Autoplay Video -->
                            <iframe id="main-media"
                                src="{{ $currentMedia['url'] }}&autoplay=1&mute=1&rel=0&modestbranding=1"
                                title="{{ $currentMedia['alt'] }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen referrerpolicy="strict-origin-when-cross-origin"
                                class="w-full h-full absolute inset-0" style="border: none;">
                            </iframe>

                            <!-- Error Fallback (if iframe fails to load) -->
                            <div id="video-error" style="display: none;"
                                class="absolute inset-0 bg-gray-100 flex items-center justify-center p-6">
                                <div class="text-center max-w-sm">
                                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-700 font-semibold mb-2">Video Cannot Be Embedded</p>
                                    <p class="text-gray-600 text-sm mb-4">This video's owner has disabled embedding</p>
                                    <a href="{{ $currentMedia['watchUrl'] ?? '#' }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 0C4.477 0 0 4.477 0 10s4.477 10 10 10 10-4.477 10-10S15.523 0 10 0zm3.5 10.5l-5 3a.5.5 0 01-.75-.433v-6a.5.5 0 01.75-.433l5 3a.5.5 0 010 .866z" />
                                        </svg>
                                        Watch on YouTube
                                    </a>
                                    <p class="text-gray-500 text-xs mt-4">Click images below to view product photos</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div style="width: 100%; height: 100%; position: relative;">
                            <img id="main-media" src="{{ $currentMedia['url'] }}" alt="{{ $currentMedia['alt'] }}"
                                loading="eager"
                                onerror="this.src='https://images.unsplash.com/photo-1603796847227-9183fd69e884?q=80&w=800&auto=format&fit=crop'"
                                style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                        </div>
                    @endif

                    <!-- Right Navigation Arrow -->
                    @if ($mediaItems->count() > 1)
                        <button id="preview-next-btn"
                            style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); z-index: 20; background-color: rgba(0, 0, 0, 0.7); color: white; border-radius: 9999px; padding: 0.5rem; transition: all 0.3s; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: none; cursor: pointer;"
                            aria-label="Next image">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Media Thumbnails Slider -->
                @if ($mediaItems->count() > 1)
                    <div style="position: relative; width: 100%;">
                        <!-- Left Arrow Button -->
                        <button id="thumbnail-prev-btn"
                            style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); z-index: 10; background-color: rgba(255, 255, 255, 0.9); border-radius: 9999px; padding: 0.375rem; transition: all 0.3s; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: none; cursor: pointer;"
                            aria-label="Scroll thumbnails left">
                            <svg style="width: 1rem; height: 1rem; color: #374151;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>

                        <!-- Thumbnail Container -->
                        <div id="thumbnail-slider"
                            style="display: flex; gap: 0.5rem; overflow-x: auto; scroll-behavior: smooth; padding-left: 2rem; padding-right: 2rem; scrollbar-width: none; -ms-overflow-style: none;">
                            @foreach ($mediaItems as $index => $media)
                                <div class="media-thumbnail" data-index="{{ $index }}"
                                    data-media-type="{{ $media['type'] }}" data-media-url="{{ $media['url'] }}"
                                    data-video-id="{{ $media['videoId'] ?? '' }}"
                                    data-watch-url="{{ $media['watchUrl'] ?? '' }}"
                                    onclick="changeMedia({{ $index }}, '{{ $media['type'] }}', {{ json_encode($media['url']) }}, {{ json_encode($media['videoId'] ?? null) }}, {{ json_encode($media['watchUrl'] ?? null) }})"
                                    style="flex-shrink: 0; background-color: white; border-radius: 0.25rem; cursor: pointer; overflow: hidden; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); aspect-ratio: 1 / 1; position: relative; width: 4rem; height: 4rem; {{ $index === 0 ? 'outline: 2px solid #f59e0b; outline-offset: 2px;' : '' }}">
                                    @if ($media['type'] === 'video')
                                        <div style="position: relative; width: 100%; height: 100%;">
                                            <img src="{{ $media['thumbnail'] }}" alt="{{ $media['alt'] }}"
                                                style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                                            <div
                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                <div
                                                    style="background-color: rgba(0, 0, 0, 0.5); border-radius: 9999px; padding: 0.25rem;">
                                                    <svg style="width: 0.75rem; height: 0.75rem; color: white;"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 5v10l8-5-8-5z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ $media['thumbnail'] }}" alt="{{ $media['alt'] }}"
                                            style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Right Arrow Button -->
                        <button id="thumbnail-next-btn"
                            style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); z-index: 10; background-color: rgba(255, 255, 255, 0.9); border-radius: 9999px; padding: 0.375rem; transition: all 0.3s; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: none; cursor: pointer;"
                            aria-label="Scroll thumbnails right">
                            <svg style="width: 1rem; height: 1rem; color: #374151;" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Hide scrollbar for webkit browsers -->
                    <style>
                        #thumbnail-slider::-webkit-scrollbar {
                            display: none;
                        }
                    </style>
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
                            class="text-2xl font-bold text-amber-600">৳{{ number_format(round((float) $currentPrice), 0) }}</span>
                        @if ($hasDiscount)
                            <span id="original-price"
                                class="text-lg text-gray-500 line-through">৳{{ number_format(round((float) $product->price), 0) }}</span>
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
                    $variantsWithSize = $product->variants->filter(function ($variant) {
                        return $variant->size_id !== null && $variant->stock_quantity > 0;
                    });
                    $availableSizes = $variantsWithSize->unique('size_id')->sortBy(function ($variant) {
                        return $variant->size ? $variant->size->name : '';
                    });
                    $firstSize = $availableSizes->first();
                @endphp
                @if ($variantsWithSize->count() > 0)
                    <div id="product-variants" class="space-y-4">
                        <!-- Variants data for JavaScript -->
                        <script>
                            window.productVariants = {!! json_encode(
                                $product->variants->filter(function ($variant) {
                                        return $variant->size_id !== null && $variant->stock_quantity > 0;
                                    })->map(function ($variant) use ($product) {
                                        return [
                                            'id' => $variant->id,
                                            'size_id' => $variant->size_id,
                                            'size_name' => $variant->size ? $variant->size->name : 'Unknown',
                                            'price' => round((float) $product->current_price),
                                            'stock' => (int) $variant->stock_quantity,
                                            'sku' => $product->sku,
                                        ];
                                    })->values()->toArray(),
                                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE,
                            ) !!};
                        </script>

                        <div class="space-y-4">
                            <label class="text-sm font-medium text-gray-700">Select Size:</label>
                            <div class="flex flex-wrap gap-2" id="size-buttons">
                                @foreach ($availableSizes as $index => $variant)
                                    @php
                                        $sizeStock = $variantsWithSize
                                            ->where('size_id', $variant->size_id)
                                            ->sum('stock_quantity');
                                    @endphp
                                    @php
                                        $sizeName = $variant->size ? addslashes($variant->size->name) : 'Unknown';
                                        $sizeId = $variant->size ? $variant->size->id : 0;
                                    @endphp
                                    <button
                                        class="size-btn px-4 py-2 border rounded hover:border-amber-600  transition {{ $index === 0 ? 'bg-amber-600 text-white border-amber-600' : '' }}"
                                        data-size-id="{{ $sizeId }}" data-size-name="{{ $sizeName }}"
                                        data-stock="{{ $sizeStock }}"
                                        onclick="selectSize('{{ $sizeId }}', '{{ $sizeName }}', {{ $sizeStock }})">
                                        {{ $sizeName }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Color Selection -->
                        <div id="color-selection" class="space-y-4 hidden">
                            <label class="text-sm font-medium text-gray-700">Select Color:</label>
                            <div class="flex flex-wrap gap-2" id="color-buttons"></div>
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
                    <div><strong>Color:</strong> <span>{{ $product?->color?->name }}</span></div>
                    <div><strong>Availability:</strong>
                        @if ($product->isInStock())
                            <span id="stock-status" class="text-green-600">In Stock</span>
                        @else
                            <span id="stock-status" class="text-red-600">Out of Stock</span>
                        @endif
                    </div>
                    <div><strong>Category:</strong> <span
                            id="product-category">{{ $product->category->name ?? 'N/A' }}</span></div>
                    @if ($product->brand)
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
                            @if ($product->specifications)
                                <button
                                    class="tab-btn py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium"
                                    data-tab="specifications">
                                    Specifications
                                </button>
                            @endif
                            @if ($product->reviews && $product->reviews->count() > 0)
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
                                    @if ($product->description)
                                        {!! $product->description !!}
                                    @else
                                        <p class="text-gray-500">No description available for this product.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Specifications Tab -->
                        @if ($product->specifications)
                            <div id="specifications" class="tab-content">
                                <div class="prose max-w-none">
                                    <div id="product-specs">
                                        {!! $product->specifications !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Reviews Tab -->
                        @if ($product->reviews && $product->reviews->count() > 0)
                            <div id="reviews" class="tab-content">
                                <div class="space-y-6">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-xl font-semibold">Customer Reviews</h3>
                                        <button class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">
                                            Write a Review
                                        </button>
                                    </div>
                                    <div class="space-y-4">
                                        @foreach ($product->reviews as $review)
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
                                                @if ($review->comment)
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

        <!-- Suggested Products Section -->
        @php
            $suggestedProducts = \App\Models\Product::with(['images', 'variants'])
                ->where('child_category_id', $product->child_category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get()
                ->map(function ($suggestedProduct) {
                    return [
                        'product' => $suggestedProduct,
                        'discountPercentage' => $suggestedProduct->isOnSale()
                            ? round(
                                (($suggestedProduct->price - $suggestedProduct->sale_price) /
                                    $suggestedProduct->price) *
                                    100,
                            )
                            : 0,
                        'rating' => number_format(rand(350, 500) / 100, 1),
                        'productImage' =>
                            $suggestedProduct->main_image ??
                            ($suggestedProduct->images->first()->image_path ??
                                'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop'),
                    ];
                });
        @endphp

        @if ($suggestedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Suggested Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
                    @foreach ($suggestedProducts as $suggestedData)
                        <x-product-card :product="$suggestedData['product']" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    @push('scripts')
        <script>
            // Media navigation variables
            let currentMediaIndex = 0;
            const mediaItems = {!! json_encode(
                $mediaItems->map(function ($media) {
                        return [
                            'type' => $media['type'],
                            'url' => $media['url'],
                            'videoId' => $media['videoId'] ?? null,
                            'watchUrl' => $media['watchUrl'] ?? null,
                            'thumbnail' => $media['thumbnail'] ?? $media['url'],
                            'alt' => $media['alt'] ?? '',
                        ];
                    })->values()->toArray(),
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE,
            ) !!};

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

            // Navigate preview media (left/right)
            function navigatePreviewMedia(direction) {
                if (mediaItems.length <= 1) return;

                if (direction === 'next') {
                    currentMediaIndex = (currentMediaIndex + 1) % mediaItems.length;
                } else if (direction === 'prev') {
                    currentMediaIndex = (currentMediaIndex - 1 + mediaItems.length) % mediaItems.length;
                }

                const media = mediaItems[currentMediaIndex];
                changeMedia(currentMediaIndex, media.type, media.url, media.videoId, media.watchUrl);
            }

            // Scroll thumbnail slider
            function scrollThumbnails(direction) {
                const slider = document.getElementById('thumbnail-slider');
                if (!slider) return;

                const scrollAmount = 100; // pixels to scroll
                const currentScroll = slider.scrollLeft;

                if (direction === 'next') {
                    slider.scrollTo({
                        left: currentScroll + scrollAmount,
                        behavior: 'smooth'
                    });
                } else if (direction === 'prev') {
                    slider.scrollTo({
                        left: currentScroll - scrollAmount,
                        behavior: 'smooth'
                    });
                }
            }

            // Update thumbnail scroll to show active thumbnail
            function updateThumbnailScroll(index) {
                const slider = document.getElementById('thumbnail-slider');
                const thumbnail = document.querySelector(`[data-index="${index}"]`);

                if (!slider || !thumbnail) return;

                const sliderRect = slider.getBoundingClientRect();
                const thumbnailRect = thumbnail.getBoundingClientRect();
                const scrollLeft = slider.scrollLeft;
                const thumbnailLeft = thumbnailRect.left - sliderRect.left + scrollLeft;
                const thumbnailWidth = thumbnailRect.width;
                const sliderWidth = sliderRect.width;

                // Check if thumbnail is visible
                if (thumbnailLeft < scrollLeft) {
                    // Scroll to show thumbnail on the left
                    slider.scrollTo({
                        left: thumbnailLeft - 8, // 8px padding
                        behavior: 'smooth'
                    });
                } else if (thumbnailLeft + thumbnailWidth > scrollLeft + sliderWidth) {
                    // Scroll to show thumbnail on the right
                    slider.scrollTo({
                        left: thumbnailLeft + thumbnailWidth - sliderWidth + 8, // 8px padding
                        behavior: 'smooth'
                    });
                }
            }

            // Change media when thumbnail is clicked
            function changeMedia(index, type, url, videoId = null, watchUrl = '') {
                currentMediaIndex = index;
                const mainMediaContainer = document.getElementById('main-media-container');

                // Update thumbnail selection
                document.querySelectorAll('.media-thumbnail').forEach((thumb, i) => {
                    if (i === index) {
                        thumb.style.outline = '2px solid #f59e0b';
                        thumb.style.outlineOffset = '2px';
                    } else {
                        thumb.style.outline = 'none';
                        thumb.style.outlineOffset = '0';
                    }
                });

                // Update thumbnail scroll to show active thumbnail
                updateThumbnailScroll(index);

                // Preserve container style and navigation arrows
                const containerStyle = mainMediaContainer.getAttribute('style') || '';
                const previewPrevBtn = document.getElementById('preview-prev-btn');
                const previewNextBtn = document.getElementById('preview-next-btn');

                // Remove existing media containers (video-container or image container)
                const existingVideoContainer = document.getElementById('video-container');
                const existingImageContainer = mainMediaContainer.querySelector(
                    'div[style*="width: 100%"][style*="height: 100%"][style*="position: relative"]');

                if (existingVideoContainer) {
                    existingVideoContainer.remove();
                }
                if (existingImageContainer) {
                    existingImageContainer.remove();
                }

                if (type === 'video' && videoId) {
                    // Create video container with autoplay - keep video embedding exactly as is
                    const videoContainer = document.createElement('div');
                    videoContainer.className = 'aspect-video relative bg-gray-900 w-full h-full';
                    videoContainer.id = 'video-container';

                    const embedUrl =
                        `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&mute=1&rel=0&modestbranding=1`;
                    const youtubeUrl = watchUrl || `https://www.youtube.com/watch?v=${videoId}`;

                    videoContainer.innerHTML = `
                                <!-- Autoplay Video Iframe -->
                                <iframe id="main-media"
                                    src="${embedUrl}"
                                    title="Product Video"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    class="w-full h-full absolute inset-0"
                                    style="border: none;">
                                </iframe>

                                <!-- Error Message -->
                                <div id="video-error" style="display: none;" class="absolute inset-0 bg-gray-100 flex items-center justify-center p-6">
                                    <div class="text-center max-w-sm">
                                        <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-700 font-semibold mb-2">Video Cannot Be Embedded</p>
                                        <p class="text-gray-600 text-sm mb-4">This video's owner has disabled embedding</p>
                                        <a href="${youtubeUrl}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 0C4.477 0 0 4.477 0 10s4.477 10 10 10 10-4.477 10-10S15.523 0 10 0zm3.5 10.5l-5 3a.5.5 0 01-.75-.433v-6a.5.5 0 01.75-.433l5 3a.5.5 0 010 .866z"/>
                                            </svg>
                                            Watch on YouTube
                                        </a>
                                        <p class="text-gray-500 text-xs mt-4">Click images below to view product photos</p>
                                    </div>
                                </div>
                            `;

                    // Insert video container before next button (or at end if no next button)
                    if (previewNextBtn) {
                        mainMediaContainer.insertBefore(videoContainer, previewNextBtn);
                    } else {
                        mainMediaContainer.appendChild(videoContainer);
                    }
                    // Restore container style
                    mainMediaContainer.setAttribute('style', containerStyle);
                } else {
                    // Create image container with inline styles
                    const imageContainer = document.createElement('div');
                    imageContainer.setAttribute('style', 'width: 100%; height: 100%; position: relative;');

                    const imageElement = document.createElement('img');
                    imageElement.id = 'main-media';
                    imageElement.src = url;
                    imageElement.alt = 'Product image';
                    imageElement.loading = 'eager';
                    imageElement.setAttribute('style',
                        'width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;');

                    // Handle image load errors
                    imageElement.onerror = function() {
                        this.src =
                            'https://images.unsplash.com/photo-1603796847227-9183fd69e884?q=80&w=800&auto=format&fit=crop';
                    };

                    imageContainer.appendChild(imageElement);

                    // Insert image container before next button (or at end if no next button)
                    if (previewNextBtn) {
                        mainMediaContainer.insertBefore(imageContainer, previewNextBtn);
                    } else {
                        mainMediaContainer.appendChild(imageContainer);
                    }
                    // Restore container style
                    mainMediaContainer.setAttribute('style', containerStyle);
                }
            }

            // Variant selection functionality
            let selectedVariant = null;
            let selectedSizeId = null;

            function selectSize(sizeId, sizeName, stock) {
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

                const selectedVariantInfo = document.getElementById('selected-variant');
                const sizeVariants = window.productVariants ? window.productVariants.filter(variant => parseInt(variant
                    .size_id) === parseInt(sizeId)) : [];

                if (sizeVariants.length > 0) {
                    selectedVariant = sizeVariants[0].id; // Select first variant

                    // Enable add to cart button
                    const addToCartBtn = document.getElementById('add-to-cart');
                    if (addToCartBtn) {
                        addToCartBtn.disabled = false;
                        addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }

                    // Update stock status
                    const stockStatus = document.getElementById('stock-status');
                    if (stockStatus) {
                        const totalStock = sizeVariants.reduce((sum, v) => sum + (parseInt(v.stock) || 0), 0);
                        stockStatus.textContent = totalStock > 0 ? 'In Stock' : 'Out of Stock';
                        stockStatus.className = totalStock > 0 ? 'text-green-600' : 'text-red-600';
                    }
                } else {
                    selectedVariant = null;
                    // Disable add to cart button if no variants found
                    const addToCartBtn = document.getElementById('add-to-cart');
                    if (addToCartBtn) {
                        addToCartBtn.disabled = true;
                        addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }

                // Update selected info
                const selectedInfo = document.getElementById('selected-info');
                if (selectedInfo) {
                    selectedInfo.textContent = `Size: ${sizeName}`;
                }
                if (selectedVariantInfo) {
                    selectedVariantInfo.classList.remove('hidden');
                }
            }



            // Update selected info
            const sizeName = document.querySelector('.size-btn.bg-amber-600')?.dataset?.sizeName || 'Unknown Size';
            const selectedInfo = document.getElementById('selected-info');
            if (selectedInfo) {
                selectedInfo.textContent = `${sizeName}`;
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
                        const selectedSize = document.querySelector('.size-btn.bg-amber-600');
                        const availableStock = selectedSize ? parseInt(selectedSize.dataset.stock) : 0;
                        const currentValue = parseInt(qtyInput.value) || 0;

                        if (currentValue < availableStock) {
                            qtyInput.value = currentValue + 1;
                        } else {
                            showNotification(`Only ${availableStock} items available in stock`, 'error');
                        }
                    }
                });
            }

            // Add to cart functionality
            const addToCartBtn = document.getElementById('add-to-cart');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', () => {
                    if (!selectedVariant) {
                        alert('Please select a size.');
                        return;
                    }

                    const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
                    const selectedSize = document.querySelector('.size-btn.bg-amber-600');
                    const availableStock = selectedSize ? parseInt(selectedSize.dataset.stock) : 0;

                    // Validate quantity against available stock
                    if (quantity > availableStock) {
                        showNotification(`Only ${availableStock} items available in stock`, 'error');
                        return;
                    }

                    // Validate minimum quantity
                    if (quantity < 1) {
                        showNotification('Quantity must be at least 1', 'error');
                        return;
                    }

                    const originalText = addToCartBtn.textContent;
                    addToCartBtn.disabled = true;
                    addToCartBtn.innerHTML =
                        '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Adding...';

                    // Make API call to add to cart
                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                    'content') || '',
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
                        alert('Please select a size.');
                        return;
                    }

                    const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
                    const originalText = buyNowBtn.textContent;

                    buyNowBtn.disabled = true;
                    buyNowBtn.innerHTML =
                        '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Processing...';

                    // First add to cart
                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                    'content') || '',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                product_id: {{ $product->id }},
                                variant_id: selectedVariant,
                                quantity: quantity,
                                buy_now: true // Special flag for buy now
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update cart count in header
                                updateCartCount(data.cart_count);

                                // Redirect to checkout
                                window.location.href = '{{ route('checkout.index') }}';
                            } else {
                                if (data.redirect) {
                                    // Redirect to login if not authenticated
                                    window.location.href = data.redirect;
                                } else {
                                    showNotification(data.message || 'Failed to add to cart', 'error');
                                    buyNowBtn.disabled = false;
                                    buyNowBtn.textContent = originalText;
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error adding to cart:', error);
                            showNotification('Failed to add to cart. Please try again.', 'error');
                            buyNowBtn.disabled = false;
                            buyNowBtn.textContent = originalText;
                        });
                });
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
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

                // Preview navigation buttons
                const previewPrevBtn = document.getElementById('preview-prev-btn');
                const previewNextBtn = document.getElementById('preview-next-btn');

                if (previewPrevBtn) {
                    previewPrevBtn.addEventListener('click', () => navigatePreviewMedia('prev'));
                }

                if (previewNextBtn) {
                    previewNextBtn.addEventListener('click', () => navigatePreviewMedia('next'));
                }

                // Thumbnail slider navigation buttons
                const thumbnailPrevBtn = document.getElementById('thumbnail-prev-btn');
                const thumbnailNextBtn = document.getElementById('thumbnail-next-btn');

                if (thumbnailPrevBtn) {
                    thumbnailPrevBtn.addEventListener('click', () => scrollThumbnails('prev'));
                }

                if (thumbnailNextBtn) {
                    thumbnailNextBtn.addEventListener('click', () => scrollThumbnails('next'));
                }

                // Keyboard navigation (optional)
                document.addEventListener('keydown', (e) => {
                    const mainMediaContainer = document.getElementById('main-media-container');
                    if (!mainMediaContainer) return;

                    // Check if user is interacting with form elements
                    const activeElement = document.activeElement;
                    if (activeElement && (activeElement.tagName === 'INPUT' || activeElement.tagName ===
                            'TEXTAREA' || activeElement.tagName === 'SELECT')) {
                        return;
                    }

                    if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        navigatePreviewMedia('prev');
                    } else if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        navigatePreviewMedia('next');
                    }
                });

                // Initialize cart buttons state
                const addToCartBtn = document.getElementById('add-to-cart');
                const stockStatus = document.getElementById('stock-status');
                if ({{ $variantsWithSize->count() > 0 ? 'true' : 'false' }}) {
                    if (addToCartBtn) {
                        // addToCartBtn.disabled = true;
                        // addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                    if (stockStatus) {
                        stockStatus.textContent = 'Please select size';
                        stockStatus.className = 'text-gray-500';
                    }

                    // Auto-select first size
                    @if ($firstSize)
                        @php
                            $firstSizeId = $firstSize->size ? $firstSize->size->id : 0;
                            $firstSizeName = $firstSize->size ? $firstSize->size->name : 'Unknown';
                            $firstStock = $variantsWithSize->where('size_id', $firstSize->size_id)->sum('stock_quantity');
                        @endphp
                        selectSize('{{ $firstSizeId }}', '{{ $firstSizeName }}', {{ $firstStock }});
                    @endif
                } else {
                    if (addToCartBtn) {
                        addToCartBtn.disabled = true;
                        addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                    if (stockStatus) {
                        stockStatus.textContent = 'Out of Stock';
                        stockStatus.className = 'text-red-600';
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
                notification.className =
                    `fixed bottom-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full flex items-center gap-3`;

                if (type === 'success') {
                    notification.className += ' bg-green-500 text-white';
                } else if (type === 'error') {
                    notification.className += ' bg-red-500 text-white';
                } else {
                    notification.className += ' bg-blue-500 text-white';
                }

                // Create message text
                const messageText = document.createElement('span');
                messageText.className = 'flex-1';
                messageText.textContent = message;
                notification.appendChild(messageText);

                // Create close button
                const closeButton = document.createElement('button');
                closeButton.className =
                    'ml-2 text-white hover:text-gray-200 focus:outline-none transition-colors duration-200 flex-shrink-0';
                closeButton.innerHTML = '×';
                closeButton.setAttribute('aria-label', 'Close notification');
                closeButton.style.fontSize = '24px';
                closeButton.style.lineHeight = '1';
                closeButton.style.fontWeight = 'bold';
                closeButton.onclick = function() {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                };
                notification.appendChild(closeButton);

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
