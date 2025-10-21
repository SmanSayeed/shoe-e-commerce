<!-- Hero Slider -->
<section class="relative overflow-hidden h-96">
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
  <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
    <button class="w-3 h-3 bg-white rounded-full opacity-100 transition-opacity duration-300" onclick="goToSlide(0)"></button>
    <button class="w-2 h-2 bg-gray-600 rounded-full opacity-60 transition-opacity duration-300" onclick="goToSlide(1)"></button>
    <button class="w-2 h-2 bg-gray-600 rounded-full opacity-60 transition-opacity duration-300" onclick="goToSlide(2)"></button>
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