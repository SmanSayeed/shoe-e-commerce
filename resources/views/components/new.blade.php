  <!-- New Arrivals -->
  <section id="new-arrivals" class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between text-center sm:text-left gap-3 mb-6">
      <h2 class="text-xl font-bold w-full">New Products</h2>
        <a href="{{ route('home') }}#new-arrivals" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
      <template id="product-card">
        <a href="#" class="card group rounded-xl bg-white overflow-hidden">
          <div class="relative aspect-[4/3] bg-slate-100">
            <img class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]" src="https://picsum.photos/seed/leather/600/450" alt="product" />
            <span class="absolute left-3 top-3 text-[10px] font-bold uppercase tracking-wide bg-rose-600 text-white px-2 py-0.5 rounded">-25%</span>
          </div>
          <div class="p-4">
            <p class="text-xs text-slate-500">Leather</p>
            <p class="font-semibold line-clamp-2">Classic Formal Shoes For Men</p>
            <div class="mt-2 flex items-center gap-2"><span class="text-amber-700 font-bold">৳2250</span><span class="text-slate-400 line-through">৳2999</span></div>
            <button class="mt-3 w-full inline-flex items-center justify-center rounded-md bg-slate-900 text-white py-2 text-sm font-semibold hover:bg-slate-800">Select options</button>
          </div>
        </a>
      </template>
      <script>
        const pg = document.currentScript.previousElementSibling; for (let i=0;i<5;i++) pg.parentElement.appendChild(pg.content.cloneNode(true));
      </script>
    </div>
  </section>

  <!-- Feature trio (Travel/Executive/Women bag) -->
  <section id="best-items" class="max-w-7xl mx-auto px-4 pb-12">
    <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between text-center sm:text-left gap-3 mb-6">
      <h2 class="text-xl font-bold w-full">Best Items</h2>
        <a href="{{ route('home') }}#best-items" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
      <div class="card rounded-xl overflow-hidden">
        <img class="w-full h-64 object-cover" src="https://images.unsplash.com/photo-1547949003-9792a18a2601?q=80&w=1200&auto=format&fit=crop" alt="Travel Bag" />
        <div class="p-4"><h3 class="font-bold text-center mb-4">Travel Bag</h3><button class="w-full bg-slate-900 hover:bg-slate-800 text-white py-2 rounded">Order Now</button></div>
      </div>
      <div class="card rounded-xl overflow-hidden">
        <img class="w-full h-64 object-cover" src="https://images.unsplash.com/photo-1561344640-2453889cde5b?q=80&w=1200&auto=format&fit=crop" alt="Executive Bag" />
        <div class="p-4"><h3 class="font-bold text-center mb-4">Executive Bag</h3><button class="w-full bg-slate-900 hover:bg-slate-800 text-white py-2 rounded">Order Now</button></div>
      </div>
      <div class="card rounded-xl overflow-hidden">
        <img class="w-full h-64 object-cover" src="https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?q=80&w=1200&auto=format&fit=crop" alt="Women's Bag" />
        <div class="p-4"><h3 class="font-bold text-center mb-4">Women's Bag</h3><button class="w-full bg-slate-900 hover:bg-slate-800 text-white py-2 rounded">Order Now</button></div>
      </div>
    </div>
  </section>

  <!-- Just For You -->
  <section id="special-items" class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between text-center sm:text-left gap-3 mb-6">
      <h2 class="text-xl font-bold w-full">Special Items</h2>
        <a href="{{ route('home') }}#special-items" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
      <template id="pick-card">
        <a href="#" class="card group rounded-xl bg-white overflow-hidden">
          <div class="relative aspect-[4/3] bg-slate-100">
            <img class="h-full w-full object-cover" src="https://picsum.photos/seed/ssb/600/450" alt="pick" />
            <span class="absolute left-3 top-3 text-[10px] font-bold uppercase tracking-wide bg-rose-600 text-white px-2 py-0.5 rounded">-53%</span>
          </div>
          <div class="p-4">
            <p class="font-semibold text-sm line-clamp-2">Luxury Penny Formal Shoes</p>
            <div class="mt-2 flex items-center gap-2"><span class="text-amber-700 font-bold">৳1899</span><span class="text-slate-400 line-through">৳3999</span></div>
            <button class="mt-3 w-full inline-flex items-center justify-center rounded-md bg-slate-900 text-white py-2 text-sm font-semibold hover:bg-slate-800">Select options</button>
          </div>
        </a>
      </template>
      <script>
        const pk = document.currentScript.previousElementSibling; for (let i=0;i<5;i++) pk.parentElement.appendChild(pk.content.cloneNode(true));
      </script>
    </div>
  </section>

  <!-- Customer Reviews -->
  <x-customer-reviews />