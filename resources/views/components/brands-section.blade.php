@php
    $brandsList = collect($brands ?? [])->take(4);
@endphp

@if($brandsList->count() > 0)
<!-- Our Brands Section - Matching attached image design -->
<section class="w-full bg-white border-b-2 border-red-600 py-8 md:py-12 lg:py-16">
    <div class="container mx-auto px-4">
        <!-- Section Heading -->
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 tracking-wider uppercase mb-4">
                Our Brands
            </h2>
        </div>

        <!-- Brands Grid - Responsive: 1 col mobile, 2 col tablet, 4 col desktop -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12 max-w-7xl mx-auto">
            @foreach($brandsList as $brand)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 h-32 md:h-40 overflow-hidden hover:scale-105 relative">
                    @if(!empty($brand['logo_url']))
                        <img 
                            src="{{ $brand['logo_url'] }}" 
                            alt="{{ $brand['name'] }} logo" 
                            class="w-full h-full object-cover"
                            loading="{{ $loop->index < 2 ? 'eager' : 'lazy' }}"
                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        />
                        <!-- Fallback SVG (hidden by default) -->
                        <div class="hidden items-center justify-center w-full h-full absolute inset-0">
                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.72-2.81 0-1.79-1.49-2.69-3.66-3.21z"/>
                            </svg>
                        </div>
                    @else
                        <!-- Fallback SVG when no logo -->
                        <div class="flex items-center justify-center w-full h-full absolute inset-0">
                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.72-2.81 0-1.79-1.49-2.69-3.66-3.21z"/>
                            </svg>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@else
<!-- Empty state fallback -->
<section class="w-full bg-white border-b-2 border-red-600 py-8 md:py-12 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <p class="text-gray-500 text-sm md:text-base">No brands to display</p>
        </div>
    </div>
</section>
@endif
