<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Category header and pill label -->
        <div class="flex flex-col sm:flex-row items-center justify-between text-center sm:text-left gap-4 mb-10">
            <div class="w-full">
                <span class="inline-flex items-center bg-black text-white font-semibold px-3 py-2 rounded-md uppercase tracking-wide text-xs">Categories</span>
                <h1 class="mt-4 text-3xl font-bold text-slate-900">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="mt-2 text-slate-600">{{ $category->description }}</p>
                @endif
                <p class="mt-4 text-sm text-slate-500">{{ $products->total() }} products found in this category</p>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-[280px_1fr]">
            <aside class="lg:sticky lg:top-24 self-start">
                <x-sidebar-filteration
                    :action="route('categories.show', $category->slug)"
                    :colors="$colors ?? collect()"
                    :sizes="$sizes ?? collect()"
                    :price-range="$priceRange ?? []"
                    :applied="$appliedFilters ?? []"
                />
            </aside>

            <div>
                @if($products->count() > 0)
                    <!-- Product cards grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            @php
                                $image = $product->main_image
                                    ?? optional($product->images->sortBy('sort_order')->first())->image_path
                                    ?? 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop';
                                $imageUrl = \Illuminate\Support\Str::startsWith($image, ['http://', 'https://', '//'])
                                    ? $image
                                    : asset($image);
                                $hasSale = $product->isOnSale();
                                $discountPercentage = $hasSale && $product->price > 0
                                    ? max(0, (int) round((($product->price - $product->current_price) / $product->price) * 100))
                                    : null;
                                $ratingValue = $product->rating ? number_format($product->rating, 1) : null;
                            @endphp

                            <!-- Single product card -->
                            <a href="{{ route('products.show', $product->slug) }}" class="card group rounded-2xl bg-white overflow-hidden shadow-sm">
                                <!-- Product preview image & badges -->
                                <div class="relative aspect-[4/3] bg-slate-100">
                                    <img
                                        src="{{ $imageUrl }}"
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                                        loading="lazy"
                                    >
                                    @if($discountPercentage)
                                        <span class="absolute left-3 top-3 text-[10px] font-bold uppercase tracking-wide bg-rose-600 text-white px-2 py-0.5 rounded">
                                            -{{ $discountPercentage }}%
                                        </span>
                                    @endif
                                    <span class="absolute right-3 top-3 text-[10px] font-semibold bg-white/80 text-slate-500 px-2 py-1 rounded-full capitalize shadow-sm">
                                        {{ $product->slug }}
                                    </span>
                                </div>

                                <!-- Product meta: category label, name, rating, price, actions -->
                                <div class="p-5">
                                    <p class="text-xs text-slate-500">{{ $product->category->name ?? 'Product' }}</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900 line-clamp-2">{{ $product->name }}</p>

                                    @if($ratingValue)
                                        <!-- Rating stars & score -->
                                        <div class="mt-3 flex items-center gap-2">
                                            <div class="flex items-center gap-0.5 text-amber-500">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-solid fa-star text-xs {{ $i <= round($ratingValue) ? '' : 'opacity-30' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-slate-600">{{ $ratingValue }}</span>
                                        </div>
                                    @endif

                                    <!-- Pricing with optional compare-at value -->
                                    <div class="mt-3 flex items-center gap-2">
                                        <span class="text-red-600 font-bold">৳{{ number_format($product->current_price) }}</span>
                                        @if($hasSale)
                                            <span class="text-slate-400 line-through">৳{{ number_format($product->price) }}</span>
                                        @endif
                                    </div>

                                    <!-- Primary CTA buttons -->
                                    <div class="mt-4 flex flex-col gap-2">
                                        <button class="w-full inline-flex items-center justify-center rounded-md bg-black text-white py-2 text-sm font-semibold tracking-wide hover:bg-slate-800">
                                            Select options
                                        </button>
                                        <button class="w-full inline-flex items-center justify-center rounded-md border border-black text-black py-2 text-sm font-semibold tracking-wide hover:bg-black hover:text-white">
                                            Quick View
                                        </button>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @else
                    <!-- Empty state when no products exist -->
                    <div class="bg-white border border-slate-100 rounded-xl p-10 text-center">
                        <h2 class="text-xl font-semibold text-slate-900 mb-2">No products found</h2>
                        <p class="text-slate-500 mb-5">We could not find any products under this category yet.</p>
                        <a
                            href="{{ route('home') }}"
                            class="inline-block bg-amber-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-amber-700 transition"
                        >
                            Back to Home
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
