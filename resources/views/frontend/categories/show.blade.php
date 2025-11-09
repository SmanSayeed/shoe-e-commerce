<x-app-layout>
    <div class="bg-white">
        <!-- Breadcrumb -->
        <div class="border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @php
                    $breadcrumbItems = [
                        ['label' => 'Home', 'url' => '/'],
                        ['label' => 'Categories', 'url' => '/categories']
                    ];
                    
                    if (isset($subcategory)) {
                        $breadcrumbItems[] = ['label' => $category->name, 'url' => route('categories.show', $category->slug)];
                        $breadcrumbItems[] = ['label' => $subcategory->name];
                    } else {
                        $breadcrumbItems[] = ['label' => $category->name];
                    }
                @endphp
                
                @include('components.breadcrumb', ['items' => $breadcrumbItems])
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar -->
                <div class="w-full lg:w-64 flex-shrink-0">
                    <div class="sticky top-24">
                        <x-category-sidebar 
                            :categories="$categories" 
                            :active-category="$activeCategory" 
                            :active-subcategory="$activeSubcategory"
                        />
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <!-- Category/Subcategory Header -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex-1">
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                                    {{ $subcategory->name ?? $category->name }}
                                </h1>
                                @if(($subcategory ?? $category)->description)
                                    <p class="text-gray-600">{{ $subcategory->description ?? $category->description }}</p>
                                @endif
                                <p class="text-sm text-gray-500 mt-2">{{ $products->total() }} products found</p>
                            </div>

                            @if(($subcategory ?? $category)->image)
                                <div class="md:w-32 md:h-32 w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('storage/' . ($subcategory->image ?? $category->image)) }}" 
                                         alt="{{ $subcategory->name ?? $category->name }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Subcategories (if viewing a category) -->
                    @if(!isset($subcategory) && $category->subcategories->count() > 0)
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Subcategories</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($category->subcategories as $subcat)
                                    <a href="{{ route('subcategories.show', [$category->slug, $subcat->slug]) }}"
                                       class="block p-4 border rounded-lg hover:border-amber-500 hover:bg-amber-50 transition">
                                        <div class="font-medium text-gray-900">{{ $subcat->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $subcat->products_count ?? 0 }} {{ Str::plural('product', $subcat->products_count ?? 0) }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Products Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        @if($products->count() > 0)
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-gray-900">
                                    {{ isset($subcategory) ? 'Products' : 'Featured Products' }}
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} results</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                @foreach($products as $product)
                                <div class="bg-white border border-gray-100 rounded-lg overflow-hidden hover:shadow-md transition-all duration-200 h-full flex flex-col">
                                    <!-- Product Image -->
                                    <div class="aspect-square bg-gray-50 overflow-hidden relative group">
                                        @php
                                            $primaryImage = $product->main_image ?? 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop';
                                            $primaryImageUrl = \Illuminate\Support\Str::startsWith($primaryImage, ['http://', 'https://', '//'])
                                                ? $primaryImage
                                                : asset($primaryImage);
                                        @endphp
                                        <a href="{{ route('products.show', $product->slug) }}" class="block h-full">
                                            <img src="{{ $primaryImageUrl }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full aspect-video object-cover group-hover:scale-105 transition-transform duration-300">
                                        </a>
                                        @if($product->isOnSale())
                                        <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-medium">
                                            -{{ $product->discount_percentage }}%
                                        </div>
                                        @endif
                                        
                                        @if($product->is_new)
                                        <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-medium">
                                            New
                                        </div>
                                        @endif
                                        
                                        <!-- Quick View Button -->
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                            <button class="bg-white text-amber-600 hover:bg-amber-50 rounded-full p-2 shadow-md transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-4 flex-1 flex flex-col">
                                        <div class="mb-1">
                                            <a href="{{ route('categories.show', $product->category->slug) }}" 
                                               class="text-xs font-medium text-amber-600 hover:text-amber-700">
                                                {{ $product->category->name ?? '' }}
                                            </a>
                                        </div>

                                        <h3 class="font-medium text-gray-900 mb-2 line-clamp-2 h-12">
                                            <a href="{{ route('products.show', $product->slug) }}" 
                                               class="hover:text-amber-600 transition-colors" 
                                               title="{{ $product->name }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>

                                        <!-- Price & Stock -->
                                        <div class="mt-auto">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-baseline space-x-2">
                                                    <span class="text-lg font-bold text-red-600">
                                                        ৳{{ number_format($product->current_price) }}
                                                    </span>
                                                    @if($product->isOnSale())
                                                    <span class="text-sm text-gray-500 line-through">
                                                        ৳{{ number_format($product->price) }}
                                                    </span>
                                                    @endif
                                                </div>
                                                
                                                @if($product->in_stock)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        In Stock
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Out of Stock
                                                    </span>
                                                @endif
                                            </div>

                                            @if($product->variants && $product->variants->count() > 0)
                                            <div class="text-xs text-gray-500 mb-3">
                                                {{ $product->variants->count() }} {{ Str::plural('variant', $product->variants->count()) }} available
                                            </div>
                                            @endif
                                            
                                            <!-- Rating -->
                                            <div class="flex items-center mb-3">
                                                <div class="flex text-amber-400 text-sm">
                                                    ★★★★★
                                                </div>
                                                <span class="text-xs text-gray-500 ml-1">(4.5)</span>
                                            </div>
                                            
                                            <!-- Action Buttons -->
                                            <div class="flex space-x-2 mt-auto">
                                                <a href="{{ route('products.show', $product->slug) }}" 
                                                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded text-center text-sm transition-colors">
                                                    View Details
                                                </a>
                                                
                                                @if($product->in_stock)
                                                    <button class="bg-amber-600 hover:bg-amber-700 text-white p-2 rounded transition-colors" 
                                                            @click="addToCart({{ $product->id }})"
                                                            title="Add to Cart">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if($products->hasPages())
                            <div class="mt-8 border-t border-gray-200 pt-6">
                                {{ $products->links() }}
                            </div>
                            @endif
                        @else
                            <!-- No Products Found -->
                            <div class="text-center py-12">
                                <div class="w-24 h-24 mx-auto mb-4 bg-gray-50 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">No products found</h3>
                                <p class="text-gray-500 mb-6">We couldn't find any products matching your criteria.</p>
                                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    Continue Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
