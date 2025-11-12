<!-- Nav Drawer Component -->
<div id="nav-drawer-root">
  <!-- Overlay -->
  <div id="nav-overlay" class="fixed inset-0 bg-black/40 opacity-0 invisible transition-opacity duration-200" 
       onclick="closeNavDrawer()"></div>

  <!-- Drawer -->
  <aside id="nav-drawer" class="fixed left-0 top-0 h-full w-80 max-w-[85vw] -translate-x-full bg-white shadow-xl transition-transform duration-300">
    <div class="px-4 py-3 border-b">
      <div class="flex items-center justify-between">
        <h3 class="font-bold text-slate-900">Browse Categories</h3>
        <button class="p-2 rounded hover:bg-gray-100" aria-label="Close Menu" onclick="closeNavDrawer()">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
    </div>
    <nav class="px-2 py-2 text-sm">
      <ul id="nav-main" class="space-y-1">
        @forelse($categories as $category)
          <li>
            <div class="category-item">
              <div class="flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100">
                <a href="{{ route('categories.show', $category->slug) }}" class="flex-1 font-medium text-slate-800">
                  {{ $category->name }}
                </a>
                @if($category->subcategories->count() > 0)
                  <button onclick="toggleSubcategories('{{ $category->id }}')" class="p-1 text-slate-500">
                    <svg class="w-4 h-4 transform transition-transform" id="arrow-{{ $category->id }}" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"/>
                    </svg>
                  </button>
                @endif
              </div>
              
              @if($category->subcategories->count() > 0)
                <ul id="subcategories-{{ $category->id }}" class="ml-3 pl-3 border-l hidden space-y-1">
                  @foreach($category->subcategories as $subcategory)
                    <li>
                      <a href="{{ route('subcategories.show', [$category->slug, $subcategory->slug]) }}" 
                         class="block px-3 py-2 rounded hover:bg-gray-100 text-slate-700">
                        {{ $subcategory->name }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>
          </li>
        @empty
          <li class="px-3 py-4 text-center text-slate-500">
            No categories available
          </li>
        @endforelse
      </ul>
    </nav>
  </aside>
</div>

<script>
const navDrawer = document.getElementById('nav-drawer');
const navOverlay = document.getElementById('nav-overlay');

function openNavDrawer(){
  const navDrawer = document.getElementById('nav-drawer');
  const navOverlay = document.getElementById('nav-overlay');
  
  if (navDrawer && navOverlay) {
    navDrawer.classList.remove('-translate-x-full');
    navDrawer.classList.add('drawer-open');
    navOverlay.classList.add('overlay-open');
    navOverlay.classList.remove('invisible');
  }
}

function closeNavDrawer(){
  const navDrawer = document.getElementById('nav-drawer');
  const navOverlay = document.getElementById('nav-overlay');
  
  if (navDrawer && navOverlay) {
    navDrawer.classList.remove('drawer-open');
    navDrawer.classList.add('-translate-x-full');
    navOverlay.classList.remove('overlay-open');
    
    setTimeout(() => {
      navOverlay.classList.add('invisible');
    }, 300);
  }
}

function toggleSubcategories(categoryId) {
  const subcategoriesList = document.getElementById(`subcategories-${categoryId}`);
  const arrow = document.getElementById(`arrow-${categoryId}`);
  
  if (subcategoriesList && arrow) {
    subcategoriesList.classList.toggle('hidden');
    arrow.classList.toggle('rotate-180');
  }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
  // Listen for custom toggle-drawer event from header
  window.addEventListener('toggle-drawer', (e) => {
    if (e.detail && e.detail.open) {
      openNavDrawer();
    } else {
      closeNavDrawer();
    }
  });
  
  // Close on ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeNavDrawer();
  });
});
</script>

<!-- Navigation Drawer Styles -->
<style>
#nav-drawer {
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  height: 100vh !important;
  width: 320px !important;
  background: white !important;
  z-index: 9999 !important;
  transform: translateX(-100%) !important;
  transition: transform 0.3s ease !important;
  box-shadow: 2px 0 15px rgba(0,0,0,0.1) !important;
}

#nav-drawer.drawer-open {
  transform: translateX(0) !important;
}

