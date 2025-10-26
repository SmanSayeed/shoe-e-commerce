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
            <!-- Slide 1 -->
            <div class="w-full h-full flex-shrink-0">
              <img src="https://images.unsplash.com/photo-1686320830934-83e20ef210d9??q=80&w=2070&auto=format&fit=crop"
                   alt="Leather Products Sale"
                   class="w-full h-full object-cover">
            </div>
            <!-- Slide 2 -->
            <div class="w-full h-full flex-shrink-0">
              <img src="https://images.unsplash.com/photo-1716513312004-9a7ebd4a7182?q=80&w=2070&auto=format&fit=crop"
                   alt="Shoe Collection"
                   class="w-full h-full object-cover">
            </div>
            <!-- Slide 3 -->
            <div class="w-full h-full flex-shrink-0">
              <img src="https://images.unsplash.com/photo-1692759873525-a1150bbe13af?q=80&w=2070&auto=format&fit=crop"
                   alt="Leather Accessories"
                   class="w-full h-full object-cover">
            </div>
          </div>
        </div>

        <!-- Slider Indicators -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
          <button class="w-3 h-3 bg-white rounded-full opacity-100 transition-opacity duration-300" onclick="goToSlide(0)"></button>
          <button class="w-2 h-2 bg-gray-600 rounded-full opacity-60 transition-opacity duration-300" onclick="goToSlide(1)"></button>
          <button class="w-2 h-2 bg-gray-600 rounded-full opacity-60 transition-opacity duration-300" onclick="goToSlide(2)"></button>
        </div>
      </section>
    </div>
  </div>
</section>

<script>
let currentSlide = 0;
const totalSlides = 3;
const sliderContainer = document.getElementById('slider-container');

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
}

function nextSlide() {
  currentSlide = (currentSlide + 1) % totalSlides;
  goToSlide(currentSlide);
}

// Auto-slide functionality
setInterval(nextSlide, 5000); // Change slide every 5 seconds
</script>
