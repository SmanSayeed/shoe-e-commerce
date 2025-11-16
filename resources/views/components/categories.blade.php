<!-- Categories -->
<section id="categories" class="max-w-7xl mx-auto px-4 py-12">
    <!-- Category Display Toggle (Optional - can be controlled via props or config) -->
    @php
        $displayMode = $displayMode ?? 'grid'; // 'grid' or 'accordion'
    @endphp

    @if ($displayMode === 'accordion')
        <!-- Accordion Style Categories -->
        <div class="space-y-4">
            @forelse($processedCategories as $categoryData)
                @php
                    $category = $categoryData['category'];
                    $image = $categoryData['image'];
                    $subcategoryText = $categoryData['subcategoryText'];
                    $gradientClass = $categoryData['gradientClass'];
                @endphp

                <div class="accordion-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="accordion-header bg-gradient-to-r {{ $gradientClass }} p-4 cursor-pointer flex items-center justify-between"
                        onclick="toggleAccordion(this)">
                        <div class="flex items-center space-x-4">
                            <img class="w-16 h-16 object-cover rounded-lg" src="{{ $image }}"
                                alt="{{ $category->name }}" loading="lazy" />
                            <div>
                                <h3 class="font-bold text-lg text-white">{{ $category->name }}</h3>
                                <p class="text-sm text-white/80">{{ $subcategoryText }}</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-white transition-transform duration-200 accordion-chevron"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <div class="accordion-body hidden bg-gray-50 p-4">
                        @if ($category->subcategories->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($category->subcategories as $subcategory)
                                    <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
                                        <a href="{{ route('subcategories.show', [$category->slug, $subcategory->slug]) }}"
                                            class="block hover:text-blue-600 transition-colors">
                                            <h4 class="font-medium text-gray-800">{{ $subcategory->name }}</h4>
                                            <p class="text-sm text-gray-500">
                                                {{ $subcategory->childCategories->count() }} subcategories</p>
                                        </a>

                                        @if ($subcategory->childCategories->count() > 0)
                                            <div class="mt-2 space-y-1">
                                                @foreach ($subcategory->childCategories->take(3) as $childCategory)
                                                    <a href="{{ route('subcategories.show', [$category->slug, $subcategory->slug]) }}?child={{ $childCategory->slug }}"
                                                        class="block text-xs text-gray-600 hover:text-blue-500 ml-2">
                                                        • {{ $childCategory->name }}
                                                    </a>
                                                @endforeach
                                                @if ($subcategory->childCategories->count() > 3)
                                                    <a href="{{ route('subcategories.show', [$category->slug, $subcategory->slug]) }}"
                                                        class="block text-xs text-blue-500 hover:text-blue-700 ml-2">
                                                        +{{ $subcategory->childCategories->count() - 3 }} more...
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>No subcategories available for this category.</p>
                                <a href="{{ route('categories.show', $category->slug) }}"
                                    class="inline-block mt-2 text-blue-600 hover:text-blue-800">
                                    Browse products →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Fallback content when no categories are available -->
                <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No Categories Available</h3>
                    <p class="text-gray-500">Categories will appear here once they are added.</p>
                </div>
            @endforelse
        </div>

        <script>
            function toggleAccordion(header) {
                const body = header.nextElementSibling;
                const chevron = header.querySelector('.accordion-chevron');
                const isOpen = !body.classList.contains('hidden');

                // Close all other accordions
                document.querySelectorAll('.accordion-body').forEach(otherBody => {
                    if (otherBody !== body) {
                        otherBody.classList.add('hidden');
                        const otherChevron = otherBody.previousElementSibling.querySelector('.accordion-chevron');
                        if (otherChevron) {
                            otherChevron.style.transform = 'rotate(0deg)';
                        }
                    }
                });

                // Toggle current accordion
                if (isOpen) {
                    body.classList.add('hidden');
                    chevron.style.transform = 'rotate(0deg)';
                } else {
                    body.classList.remove('hidden');
                    chevron.style.transform = 'rotate(180deg)';
                }
            }
        </script>
    @else
        <!-- Grid Style Categories (Default) -->
        {{-- <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($processedCategories as $categoryData)
        @php
          $category = $categoryData['category'];
          $image = $categoryData['image'];
          $subcategoryText = $categoryData['subcategoryText'];
          $gradientClass = $categoryData['gradientClass'];
        @endphp

        <a class="card group rounded-xl overflow-hidden relative bg-gradient-to-br {{ $gradientClass }} p-6"
           href="{{ route('categories.show', $category->slug) }}">
          <h3 class="font-bold text-xl">{{ $category->name }}</h3>
          <p class="text-sm text-slate-600">{{ $subcategoryText }}</p>
          <img class="absolute bottom-0 right-2 w-28 opacity-90 group-hover:translate-y-1 transition"
               src="{{ $image }}"
               alt="{{ $category->name }}"
               loading="lazy" />
        </a>
      @empty
        <!-- Fallback content when no categories are available -->
        <div class="col-span-full">
          <div class="text-center py-12">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No Categories Available</h3>
            <p class="text-gray-500">Categories will appear here once they are added.</p>
          </div>
        </div>
      @endforelse
    </div> --}}
    @endif
</section>
