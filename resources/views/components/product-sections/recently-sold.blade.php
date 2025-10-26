    <!-- Recently Sold -->
<section id="recent" class="bg-gray-100 py-8" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,0.1) 20px, rgba(255,255,255,0.1) 40px);">
  <div class="max-w-7xl mx-auto px-4">
    <!-- Section Header -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6 text-center sm:text-left sm:justify-between flex-col sm:flex-row">
      <!-- Title -->
      <h2 class="text-2xl font-bold text-blue-900">RECENTLY SOLD</h2>
      
      <!-- Countdown Timer -->
      <div class="flex items-center gap-4 flex-wrap" id="countdown-timer">
        <div class="text-center">
          <div class="text-2xl font-bold text-gray-800" id="countdown-days">02</div>
          <div class="text-xs text-gray-600">Days</div>
        </div>
        <div class="text-center">
          <div class="text-2xl font-bold text-gray-800" id="countdown-hours">18</div>
          <div class="text-xs text-gray-600">Hours</div>
        </div>
        <div class="text-center">
          <div class="text-2xl font-bold text-gray-800" id="countdown-minutes">53</div>
          <div class="text-xs text-gray-600">Mins</div>
        </div>
        <div class="text-center">
          <div class="text-2xl font-bold text-gray-800" id="countdown-seconds">14</div>
          <div class="text-xs text-gray-600">Secs</div>
        </div>
      </div>
      
      <!-- Navigation Controls -->
      <div class="flex items-center gap-2">
        <button class="w-8 h-8 bg-gray-300 hover:bg-gray-400 rounded flex items-center justify-center" onclick="rsPrev()">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
          </svg>
        </button>
        <a href="{{ route('home') }}#recent" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
        <button class="w-8 h-8 bg-gray-300 hover:bg-gray-400 rounded flex items-center justify-center" onclick="rsNext()">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Product Carousel -->
    <div class="relative overflow-hidden" id="recently-sold-viewport">
      <div class="flex gap-4 transition-transform duration-300" id="product-carousel">
        @forelse($processedProducts as $productData)
          @php
            $product = $productData['product'];
            $discountPercentage = $productData['discountPercentage'];
            $rating = $productData['rating'];
            $productImage = $productData['productImage'];
          @endphp
          
          <div class="bg-white rounded-lg shadow-lg flex-shrink-0 relative">
            @if($discountPercentage > 0)
              <!-- Discount Badge -->
              <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 text-xs font-bold rounded">-{{ $discountPercentage }}%</div>
            @endif
            
            <!-- Product Image -->
            <div class="h-48 bg-gray-100 flex items-center justify-center">
              <img src="{{ $productImage }}" 
                   alt="{{ $product->name }}" 
                   class="h-32 w-32 object-cover rounded"
                   loading="lazy">
            </div>
            
            <!-- Product Code -->
            <div class="absolute top-2 right-2 text-xs text-gray-600">{{ $product->slug }}</div>
            
            <!-- Product Details -->
            <div class="p-4">
              <h3 class="font-semibold text-sm mb-2">{{ strtoupper($product->name) }}</h3>
              
              <!-- Star Rating -->
              <div class="flex items-center mb-2">
                @for($i = 1; $i <= 5; $i++)
                  @if($i <= floor($rating))
                    <span class="text-yellow-400">★</span>
                  @else
                    <span class="text-gray-300">★</span>
                  @endif
                @endfor
                <span class="text-xs text-gray-500 ml-1">{{ $rating }}</span>
              </div>
              
              <!-- Price -->
              <div class="flex items-center space-x-2 mb-3">
                @if($product->sale_price && $product->sale_price < $product->price)
                  <span class="text-red-600 font-bold">৳{{ number_format($product->sale_price) }}</span>
                  <span class="text-gray-400 line-through text-sm">৳{{ number_format($product->price) }}</span>
                @else
                  <span class="text-red-600 font-bold">৳{{ number_format($product->price) }}</span>
                @endif
              </div>
              
              <!-- Action Button -->
              <a href="{{ route('products.show', $product->slug) }}" 
                 class="w-full bg-gray-800 text-white py-2 rounded text-sm font-semibold hover:bg-gray-700 block text-center">
                Select options
              </a>
            </div>
          </div>
        @empty
          <!-- Fallback content when no products are available -->
          <div class="bg-white rounded-lg shadow-lg flex-shrink-0 relative w-full">
            <div class="p-8 text-center">
              <h3 class="text-lg font-semibold text-gray-600 mb-2">No Recently Sold Products</h3>
              <p class="text-gray-500">Check back later for our latest sales!</p>
            </div>
          </div>
        @endforelse
      </div>
    </div>
