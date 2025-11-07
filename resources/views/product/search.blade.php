<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Search results</p>
                <h1 class="text-3xl font-bold text-slate-900">“{{ $term }}”</h1>
                <p class="mt-2 text-sm text-slate-600">{{ $products->total() }} product{{ $products->total() === 1 ? '' : 's' }} found</p>
            </div>

            <form action="{{ route('products.search') }}" method="GET" class="w-full md:w-80">
                <div class="relative">
                    <input
                        type="search"
                        name="q"
                        value="{{ $term }}"
                        placeholder="Search again..."
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200"
                        required
                    >
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md bg-slate-900 px-3 py-1.5 text-sm font-semibold text-white hover:bg-slate-700">
                        Search
                    </button>
                </div>
            </form>
        </div>

        @if($products->count() > 0)
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
                    <a href="{{ route('products.show', $product->slug) }}" class="group rounded-2xl bg-white overflow-hidden border border-slate-100 shadow-sm">
                        <div class="relative aspect-[4/3] bg-slate-100">
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                            >
                            @if($discountPercentage)
                                <span class="absolute left-3 top-3 text-[10px] font-bold uppercase tracking-wide bg-rose-600 text-white px-2 py-0.5 rounded">
                                    -{{ $discountPercentage }}%
                                </span>
                            @endif
                            <span class="absolute right-3 top-3 text-[10px] font-semibold bg-white/80 text-slate-500 px-2 py-1 rounded-full capitalize shadow-sm">
                                {{ $product->sku }}
                            </span>
                        </div>
                        <div class="p-5">
                            <p class="text-xs text-slate-500">{{ $product->category->name ?? 'Product' }}</p>
                            <p class="mt-2 text-base font-semibold text-slate-900 line-clamp-2">{{ $product->name }}</p>
                            @if($ratingValue)
                                <div class="mt-3 flex items-center gap-2">
                                    <div class="flex items-center gap-0.5 text-amber-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star text-xs {{ $i <= round($ratingValue) ? '' : 'opacity-30' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-slate-600">{{ $ratingValue }}</span>
                                </div>
                            @endif
                            <div class="mt-3 flex items-center gap-2">
                                <span class="text-red-600 font-bold">৳{{ number_format($product->current_price) }}</span>
                                @if($hasSale)
                                    <span class="text-slate-400 line-through">৳{{ number_format($product->price) }}</span>
                                @endif
                            </div>
                            <div class="mt-4 flex flex-col gap-2">
                                <span class="inline-flex items-center gap-1 text-xs text-slate-500">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" /></svg>
                                    {{ $product->brand->name ?? 'Unbranded' }}
                                </span>
                                <span class="inline-flex items-center gap-1 text-xs text-slate-500">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 9h18M9 21h6" /></svg>
                                    SKU: {{ $product->sku }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @else
            <div class="bg-white border border-slate-100 rounded-xl p-10 text-center">
                <h2 class="text-xl font-semibold text-slate-900 mb-2">No products found</h2>
                <p class="text-slate-500 mb-6">We couldn’t find any items matching “{{ $term }}”. Try a different keyword or check your spelling.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-lg bg-amber-600 px-5 py-2 text-sm font-semibold text-white hover:bg-amber-700">
                    Back to Home
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
