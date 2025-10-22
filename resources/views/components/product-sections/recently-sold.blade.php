  <!-- Recently Sold -->
<section id="recent" class="bg-gray-100 py-8" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,0.1) 20px, rgba(255,255,255,0.1) 40px);">
  <div class="max-w-7xl mx-auto px-4">
    <!-- Section Header -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
      <!-- Title -->
      <h2 class="text-2xl font-bold text-blue-900">RECENTLY SOLD</h2>
      
      <!-- Countdown Timer -->
      <div class="flex items-center gap-4 flex-wrap">
        <div class="text-center">
          <div class="text-2xl font-bold text-gray-800">02</div>
          <div class="text-xs text-gray-600">Days</div>
        </div>
        <div class="text-center">
          <div class="text-2xl font-bold text-gray-800">18</div>
          <div class="text-xs text-gray-600">Hours</div>
        </div>
        <div class="text-center">
          <div class="text-2xl font-bold text-gray-800">53</div>
          <div class="text-xs text-gray-600">Mins</div>
        </div>
        <div class="text-center">
          <div class="text-2xl font-bold text-gray-800">14</div>
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
        <button class="bg-red-600 text-white px-4 py-2 rounded font-semibold hover:bg-red-700">View All</button>
        <button class="w-8 h-8 bg-gray-300 hover:bg-gray-400 rounded flex items-center justify-center" onclick="rsNext()">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Product Carousel -->
    <div class="relative overflow-hidden" id="recently-sold-viewport">
      <div class="flex space-x-4 transition-transform duration-300" id="product-carousel">
        <!-- Product Card 1: Soft Imported Shoe Insole -->
        <div class="bg-white rounded-lg shadow-lg w-64 flex-shrink-0 relative">
          <!-- Discount Badge -->
          <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 text-xs font-bold rounded">-14%</div>
          <!-- Product Image -->
          <div class="h-48 bg-gray-100 flex items-center justify-center">
            <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop" 
                 alt="Shoe Insole" class="h-32 w-32 object-cover rounded">
          </div>
          
          <!-- Product Code -->
          <div class="absolute top-2 right-2 text-xs text-gray-600">CODE-SB-IN02</div>
          
          <!-- Product Details -->
          <div class="p-4">
            <h3 class="font-semibold text-sm mb-2">SOFT IMPORTED SHOE INSOLE SB-IN02</h3>
            
            <!-- Star Rating -->
            <div class="flex items-center mb-2">
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-gray-300">★</span>
              <span class="text-xs text-gray-500 ml-1">3.5</span>
            </div>
            
            <!-- Price -->
            <div class="flex items-center space-x-2 mb-3">
              <span class="text-red-600 font-bold">৳299</span>
              <span class="text-gray-400 line-through text-sm">৳349</span>
            </div>
            
            <!-- Action Button -->
            <button class="w-full bg-gray-800 text-white py-2 rounded text-sm font-semibold hover:bg-gray-700">
              Select options
            </button>
          </div>
        </div>

        <!-- Product Card 2: Leather Small Card Wallet -->
        <div class="bg-white rounded-lg shadow-lg w-64 flex-shrink-0 relative">
          <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 text-xs font-bold rounded">-24%</div>
          <div class="h-48 bg-gray-100 flex items-center justify-center">
            <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=400&auto=format&fit=crop" 
                 alt="Card Wallet" class="h-32 w-32 object-cover rounded">
          </div>
          
          <div class="absolute top-2 right-2 text-xs text-gray-600">CODE - W233</div>
          
          <div class="p-4">
            <h3 class="font-semibold text-sm mb-2">Leather Small Card Wallet SB-W233</h3>
            
            <div class="flex items-center mb-2">
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-gray-300">★</span>
              <span class="text-xs text-gray-500 ml-1">3.5</span>
            </div>
            
            <div class="flex items-center space-x-2 mb-3">
              <span class="text-red-600 font-bold">৳650</span>
              <span class="text-gray-400 line-through text-sm">৳850</span>
            </div>
            
            <button class="w-full bg-gray-800 text-white py-2 rounded text-sm font-semibold hover:bg-gray-700">
              Select options
            </button>
          </div>
        </div>

        <!-- Product Card 3: Classic Dark Maroon Leather Belt -->
        <div class="bg-white rounded-lg shadow-lg w-64 flex-shrink-0 relative">
          <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 text-xs font-bold rounded">-11%</div>
          <div class="h-48 bg-gray-100 flex items-center justify-center">
            <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=400&auto=format&fit=crop" 
                 alt="Leather Belt" class="h-32 w-32 object-cover rounded">
          </div>
          
          <div class="absolute top-2 right-2 text-xs text-gray-600">PRODUCT CODE- SB-I8113</div>
          
          <div class="p-4">
            <h3 class="font-semibold text-sm mb-2">Classic Dark Maroon One Part Leather Belt For Men-IB113</h3>
            
            <div class="flex items-center mb-2">
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-gray-300">★</span>
              <span class="text-xs text-gray-500 ml-1">3.5</span>
            </div>
            
            <div class="flex items-center space-x-2 mb-3">
              <span class="text-red-600 font-bold">৳1,699</span>
              <span class="text-gray-400 line-through text-sm">৳1,899</span>
            </div>
            
            <button class="w-full bg-gray-800 text-white py-2 rounded text-sm font-semibold hover:bg-gray-700">
              Select options
            </button>
          </div>
        </div>

        <!-- Product Card 4: Stylish Buckle Leather Gear Belt -->
        <div class="bg-white rounded-lg shadow-lg w-64 flex-shrink-0 relative">
          <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 text-xs font-bold rounded">-8%</div>
          <div class="h-48 bg-gray-100 flex items-center justify-center">
            <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=400&auto=format&fit=crop" 
                 alt="Gear Belt" class="h-32 w-32 object-cover rounded">
          </div>
          
          <div class="absolute top-2 right-2 text-xs text-gray-600">PRODUCT CODE- SB-I8066</div>
          
          <div class="p-4">
            <h3 class="font-semibold text-sm mb-2">Stylish Buckle Leather Gear Belt For Men SB-IB066</h3>
            
            <div class="flex items-center mb-2">
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-gray-300">★</span>
              <span class="text-xs text-gray-500 ml-1">3.5</span>
            </div>
            
            <div class="flex items-center space-x-2 mb-3">
              <span class="text-red-600 font-bold">৳1,750</span>
              <span class="text-gray-400 line-through text-sm">৳1,900</span>
              </div>
            
            <button class="w-full bg-gray-800 text-white py-2 rounded text-sm font-semibold hover:bg-gray-700">
              Select options
            </button>
                </div>
              </div>

        <!-- Product Card 5: Classic Black Derby Formal Shoes -->
        <div class="bg-white rounded-lg shadow-lg w-64 flex-shrink-0 relative">
          <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 text-xs font-bold rounded">-25%</div>
          <div class="h-48 bg-gray-100 flex items-center justify-center">
            <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop" 
                 alt="Derby Shoes" class="h-32 w-32 object-cover rounded">
          </div>
          
          <div class="absolute top-2 right-2 text-xs text-gray-600">Product Code -S933</div>
          
          <div class="p-4">
            <h3 class="font-semibold text-sm mb-2">Classic Black Derby Formal Shoes For Men SB-S933</h3>
            
            <div class="flex items-center mb-2">
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-yellow-400">★</span>
              <span class="text-gray-300">★</span>
              <span class="text-xs text-gray-500 ml-1">3.5</span>
            </div>
            
            <div class="flex items-center space-x-2 mb-3">
              <span class="text-red-600 font-bold">৳2,250</span>
              <span class="text-gray-400 line-through text-sm">৳2,999</span>
            </div>
            
            <button class="w-full bg-gray-800 text-white py-2 rounded text-sm font-semibold hover:bg-gray-700">
              Select options
            </button>
          </div>
        </div>
        </div>
      </div>
    </div>