</section>

<script>
// Countdown Timer
const countdownEndTime = new Date('{{ $countdownEndTime->format('Y-m-d H:i:s') }}').getTime();

function updateCountdown() {
  const now = new Date().getTime();
  const distance = countdownEndTime - now;

  if (distance < 0) {
    // Countdown finished
    document.getElementById('countdown-days').textContent = '00';
    document.getElementById('countdown-hours').textContent = '00';
    document.getElementById('countdown-minutes').textContent = '00';
    document.getElementById('countdown-seconds').textContent = '00';
    return;
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  document.getElementById('countdown-days').textContent = days.toString().padStart(2, '0');
  document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
  document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
  document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
}

// Update countdown every second
setInterval(updateCountdown, 1000);
updateCountdown(); // Initial call

// Recently Sold carousel: responsive (1/2/4) cyclic slider — no clones
const rsViewport = document.getElementById('recently-sold-viewport');
const rsTrack = document.getElementById('product-carousel');
const rsGap = 16; // Tailwind gap-4
let rsCardWidth = 0;
let rsTimer;
let rsAnimating = false;

function rsVisibleCount() {
  const w = rsViewport ? rsViewport.clientWidth : 0;
  if (w < 640) return 1;      // mobile: single card
  if (w < 1024) return 2;     // tablet: two cards
  return 4;                   // desktop: four cards
}

function rsSetCardWidths() {
  if (!rsViewport || !rsTrack) return;
  const cards = Array.from(rsTrack.children);
  // mark as cards for sizing (kept for compatibility with older code references)
  // cards.forEach(c => c.setAttribute('data-rs-card',''));
  const visible = rsVisibleCount();
  const viewportWidth = rsViewport.clientWidth;
  const width = visible === 1
    ? viewportWidth - 32 // Full width - horizontal padding on mobile
    : Math.max(0, (viewportWidth - rsGap * (visible - 1)) / visible);
  rsCardWidth = width;
  cards.forEach(c => c.style.width = width + 'px');
  // Adjust track padding for mobile
  rsTrack.style.paddingLeft = visible === 1 ? '16px' : '0px';
  rsTrack.style.paddingRight = visible === 1 ? '16px' : '0px';
  // Reset transform after resize to avoid misalignment
  rsTrack.style.transitionDuration = '0ms';
  rsTrack.style.transform = 'translateX(0px)';
}

function rsStepOffset() {
  return rsCardWidth + rsGap;
}

function rsNext() {
  if (rsAnimating) return;
  rsAnimating = true;
  const step = rsStepOffset();
  rsTrack.style.transitionDuration = '300ms';
  rsTrack.style.transform = `translateX(${-step}px)`;

  const onEnd = () => {
    rsTrack.removeEventListener('transitionend', onEnd);
    // Move first card to the end; no clones used
    const first = rsTrack.firstElementChild;
    if (first) rsTrack.appendChild(first);
    // Reset transform without animation
    rsTrack.style.transitionDuration = '0ms';
    rsTrack.style.transform = 'translateX(0px)';
    // Force reflow to apply the non-animated state before allowing next animation
    void rsTrack.offsetWidth; // reflow
    rsAnimating = false;
  };
  rsTrack.addEventListener('transitionend', onEnd);
}

function rsPrev() {
  if (rsAnimating) return;
  rsAnimating = true;
  const step = rsStepOffset();
  // Prepend last card and set starting offset without animation
  const last = rsTrack.lastElementChild;
  if (last) rsTrack.insertBefore(last, rsTrack.firstElementChild);
  rsTrack.style.transitionDuration = '0ms';
  rsTrack.style.transform = `translateX(${-step}px)`;
  // Force reflow, then animate back to 0
  void rsTrack.offsetWidth; // reflow
  rsTrack.style.transitionDuration = '300ms';
  rsTrack.style.transform = 'translateX(0px)';

  const onEnd = () => {
    rsTrack.removeEventListener('transitionend', onEnd);
    rsAnimating = false;
  };
  rsTrack.addEventListener('transitionend', onEnd);
}

function rsStart() {
  clearInterval(rsTimer);
  rsTimer = setInterval(() => rsNext(), 3000);
}

function rsInit() {
  if (!rsViewport || !rsTrack) return;
  rsSetCardWidths();
  rsStart();
}

window.addEventListener('resize', () => { rsSetCardWidths(); });
document.addEventListener('visibilitychange', () => { if (document.hidden) clearInterval(rsTimer); else rsStart(); });

// Initialize after layout
setTimeout(rsInit, 0);
</script>