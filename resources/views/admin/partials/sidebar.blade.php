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
      <a href="{{ route('admin.dashboard') }}" class="sidebar-menu">
        <span class="sidebar-menu-icon">
          <i data-feather="home"></i>
        </span>
        <span class="sidebar-menu-text">Dashboard</span>
      </a>
    </li>

    <!-- Users -->
    <li>
      <a href="{{ route('admin.users') }}" class="sidebar-menu">
        <span class="sidebar-menu-icon">
          <i data-feather="user"></i>
        </span>
        <span class="sidebar-menu-text">Users</span>
      </a>
    </li>

    {{-- Categories --}}
    <li>
      <a href="javascript:void(0);" class="sidebar-menu">
        <span class="sidebar-menu-icon">
          <i data-feather="file-text"></i>
        </span>
        <span class="sidebar-menu-text">Categories</span>
        <span class="sidebar-menu-arrow">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="{{ route('admin.categories') }}" class="sidebar-submenu-item"> Categories </a>
        </li>
        <li>
          <a href="{{ route('admin.sub-categories') }}" class="sidebar-submenu-item">Sub Categories </a>
        </li>
        <li>
          <a href="{{ route('admin.create-category') }}" class="sidebar-submenu-item">Create Category </a>
        </li>
        <li>
          <a href="{{ route('admin.create-sub-category') }}" class="sidebar-submenu-item"> Create Subcategory </a>
        </li>
       
      </ul>
    </li>
    <!-- ecommnerce -->
    <li>
      <a href="javascript:void(0);" class="sidebar-menu">
        <span class="sidebar-menu-icon">
          <i data-feather="shopping-bag"></i>
        </span>
        <span class="sidebar-menu-text">Products</span>
        <span class="sidebar-menu-arrow">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="{{ route('admin.products') }}" class="sidebar-submenu-item"> Products List </a>
        </li>
        <li>
          <a href="{{ route('admin.create-product') }}" class="sidebar-submenu-item"> Create New Product </a>
        </li>
      </ul>
    </li>

    {{-- Orders --}}
    <li>
      <a href="javascript:void(0);" class="sidebar-menu">
        <span class="sidebar-menu-icon">
          <i data-feather="shopping-bag"></i>
        </span>
        <span class="sidebar-menu-text">Orders</span>
        <span class="sidebar-menu-arrow">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="{{ route('admin.orders') }}" class="sidebar-submenu-item"> Orders List </a>
        </li>     
      </ul>
    </li>


  </ul>
  <!-- Sidebar Menu Ends -->
</aside>
<!-- Sidebar Ends -->