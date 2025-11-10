@props([
    'title' => 'ShoeShop – Premium Footwear Store',
])
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>    
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