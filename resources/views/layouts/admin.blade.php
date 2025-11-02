<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <!-- Flash Messages -->
            @if(session('success'))
              <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <div class="flex items-center">
                  <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                  {{ session('success') }}
                </div>
              </div>
            @endif

            @if(session('error'))
              <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="flex items-center">
                  <i data-feather="alert-circle" class="w-5 h-5 mr-2"></i>
                  {{ session('error') }}
                </div>
              </div>
            @endif

            @if($errors->any())
              <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="flex items-center mb-2">
                  <i data-feather="alert-circle" class="w-5 h-5 mr-2"></i>
                  <strong>Please fix the following errors:</strong>
                </div>
                <ul class="list-disc list-inside ml-4">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

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