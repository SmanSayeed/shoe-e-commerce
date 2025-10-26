<!-- Sidebar Starts -->
<aside class="sidebar">
  <!-- Sidebar Header Starts -->
  <a href="/">
    <div class="sidebar-header">
      <div class="sidebar-logo-icon">
        <img src="{{ asset('images/logo-small.svg') }}" alt="logo" class="h-[45px]" />
      </div>

      <div class="sidebar-logo-text">
        <h1 class="flex text-xl">
          <span class="font-bold text-slate-800 dark:text-slate-200"> Admin </span>
          <span class="font-semibold text-primary-500">Toolkit</span>
        </h1>

        <p class="whitespace-nowrap text-xs text-slate-400">Simple &amp; Customizable</p>
      </div>
    </div>
  </a>
  <!-- Sidebar Header Ends -->

  <!-- Sidebar Menu Starts -->
  <ul class="sidebar-content">
    <!-- Dashboard -->
    <li>
      <a href="{{ route('admin.dashboard') }}" class="sidebar-menu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="home"></i>
        </span>
        <span class="sidebar-menu-text">Dashboard</span>
      </a>
    </li>

    <!-- Users -->
    <li>
      <a href="{{ route('admin.users') }}" class="sidebar-menu {{ request()->routeIs('admin.users', 'admin.user-details') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="user"></i>
        </span>
        <span class="sidebar-menu-text">Users</span>
      </a>
    </li>

    {{-- Categories --}}
    <li>
      <a href="javascript:void(0);" class="sidebar-menu {{ request()->routeIs('admin.categories*', 'admin.subcategories*', 'admin.child-categories*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="file-text"></i>
        </span>
        <span class="sidebar-menu-text">Categories</span>
        <span class="sidebar-menu-arrow {{ request()->routeIs('admin.categories*', 'admin.subcategories*', 'admin.child-categories*') ? 'rotate' : '' }}">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="{{ route('admin.categories.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"> Categories </a>
        </li>
        <li>
          <a href="{{ route('admin.subcategories.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.subcategories.index') ? 'active' : '' }}">Sub Categories </a>
        </li>
        <li>
          <a href="{{ route('admin.child-categories.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.child-categories.index') ? 'active' : '' }}">Child Categories </a>
        </li>    
      </ul>
    </li>
    <!-- ecommnerce -->
    <li>
      <a href="javascript:void(0);" class="sidebar-menu {{ request()->routeIs('admin.products*', 'admin.brands*', 'admin.create-brand') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="shopping-bag"></i>
        </span>
        <span class="sidebar-menu-text">Products</span>
        <span class="sidebar-menu-arrow {{ request()->routeIs('admin.products*', 'admin.brands*', 'admin.create-brand') ? 'rotate' : '' }}">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="{{ route('admin.products.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"> Products List </a>
        </li>
        <li>
          <a href="{{ route('admin.brands') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.brands') ? 'active' : '' }}"> Brands </a>
        </li>
        <li>
          <a href="{{ route('admin.products.create') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}"> Create New Product </a>
        </li>
        <li>
          <a href="{{ route('admin.create-brand') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.create-brand') ? 'active' : '' }}"> Create Brand </a>
        </li>
      </ul>
    </li>

    {{-- Orders --}}
    <li>
      <a href="javascript:void(0);" class="sidebar-menu {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="package"></i>
        </span>
        <span class="sidebar-menu-text">Orders</span>
        <span class="sidebar-menu-arrow {{ request()->routeIs('admin.orders*') ? 'rotate' : '' }}">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="{{ route('admin.orders.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}"> Orders List </a>
        </li>     
      </ul>
    </li>


  </ul>
  <!-- Sidebar Menu Ends -->
</aside>
<!-- Sidebar Ends -->