<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'User Panel')</title>
    
    @vite(['resources/css/user/user.css', 'resources/js/user/user.js'])
    @stack('styles')
</head>
<body>
    <div id="user-app">
        @include('user.partials.navbar')
        @yield('content')
        @include('user.partials.footer')
    </div>
    
    @stack('scripts')
</body>
</html>