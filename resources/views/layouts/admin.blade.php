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
    <div>        
        <main>
            @yield('content')
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>