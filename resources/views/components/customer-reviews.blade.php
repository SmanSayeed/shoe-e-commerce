<!-- Customer Reviews (Slider) -->
<section class="bg-slate-50 border-y border-slate-100">
  <div class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl font-bold">Customer Review</h2>
      <a class="text-sm text-amber-700 hover:underline" href="#">See More</a>
    </div>
    <div class="relative overflow-hidden" id="reviews-viewport">
      <div class="flex gap-6 transition-transform duration-500 ease-in-out" id="reviews-track">
        @forelse($processedReviews as $index => $reviewData)
          <div class="card rounded-xl bg-white p-6 w-80 flex-shrink-0">
            <div class="flex items-center gap-2 text-amber-500">
              @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($reviewData['rating']))
                  <i class="fa-solid fa-star text-sm"></i>
                @else
                  <i class="fa-regular fa-star text-sm"></i>
                @endif
              @endfor
              <span class="text-xs text-slate-600">{{ $reviewData['rating'] }}</span>
            </div>
            <p class="mt-3 text-sm text-slate-700">"{{ $reviewData['comment'] }}"</p>
            <p class="mt-4 text-xs text-slate-500">— {{ $reviewData['customerName'] }}</p>
          </div>
        @empty
          <!-- Fallback content when no reviews are available -->
          <div class="w-80 flex-shrink-0">
            <div class="card rounded-xl bg-white p-6 text-center">
              <p class="text-sm text-slate-700">No reviews available yet.</p>
            </div>
          </div>
        @endforelse
      </div>
      
      <!-- Dots -->
      @if($processedReviews->count() > 0)
        <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 flex gap-2">
          @for($i = 0; $i < $processedReviews->count(); $i++)
            <button class="w-2 h-2 rounded-full {{ $i === 0 ? 'bg-slate-800' : 'bg-slate-300' }}" data-review-dot="{{ $i }}"></button>
          @endfor
        </div>
      @endif
    </div>
  </div>
</section>

<script>
// Lightweight review slider showing 3 on desktop, 1 on mobile
(function(){
  const viewport = document.getElementById('reviews-viewport');
  const track = document.getElementById('reviews-track');
  if (!viewport || !track) return;
  const gap = 24; // gap-6 = 1.5rem = 24px
  let index = 0;
  let cardWidth = 0;
  let visible = 1;
  const dots = Array.from(viewport.querySelectorAll('[data-review-dot]'));

  function measure(){
    const first = track.querySelector('.w-80');
    if (!first) return;
    cardWidth = first.getBoundingClientRect().width;
    visible = Math.max(1, Math.floor(viewport.clientWidth / (cardWidth + gap)));
  }

  function goto(i){
    index = i;
    const translate = -(cardWidth + gap) * index;
    track.style.transform = `translateX(${translate}px)`;
    dots.forEach((d,di)=> d.className = di===index ? 'w-2 h-2 rounded-full bg-slate-800' : 'w-2 h-2 rounded-full bg-slate-300');
  }

  function next(){
    const total = track.children.length;
    const maxIndex = Math.max(0, total - visible);
    index = (index >= maxIndex) ? 0 : index + 1;
    goto(index);
  }

  dots.forEach(d=> d.addEventListener('click', ()=> goto(Number(d.dataset.reviewDot||'0'))));

  measure();
  goto(0);
  let timer = setInterval(next, 4000);
  window.addEventListener('resize', ()=>{ measure(); goto(index); });
  viewport.addEventListener('mouseenter', ()=> clearInterval(timer));
  viewport.addEventListener('mouseleave', ()=> timer = setInterval(next, 4000));
})();
</script>
