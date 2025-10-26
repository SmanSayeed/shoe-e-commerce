<!-- Hero area with desktop category sidebar -->
<section class="max-w-7xl mx-auto px-4 mt-3">
  <div class="grid lg:grid-cols-12 gap-4">
    <!-- Left: Category Sidebar (desktop only) -->
    <aside class="hidden lg:block lg:col-span-3">
      <div class="bg-white rounded-md border border-emerald-200 overflow-hidden">
        <!-- Sidebar Header -->
        <div class="bg-black text-white font-semibold px-3 py-2">
          Categories
        </div>
        <!-- Category List -->
        <nav class="max-h-[380px] overflow-auto p-2">
          <ul class="space-y-1 text-sm">
            <li>
              <a href="#" class="flex items-center justify-between px-2 py-2 rounded hover:bg-emerald-50">
                <span>Shoes</span>
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </a>
            </li>

            <!-- Add more as needed -->
          </ul>
        </nav>
      </div>
    </aside>

    <!-- Right: Hero Slider -->
    <div class="lg:col-span-9">
      <!-- Hero Slider -->
      <section class="relative overflow-hidden h-64 sm:h-80 lg:h-96 rounded-md">
        <!-- Slider Container -->
        <div class="relative h-full w-full">
          <!-- Image Slides Container -->
          <div class="flex h-full transition-transform duration-1000 ease-in-out" id="slider-container">
            @forelse($products as $product)

              <div class="w-full h-full flex-shrink-0 relative group">
                @php
                  $primary = $product->primaryImage();
                  $src = $primary
                    ? (filter_var($primary, FILTER_VALIDATE_URL) ? $primary : asset('storage/' . $primary))
                    : asset('images/swiper-slide-1.jpg');
                @endphp
                <img src="{{ $src }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-75"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform transition-transform duration-300 translate-y-2 group-hover:translate-y-0">
                  <div class="space-y-2">
                    @if($product->sale_price)
                      <div class="inline-block px-3 py-1 bg-red-600 text-white text-sm font-medium rounded-full">
                        Save {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                      </div>
                    @endif
                    <h3 class="text-2xl font-bold leading-tight">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-200 line-clamp-2">{{ $product->short_description }}</p>
                    <div class="flex items-center gap-3 mt-3">
                      @if($product->sale_price)
                        <span class="text-2xl font-bold">৳{{ number_format($product->sale_price) }}</span>
                        <span class="text-lg text-gray-400 line-through">৳{{ number_format($product->price) }}</span>
                      @else
                        <span class="text-2xl font-bold">৳{{ number_format($product->price) }}</span>
                      @endif
                    </div>
                    <a href="{{ route('products.show', $product->slug) }}"
                       class="inline-flex items-center px-6 py-2 mt-4 bg-white text-black rounded-full hover:bg-emerald-500 hover:text-white transition-colors duration-300">
                      Shop Now
                      <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            @empty
              <div class="w-full h-full flex-shrink-0 bg-gray-100 flex items-center justify-center">
                <p class="text-gray-500">No featured products available</p>
              </div>
            @endforelse
          </div>
        </div>

        <!-- Slider Indicators -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
          @foreach($products as $index => $product)
            <button
              class="w-2 h-2 rounded-full transition-all duration-300 {{ $loop->first ? 'w-3 h-3 bg-white opacity-100' : 'bg-gray-600 opacity-60' }}"
              onclick="goToSlide({{ $index }})"
              aria-label="Go to slide {{ $index + 1 }}">
            </button>
          @endforeach
        </div>

        <!-- Navigation Arrows -->
        <button class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/30 text-white flex items-center justify-center hover:bg-black/50 transition-colors duration-300" onclick="prevSlide()" aria-label="Previous slide">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
        </button>
        <button class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/30 text-white flex items-center justify-center hover:bg-black/50 transition-colors duration-300" onclick="nextSlide()" aria-label="Next slide">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </section>
    </div>
  </div>
</section>

<script>
let currentSlide = 0;
const totalSlides = {{ $products->count() }};
const sliderContainer = document.getElementById('slider-container');
let autoSlideInterval;

function goToSlide(slideIndex) {
  currentSlide = slideIndex;
  const translateX = -slideIndex * 100;
  sliderContainer.style.transform = `translateX(${translateX}%)`;

  // Update indicators
  const indicators = document.querySelectorAll('[onclick^="goToSlide"]');
  indicators.forEach((indicator, index) => {
    if (index === slideIndex) {
      indicator.className = 'w-3 h-3 bg-white rounded-full opacity-100 transition-opacity duration-300';
    } else {
      indicator.className = 'w-2 h-2 bg-gray-600 rounded-full opacity-60 transition-opacity duration-300';
    }
  });

  // Reset auto-slide timer
  resetAutoSlide();
}

function prevSlide() {
  currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
  goToSlide(currentSlide);
}

function nextSlide() {
  currentSlide = (currentSlide + 1) % totalSlides;
  goToSlide(currentSlide);
}

function resetAutoSlide() {
  clearInterval(autoSlideInterval);
  if (totalSlides > 1) {
    autoSlideInterval = setInterval(nextSlide, 5000);
  }
}

// Initialize auto-slide
resetAutoSlide();
</script>
