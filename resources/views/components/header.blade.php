<!-- Header -->
<header class="bg-gray-100 sticky top-0 z-50">
  <!-- Top Row: Logo, Search, User/Cart -->
  <div class="max-w-7xl mx-auto px-4 py-2">
    <div class="flex items-center justify-between">
      <!-- Left: logo + hamburger (hamburger only visible on mobile) -->
      <div class="flex items-center gap-3 order-1 lg:order-none">
        <button id="nav-toggle" class="p-2 -ml-2 rounded hover:bg-gray-200 focus:outline-none lg:hidden" aria-label="Open Menu" onclick="openNavDrawer()">
          <svg class="w-6 h-6 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <a href="/" class="flex items-center">
          <div class="flex items-center">
            <span class="text-2xl font-bold text-red-600">S</span>
            <span class="text-xl font-bold text-black">SB</span>
            <span class="text-sm text-red-600 ml-1">Leather</span>
          </div>
        </a>
      </div>

      <!-- Center: search (expandable on mobile) -->
      <div class="hidden lg:flex flex-1 max-w-md mx-4 sm:mx-8 order-3 lg:order-none" id="searchContainer">
        <div class="relative w-full">
          <input
            type="search"
            placeholder="Search for products..."
            class="w-full bg-gray-200 border border-gray-300 rounded px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
          />
          <button class="absolute right-2 top-1/2 -translate-y-1/2 bg-gray-800 text-white p-1.5 rounded">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile search icon -->
      <button onclick="toggleSearch()" class="lg:hidden order-2 p-2 text-gray-700 hover:text-gray-900">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
        </svg>
      </button>

      <!-- Right: user & cart (always visible) -->
      <div class="flex items-center gap-2 sm:gap-4 order-2 lg:order-none">
        @auth
        <div class="relative group">
          <button class="flex items-center text-black hover:text-gray-600">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            <span class="text-sm">{{ Auth::user()->name }}</span>
            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 24 24">
              <path d="M7 10l5 5 5-5z"/>
            </svg>
          </button>

          <div class="absolute top-full right-0 mt-1 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <div class="py-1">
              @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Dashboard</a>
              @endif
              @if(Auth::user()->isCustomer())
              <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
              <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
              @endif
              <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
              </form>
            </div>
          </div>
        </div>
        @else
          <a href="{{ route('login') }}" class="text-black hover:text-gray-600 text-sm font-medium">Login</a>
        @endauth

        <button class="relative text-black hover:text-gray-600">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
          </svg>
          <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">0</span>
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