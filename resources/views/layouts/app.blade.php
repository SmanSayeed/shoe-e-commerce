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
    @php
        $faviconUrl = \App\Helpers\SiteSettingsHelper::faviconUrl();
    @endphp
    @if($faviconUrl)
        <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
    @endif
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/user/app.css', 'resources/js/user/app.js'])
    @stack('styles')
</head>
<body>
    <!-- Navigation Drawer - Outside main app container for proper z-index stacking -->
    <x-nav-drawer />

    <div id="user-app">
        <x-header />
         {{ $slot }}
        <x-footer />
    </div>

    @stack('scripts')
</body>
</html>
