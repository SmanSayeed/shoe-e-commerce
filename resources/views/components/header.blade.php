
<!-- Header -->
<header class="bg-gray-100 sticky top-0 z-50">
  <!-- Top Row: Logo, Search, User/Cart -->
  <div class="max-w-7xl mx-auto px-4 py-2">
    <div class="flex items-center justify-between">
      <!-- Left: Hamburger + Logo -->
      <div class="flex items-center gap-2">
        <!-- Hamburger -->
        <button class="p-2 -ml-2 rounded hover:bg-gray-200 focus:outline-none" aria-label="Open Menu" onclick="openNavDrawer()">
          <svg class="w-6 h-6 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <!-- Logo Section -->
        <a href="#" class="flex items-center">
          <!-- Simplified SSB Logo -->
          <div class="flex items-center">
            <span class="text-2xl font-bold text-red-600">S</span>
            <span class="text-xl font-bold text-black">SB</span>
            <span class="text-sm text-red-600 ml-1">Leather</span>
          </div>
        </a>
      </div>

      <!-- Search Bar -->
      <div class="flex-1 max-w-md mx-8">
        <div class="relative">
          <input 
            type="search" 
            placeholder="Search for products..." 
            class="w-full bg-gray-200 border border-gray-300 rounded px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
          />
          <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-1.5 rounded">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- User and Cart Icons -->
      <div class="flex items-center gap-4">
        <!-- User Icon -->
        <button class="text-black hover:text-gray-600">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
          </svg>
        </button>
        
        <!-- Cart Icon with Badge -->
        <button class="relative text-black hover:text-gray-600">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
          </svg>
          <!-- Cart Badge -->
          <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">0</span>
        </button>
      </div>
    </div>
  </div>

  <!-- Bottom Row: Navigation -->
  {{--
  <div class="max-w-7xl mx-auto px-4 pb-2">
    <nav class="flex items-center justify-center">
      <!-- Shoes Dropdown -->
      <div class="relative group">
        <button class="text-gray-800 font-semibold text-sm flex items-center hover:text-gray-600 py-2">
          SHOES
          <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 24 24">
            <path d="M7 10l5 5 5-5z"/>
          </svg>
        </button>
        
        <!-- Dropdown Menu -->
        <div class="absolute top-full left-1/2 transform -translate-x-1/2 mt-1 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
          <div class="py-1">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Casual</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Formal</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Loafers</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sandals</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sneakers</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Boots</a>
          </div>
        </div>
      </div>
    </nav>
  </div>
  --}}
</header>