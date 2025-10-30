@props([
    'action',
    'colors' => collect(),
    'sizes' => collect(),
    'priceRange' => ['min' => null, 'max' => null],
    'applied' => [
        'price' => ['min' => null, 'max' => null],
        'colors' => [],
        'sizes' => [],
    ],
])

@php
    $appliedColorIds = collect($applied['colors'] ?? [])->filter()->map(fn ($id) => (int) $id);
    $appliedSizeIds = collect($applied['sizes'] ?? [])->filter()->map(fn ($id) => (int) $id);
    $activeColorCount = $appliedColorIds->count();
    $activeSizeCount = $appliedSizeIds->count();
    $hasPriceFilter = filled($applied['price']['min'] ?? null) || filled($applied['price']['max'] ?? null);
    $activeFilterTotal = $activeColorCount + $activeSizeCount + ($hasPriceFilter ? 1 : 0);
    $rangeMin = $priceRange['min'] ?? null;
    $rangeMax = $priceRange['max'] ?? null;
    $minPlaceholder = ! is_null($rangeMin) ? number_format((float) $rangeMin) : '0';
    $maxPlaceholder = ! is_null($rangeMax) ? number_format((float) $rangeMax) : '';
@endphp

<div class="bg-white border border-slate-100 rounded-2xl shadow-sm">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <div class="flex items-center gap-2">
            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
            <h2 class="text-base font-semibold text-slate-900">Filters</h2>
            @if($activeFilterTotal > 0)
                <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-700">{{ $activeFilterTotal }}</span>
            @endif
        </div>
        @if($activeFilterTotal > 0)
            <a href="{{ $action }}" class="text-xs font-medium text-slate-500 hover:text-slate-900">
                Clear all
            </a>
        @endif
    </div>

    <form id="category-filter-form" action="{{ $action }}" method="GET" class="px-5 py-4 space-y-6">
        @foreach(request()->except(['page', 'price_min', 'price_max', 'colors', 'sizes']) as $name => $value)
            @if(is_array($value))
                @foreach($value as $nestedValue)
                    <input type="hidden" name="{{ $name }}[]" value="{{ $nestedValue }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endif
        @endforeach

        <section class="space-y-3 border border-slate-100 rounded-xl p-4" data-filter-section>
            <button type="button" data-filter-section-toggle="price" class="flex w-full items-center justify-between text-left">
                <span class="text-sm font-semibold text-slate-900">Price Range</span>
                <svg class="h-4 w-4 text-slate-400 transition-transform" data-filter-chevron="price" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
            <div class="space-y-3" data-filter-section-content="price">
                <div class="grid grid-cols-2 gap-3">
                    <label class="text-xs text-slate-500 font-medium">
                        Min Price
                        <input type="number" name="price_min" inputmode="numeric" min="0" step="1" value="{{ $applied['price']['min'] ?? '' }}" placeholder="{{ $minPlaceholder }}" class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                    </label>
                    <label class="text-xs text-slate-500 font-medium">
                        Max Price
                        <input type="number" name="price_max" inputmode="numeric" min="0" step="1" value="{{ $applied['price']['max'] ?? '' }}" placeholder="{{ $maxPlaceholder }}" class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                    </label>
                </div>
            </div>
        </section>

        <section class="space-y-3 border border-slate-100 rounded-xl p-4" data-filter-section>
            <button type="button" data-filter-section-toggle="color" class="flex w-full items-center justify-between text-left">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-slate-900">Color</span>
                    @if($activeColorCount > 0)
                        <span class="inline-flex items-center rounded-full bg-slate-900/5 px-2 py-0.5 text-[10px] font-medium text-slate-700">{{ $activeColorCount }}</span>
                    @endif
                </div>
                <svg class="h-4 w-4 text-slate-400 transition-transform" data-filter-chevron="color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
            <div class="space-y-2 max-h-56 overflow-y-auto pr-1" data-filter-section-content="color">
                @forelse($colors as $color)
                    @php
                        $isChecked = $appliedColorIds->contains($color->id);
                        $swatch = $color->hex_code ?: $color->code;
                    @endphp
                    <label class="flex items-center gap-3 rounded-lg px-2 py-2 text-sm text-slate-600 hover:bg-slate-50">
                        <input type="checkbox" name="colors[]" value="{{ $color->id }}" @checked($isChecked) class="h-4 w-4 rounded border border-slate-300 text-amber-600 focus:ring-amber-200" />
                        <span class="h-5 w-5 rounded-full border border-slate-200" style="background-color: {{ $swatch }}"></span>
                        <span class="flex-1 text-slate-700">{{ $color->name }}</span>
                    </label>
                @empty
                    <p class="text-xs text-slate-400">No colors available for this category.</p>
                @endforelse
            </div>
        </section>

        <section class="space-y-3 border border-slate-100 rounded-xl p-4" data-filter-section>
            <button type="button" data-filter-section-toggle="size" class="flex w-full items-center justify-between text-left">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-slate-900">Product Size</span>
                    @if($activeSizeCount > 0)
                        <span class="inline-flex items-center rounded-full bg-slate-900/5 px-2 py-0.5 text-[10px] font-medium text-slate-700">{{ $activeSizeCount }}</span>
                    @endif
                </div>
                <svg class="h-4 w-4 text-slate-400 transition-transform" data-filter-chevron="size" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
            <div class="flex flex-wrap gap-2" data-filter-section-content="size">
                @forelse($sizes as $size)
                    @php
                        $isChecked = $appliedSizeIds->contains($size->id);
                    @endphp
                    <label class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 hover:border-slate-400">
                        <input type="checkbox" name="sizes[]" value="{{ $size->id }}" @checked($isChecked) class="h-4 w-4 rounded border border-slate-300 text-amber-600 focus:ring-amber-200" />
                        <span>{{ $size->name }}</span>
                    </label>
                @empty
                    <p class="w-full text-xs text-slate-400">No size information available.</p>
                @endforelse
            </div>
        </section>

        <div class="pt-2">
            <button type="submit" class="w-full rounded-lg bg-slate-900 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                Apply Filters
            </button>
        </div>
    </form>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('category-filter-form');
                const toggles = document.querySelectorAll('[data-filter-section-toggle]');

                toggles.forEach((button) => {
                    const sectionName = button.getAttribute('data-filter-section-toggle');
                    const content = document.querySelector('[data-filter-section-content="' + sectionName + '"]');
                    const chevron = document.querySelector('[data-filter-chevron="' + sectionName + '"]');

                    if (!content || !chevron) {
                        return;
                    }

                    button.addEventListener('click', () => {
                        content.classList.toggle('hidden');
                        chevron.classList.toggle('-rotate-180');
                    });
                });

                if (form) {
                    let debounceTimer;
                    form.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
                        checkbox.addEventListener('change', () => {
                            clearTimeout(debounceTimer);
                            debounceTimer = setTimeout(() => form.submit(), 250);
                        });
                    });
                }
            });
        </script>
    @endpush
@endonce
