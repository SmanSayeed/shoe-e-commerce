<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - @yield('title')</title>
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
    @stack('styles')
</head>
<body>
 
    <div id="app">
  
        @include('admin.partials.sidebar')
  
        <!-- Wrapper Starts -->
        <div class="wrapper">
       
          @include('admin.partials.header')
  
          <!-- Page Content Starts -->
          <div class="content">
            <!-- Main Content Starts -->
            <main class="flex-grow p-4 sm:p-6">
                @yield('content')
            </main>
            <!-- Main Content Ends -->
  
          @include('admin.partials.footer')
          </div>
          <!-- Page Content Ends -->
        </div>
        <!-- Wrapper Ends -->
  
        @include('admin.partials.search-modal')
      </div>
      
    
    @stack('scripts')
</body>
</html>