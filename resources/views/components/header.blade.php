<!-- Header -->
<header class="bg-white/95 backdrop-blur-md border-b border-slate-200/50 sticky top-0 z-50 shadow-sm">
  <!-- Top Row: Logo, Search, User/Cart -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
    <div class="flex items-center justify-between">
      <!-- Left: logo + hamburger (hamburger only visible on mobile) -->
      <div class="flex items-center gap-2 sm:gap-3 order-1 lg:order-none">
        <button id="nav-toggle" class="p-2 -ml-2 rounded-lg hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 lg:hidden transition-all duration-200" aria-label="Open Menu" onclick="openNavDrawer()">
          <svg class="w-6 h-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <a href="/" class="flex items-center group">
          <div class="flex items-center">
            <span class="text-xl sm:text-2xl font-bold text-red-600 group-hover:text-red-700 transition-colors duration-200">S</span>
            <span class="text-lg sm:text-xl font-bold text-slate-900 group-hover:text-slate-700 transition-colors duration-200">SB</span>
            <span class="text-xs sm:text-sm text-red-600 ml-1 group-hover:text-red-700 transition-colors duration-200 hidden sm:inline">Leather</span>
          </div>
        </a>
      </div>

      <!-- Center: search (expandable on mobile) -->
      <div class="hidden lg:flex flex-1 max-w-md mx-4 sm:mx-8 order-3 lg:order-none" id="searchContainer">
        <div class="relative w-full">
          <input
            type="search"
            placeholder="Search for products..."
            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
          />
          <button class="absolute right-2 top-1/2 -translate-y-1/2 bg-slate-800 text-white p-1.5 rounded-md hover:bg-slate-700 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile search icon -->
      <button onclick="toggleSearch()" class="lg:hidden order-2 p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
        </svg>
      </button>

      <!-- Right: user & cart (always visible) -->
      <div class="flex items-center gap-1 sm:gap-2 md:gap-4 order-2 lg:order-none">
        <!-- Modern Login Component -->
        <x-login-dropdown />

        <button class="relative text-slate-700 hover:text-slate-900 p-1.5 sm:p-2 rounded-lg hover:bg-slate-100 transition-all duration-200 group">
          <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
          </svg>
          <span class="absolute -top-0.5 -right-0.5 sm:-top-1 sm:-right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 sm:h-5 sm:w-5 flex items-center justify-center font-medium group-hover:scale-110 transition-transform duration-200">0</span>
        </button>
      </div>
    </div>
  </div>

</header>

<!-- Header interaction scripts -->
<script>
  function openNavDrawer() {
    // If your project uses Alpine.js or a drawer component, listen for this event and open the drawer.
    const event = new CustomEvent('toggle-drawer', { detail: { open: true } });
    window.dispatchEvent(event);
  }

  // Mobile search toggle
  function toggleSearch() {
    const searchContainer = document.getElementById('searchContainer');
    if (searchContainer) {
      // Toggle visibility
      if (searchContainer.classList.contains('hidden')) {
        // Show search
        searchContainer.classList.remove('hidden');
        searchContainer.classList.add('flex', 'fixed', 'inset-x-0', 'top-16', 'p-4', 'bg-white', 'shadow-md', 'z-50');
        // Focus the input
        searchContainer.querySelector('input').focus();
      } else {
        // Hide search
        searchContainer.classList.add('hidden');
        searchContainer.classList.remove('flex', 'fixed', 'inset-x-0', 'top-16', 'p-4', 'bg-white', 'shadow-md', 'z-50');
      }
    }
  }

  // Close search when clicking outside (mobile)
  document.addEventListener('click', (e) => {
    const searchContainer = document.getElementById('searchContainer');
    const searchButton = e.target.closest('button[onclick="toggleSearch()"]');
    const isClickInside = searchContainer?.contains(e.target) || searchButton;
    
    if (!isClickInside && searchContainer && !searchContainer.classList.contains('hidden') && window.innerWidth < 1024) {
      toggleSearch();
    }
  });
</script>