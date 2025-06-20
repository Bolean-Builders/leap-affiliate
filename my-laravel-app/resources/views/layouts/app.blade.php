<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Page-specific styles -->
    @stack('styles')
</head>
<body>
    <div id="app">

        {{-- ✅ Vendor Navbar --}}
        @include('partials.vendor.navbar')
        @include('components.notification')
        {{-- Default Laravel Navbar (optional) --}}
        {{-- 
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            ...
        </nav>
        --}}

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Page-specific scripts -->
    @stack('scripts')
</body>
</html>