</section>

<script>
// Recently Sold carousel: responsive 1/2/4 cards on mobile/tablet/desktop
const rsViewport = document.getElementById('recently-sold-viewport');
const rsTrack = document.getElementById('product-carousel');
const rsGap = 16; // space-x-4
let rsCardWidth = 0;
let rsIndex = 0;
let rsTimer;

function rsVisibleCount() {
  const w = rsViewport ? rsViewport.clientWidth : 0;
  if (w < 640) return 1;      // < sm
  if (w < 1024) return 2;     // < lg
  return 4;                   // desktop
}

function rsSetCardWidths() {
  const cards = Array.from(rsTrack.querySelectorAll('[data-rs-card]'));
  const visible = rsVisibleCount();
  const width = Math.max(0, (rsViewport.clientWidth - rsGap * (visible - 1)) / visible);
  rsCardWidth = width;
  cards.forEach(c => c.style.width = width + 'px');
}

function rsBuildClones() {
  // If already cloned, skip
  if (rsTrack.querySelector('[data-rs-clone]')) return;
  const cards = Array.from(rsTrack.children);
  // mark originals
  cards.forEach(c => c.setAttribute('data-rs-card',''));
  const first = cards.slice(0, 4).map(n => n.cloneNode(true));
  const last = cards.slice(-4).map(n => n.cloneNode(true));
  first.forEach(n => { n.setAttribute('data-rs-clone',''); rsTrack.appendChild(n); });
  last.forEach(n => { n.setAttribute('data-rs-clone',''); rsTrack.insertBefore(n, rsTrack.firstChild); });
  rsIndex = 4; // start at first real card
}

function rsUpdateTransform(animate = true) {
  rsTrack.style.transitionDuration = animate ? '300ms' : '0ms';
  const offset = -(rsCardWidth + rsGap) * rsIndex;
  rsTrack.style.transform = `translateX(${offset}px)`;
}

function rsNext() {
  rsIndex += 1;
  rsUpdateTransform(true);
}
function rsPrev() {
  rsIndex -= 1;
  rsUpdateTransform(true);
}

rsTrack.addEventListener('transitionend', () => {
  const total = rsTrack.querySelectorAll('[data-rs-card]').length; // originals count
  if (rsIndex >= total + 4) { // passed last clone zone
    rsIndex = 4;
    rsUpdateTransform(false);
  }
  if (rsIndex < 4) { // passed first clone zone
    rsIndex = total + 3;
    rsUpdateTransform(false);
  }
});

function rsStart() {
  clearInterval(rsTimer);
  rsTimer = setInterval(() => rsNext(), 3000);
}

function rsInit() {
  if (!rsViewport || !rsTrack) return;
  rsBuildClones();
  rsSetCardWidths();
  rsUpdateTransform(false);
  rsStart();
}

window.addEventListener('resize', () => { rsSetCardWidths(); rsUpdateTransform(false); });
document.addEventListener('visibilitychange', () => { if (document.hidden) clearInterval(rsTimer); else rsStart(); });

// Mark existing cards so sizing works before cloning on first init call
Array.from(rsTrack.children).forEach(c => c.setAttribute('data-rs-card',''));
// Initialize after layout
setTimeout(rsInit, 0);
</script>