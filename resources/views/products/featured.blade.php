<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Featured Products</h1>
            <p class="text-gray-600">Discover our handpicked selection of premium shoes</p>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form method="GET" action="{{ route('products.featured') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search featured products..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <!-- Sort -->
                <div class="md:w-48">
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    Apply Filters
                </button>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @forelse($products as $productData)
                @php
                    $product = $productData['product'];
                    $discountPercentage = $productData['discountPercentage'];
                    $rating = $productData['rating'];
                    $productImage = $productData['productImage'];
                @endphp

                <div class="bg-white rounded-xl shadow-sm hover:shadow-xl overflow-hidden group transition-all duration-300">
                    <!-- Featured Badge -->
                    <div class="relative">
                        <div class="absolute top-3 left-3 bg-gradient-to-r from-amber-400 to-orange-500 text-white px-2.5 py-1 text-xs font-bold rounded-lg shadow-sm z-10">
                            Featured
                        </div>

                        @if($discountPercentage > 0)
                            <!-- Discount Badge -->
                            <div class="absolute top-3 right-3 bg-gradient-to-r from-red-500 to-red-600 text-white px-2.5 py-1 text-xs font-bold rounded-lg shadow-sm z-10">-{{ $discountPercentage }}%</div>
                        @endif
                    </div>

                    <!-- Product Image -->
                    <div class="h-48 bg-gray-50 flex items-center justify-center overflow-hidden">
                        <img src="{{ $productImage }}"
                             alt="{{ $product->name }}"
                             class="h-40 w-40 object-cover rounded-lg group-hover:scale-105 transition-transform duration-300"
                             loading="lazy">
                    </div>

                    <!-- Product Details -->
                    <div class="p-4">
                        <h3 class="font-semibold text-sm mb-2 text-gray-900 line-clamp-2">{{ $product->name }}</h3>

                        <!-- Star Rating -->
                        <div class="flex items-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($rating))
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                            <span class="text-xs text-gray-500 ml-2 font-medium">{{ $rating }}</span>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center space-x-2 mb-3">
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <span class="text-red-600 font-bold text-lg">৳{{ number_format($product->sale_price) }}</span>
                                <span class="text-gray-400 line-through text-sm">৳{{ number_format($product->price) }}</span>
                            @else
                                <span class="text-red-600 font-bold text-lg">৳{{ number_format($product->price) }}</span>
                            @endif
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="w-full bg-gray-800 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 block text-center transition-colors duration-200">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <!-- No featured products found -->
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">No Featured Products Found</h3>
                        <p class="text-gray-500">Check back soon for our featured collection!</p>
                        <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            View All Products
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="flex justify-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-app-layout>