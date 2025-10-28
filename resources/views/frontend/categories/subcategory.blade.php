<x-app-layout>
    <!-- Breadcrumb -->
    @include('components.breadcrumb', [
        'items' => [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Categories', 'url' => '/categories'],
            ['label' => $category->name, 'url' => route('categories.show', $category->slug)],
            ['label' => $subcategory->name]
        ]
    ])

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Category Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $subcategory->name }}</h1>
                    @if($subcategory->description)
                    <p class="text-gray-600">{{ $subcategory->description }}</p>
                    @endif
                    <p class="text-sm text-gray-500 mt-1">{{ $products->total() }} products found</p>
                </div>

                {{-- @if($subcategory->image)
                <div class="hidden md:block w-32 h-32 rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $subcategory->image) }}" alt="{{ $subcategory->name }}" class="w-full h-full object-cover">
                </div>
                @endif --}}
            </div>
        </div>

        <!-- Child Categories Filter -->
        @if($subcategory->childCategories && $subcategory->childCategories->count() > 0)
        <div class="mb-8">
            <div class="flex items-center space-x-4 overflow-x-auto pb-2">
                <a href="{{ route('categories.show', $category->slug) }}/{{ $subcategory->slug }}"
                   class="whitespace-nowrap px-4 py-2 rounded-lg border {{ !request('child_category') ? 'bg-slate-600 text-white border-slate-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }} transition">
                    All Products
                </a>
                @foreach($subcategory->childCategories as $childCategory)
                <a href="{{ route('categories.show', $category->slug) }}/{{ $subcategory->slug }}?child_category={{ $childCategory->slug }}"
                   class="whitespace-nowrap px-4 py-2 rounded-lg border {{ request('child_category') === $childCategory->slug ? 'bg-slate-600 text-white border-slate-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }} transition">
                    {{ $childCategory->name }}
                    <span class="text-xs opacity-75">({{ $childCategory->products()->count() }})</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                    <!-- Product Image -->
                    <div class="aspect-square bg-gray-100 overflow-hidden relative">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ $product->main_image ?? 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop' }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        </a>
                        @if($product->isOnSale())
                        <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-medium">
                            -{{ $product->discount_percentage }}%
                        </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <div class="mb-2">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-sm text-gray-500 hover:text-slate-600">
                                {{ $product->category->name ?? '' }}
                            </a>
                        </div>

                        <h3 class="font-medium text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-amber-600">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <div class="flex items-center space-x-2 mb-3">
                            <span class="text-lg font-bold text-red-600">৳{{ number_format($product->current_price) }}</span>
                            @if($product->isOnSale())
                            <span class="text-sm text-gray-500 line-through">৳{{ number_format($product->price) }}</span>
                            @endif
                        </div>

                        @if($product->variants && $product->variants->count() > 0)
                        <div class="text-xs text-gray-500 mb-3">
                            {{ $product->variants->count() }} variants available
                        </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1">
                                <div class="flex text-amber-400">
                                    ★★★★★
                                </div>
                                <span class="text-xs text-gray-500 ml-1">(4.5)</span>
                            </div>

                            <button class="px-3 py-1 rounded text-sm text-white bg-slate-900 hover:bg-slate-700 transition">
                                Quick View
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @endif
        @else
            <!-- No Products Found -->
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-500 mb-6">There are no products in this subcategory yet.</p>
                <a href="{{ route('categories.show', $category->slug) }}" class="bg-amber-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-amber-700 transition">
                    Browse {{ $category->name }}
                </a>
            </div>
        @endif
    </div>
</x-app-layout>

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
