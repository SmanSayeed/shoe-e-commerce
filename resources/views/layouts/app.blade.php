<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'User Panel')</title>    
    @vite(['resources/css/user/app.css', 'resources/js/user/app.js'])
    @stack('styles')
</head>
<body>
    <div id="user-app">
        <x-header />
         {{ $slot }}
        <x-footer />
    </div>
    
    @stack('scripts')
</body>
</html>