@php
    // Filter brands that have names
    $brandsList = collect($brands ?? [])->filter(function($brand) {
        return !empty($brand['name']);
    });
@endphp

@if($brandsList->count() > 0)
<!-- Brands Section - Positioned before footer -->
<section class="w-full py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Heading -->
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl font-light text-slate-800 dark:text-slate-200 mb-2 tracking-wide">
                Trusted By Leading Brands
            </h2>
            <div class="w-16 h-px bg-slate-300 dark:bg-slate-600 mx-auto mt-4"></div>
        </div>

        <!-- Brands Grid - Rectangular cards with 2px grey border -->
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 gap-4 sm:gap-6 md:gap-8 items-center justify-items-center">
            @foreach($brandsList as $brand)
                <div class="flex items-center justify-center w-full aspect-square group">
                    @if(!empty($brand['logo_url']))
                        <!-- Admin uploaded logo in rectangular card -->
                        <div class="w-full h-24 sm:h-28 md:h-32 rounded-lg bg-white dark:bg-slate-800 border-2 border-slate-300 dark:border-slate-600 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center p-4 group-hover:scale-105">
                            <img 
                                src="{{ $brand['logo_url'] }}" 
                                alt="{{ $brand['name'] }}" 
                                class="w-full h-full object-contain"
                                loading="lazy"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<svg class=\'w-12 h-12 text-slate-400\' fill=\'currentColor\' viewBox=\'0 0 24 24\'><path d=\'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.72-2.81 0-1.79-1.49-2.69-3.66-3.21z\'/></svg>';"
                            />
                        </div>
                    @else
                        <!-- Fallback SVG logo in rectangular card -->
                        <div class="w-full h-24 sm:h-28 md:h-32 rounded-lg bg-white dark:bg-slate-800 border-2 border-slate-300 dark:border-slate-600 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center group-hover:scale-105">
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.72-2.81 0-1.79-1.49-2.69-3.66-3.21z"/>
                            </svg>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
