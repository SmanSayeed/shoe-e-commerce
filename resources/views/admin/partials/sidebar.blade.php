<!-- Sidebar Starts -->
<aside class="sidebar">
  <!-- Sidebar Header Starts -->
  <a href="/">
    <div class="sidebar-header">
      <div class="sidebar-logo-icon">
        <img src="./images/logo-small.svg" alt="logo" class="h-[45px]" />
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
      <a href="javascript:void(0);" class="sidebar-menu">
        <span class="sidebar-menu-icon">
          <i data-feather="users"></i>
        </span>
        <span class="sidebar-menu-text">Users</span>
        <span class="sidebar-menu-arrow">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="./user-list.html" class="sidebar-submenu-item">List</a>
        </li>
        <li>
          <a href="./profile.html" class="sidebar-submenu-item"> Profile </a>
        </li>
      </ul>
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
          <a href="./invoice-create.html" class="sidebar-submenu-item"> Create </a>
        </li>

        <li>
          <a href="./invoice-details.html" class="sidebar-submenu-item"> Details </a>
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
          <a href="./product-list.html" class="sidebar-submenu-item"> Products List </a>
        </li>
        <li>
          <a href="./order-list.html" class="sidebar-submenu-item"> Create New Product </a>
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
          <a href="./product-list.html" class="sidebar-submenu-item"> Orders List </a>
        </li>
      </ul>
    </li>


  </ul>
  <!-- Sidebar Menu Ends -->
</aside>
<!-- Sidebar Ends -->