#nav-overlay {
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  width: 100vw !important;
  height: 100vh !important;
  background: rgba(0,0,0,0.5) !important;
  z-index: 9998 !important;
  opacity: 0 !important;
  visibility: hidden !important;
  transition: all 0.3s ease !important;
}

#nav-overlay.overlay-open {
  opacity: 1 !important;
  visibility: visible !important;
}

/* Override conflicting Tailwind classes */
#nav-drawer.-translate-x-full {
  transform: none !important;
}

#nav-drawer.drawer-open.-translate-x-full {
  transform: translateX(0) !important;
}
</style>

<script>
// Dummy three-level menu
const menu = [
  { title: "Shoes", sub: [ { title: "Men’s Shoes", third: [ "Chinese", "Sports", "Casual" ] }, { title: "Women’s Shoes", third: [ "Heels", "Flats", "Sneakers" ] } ] },
  { title: "Apparel", sub: [ { title: "Men’s Apparel", third: [ "T-Shirts", "Jackets" ] } ] }
];

const navDrawer = document.getElementById('nav-drawer');
const navOverlay = document.getElementById('nav-overlay');
const navMain = document.getElementById('nav-main');

function openNavDrawer(){
  navDrawer.style.transform = 'translateX(0)';
  navOverlay.classList.remove('invisible');
  requestAnimationFrame(()=> navOverlay.classList.add('opacity-100'));
}
function closeNavDrawer(){
  navDrawer.style.transform = 'translateX(-100%)';
  navOverlay.classList.remove('opacity-100');
  navOverlay.addEventListener('transitionend', function handler(){
    navOverlay.classList.add('invisible');
    navOverlay.removeEventListener('transitionend', handler);
  });
}

function renderMenu(){
  navMain.innerHTML = '';
  menu.forEach((m, mi)=>{
    const li = document.createElement('li');
    li.innerHTML = `
      <button class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100 font-medium text-slate-800" data-main="${mi}">
        <span>${m.title}</span>
        <svg class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"/></svg>
      </button>
      <ul class="ml-3 pl-3 border-l hidden" data-sublist="${mi}"></ul>
    `;
    navMain.appendChild(li);
  });
}

function toggleSub(mi){
  const sublist = navMain.querySelector(`[data-sublist="${mi}"]`);
  if (!sublist) return;
  if (sublist.childElementCount === 0){
    // populate
    const subs = menu[mi].sub || [];
    subs.forEach((s, si)=>{
      const sli = document.createElement('li');
      sli.className = 'mt-1';
      sli.innerHTML = `
        <button class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100 text-slate-700" data-sub="${mi}-${si}">
          <span>${s.title}</span>
          <svg class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"/></svg>
        </button>
        <ul class="ml-3 pl-3 border-l hidden" data-thirdlist="${mi}-${si}"></ul>
      `;
      sublist.appendChild(sli);
    });
  }
  sublist.classList.toggle('hidden');
}

function toggleThird(mi, si){
  const key = `${mi}-${si}`;
  const third = navMain.querySelector(`[data-thirdlist="${key}"]`);
  if (!third) return;
  if (third.childElementCount === 0){
    const items = (menu[mi].sub?.[si]?.third) || [];
    items.forEach((t)=>{
      const tli = document.createElement('li');
      tli.innerHTML = `<a href="#" class="block px-3 py-2 rounded hover:bg-gray-100 text-slate-600">${t}</a>`;
      third.appendChild(tli);
    });
  }
  third.classList.toggle('hidden');
}

function wireEvents(){
  navMain.addEventListener('click', (e)=>{
    const mainBtn = e.target.closest('[data-main]');
    if (mainBtn){
      toggleSub(mainBtn.getAttribute('data-main'));
      return;
    }
    const subBtn = e.target.closest('[data-sub]');
    if (subBtn){
      const [mi, si] = subBtn.getAttribute('data-sub').split('-').map(Number);
      toggleThird(mi, si);
      return;
    }
  });
  // Close on ESC
  document.addEventListener('keydown', (e)=>{ if (e.key === 'Escape') closeNavDrawer(); });
  
  // Listen for custom toggle-drawer event from header
  window.addEventListener('toggle-drawer', (e) => {
    if (e.detail && e.detail.open) {
      openNavDrawer();
    } else {
      closeNavDrawer();
    }
  });
}

// Init
renderMenu();
wireEvents();
</script>

