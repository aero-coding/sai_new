<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <title>Admin Panel - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('assets/img/favicons/favicon_transparent.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicons/favicon_transparent.png') }}">

    @vite(['resources/css/admin_app.css', 'resources/js/app.js'])
    <!-- Scripts opcionales (ej. Alpine.js) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Barra de navegación -->
    {{-- <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold text-gray-900">
                        {{ config('app.name') }} Admin
                    </a>
                    
                    <!-- Menú -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('admin.pages.index') }}" 
                           class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                            Pages
                        </a>
                        <a href="{{ route('admin.projects.index') }}" 
                           class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                            Projects
                        </a>
                        <a href="{{ route('admin.reports.index') }}" 
                           class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                            Reports
                        </a>
                        <a href="{{ route('admin.tags.index') }}" 
                           class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                            Tags
                        </a>
                    </div>
                </div>
                
                <!-- User Dropdown -->
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="text-gray-600 hover:text-indigo-600 text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav> --}}
    <nav class="admin-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between h-16">
                <div class="d-flex  items-center">
                    <a href="{{ route('admin.dashboard') }}" class="logo">
                        {{ config('app.name') }} Admin
                    </a>
                    
                    <div class="d-flex hidden sm:ml-6 sm:flex sm:space-x-4">
                        <a href="{{ route('admin.pages.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                            Pages
                        </a>
                        <a href="{{ route('admin.projects.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                            Projects
                        </a>
                        <a href="{{ route('admin.reports.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            Reports
                        </a>
                        <a href="{{ route('admin.tags.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                            Tags
                        </a>
                        <a href="{{ route('admin.media-library.index') }}" 
                            class="nav-link {{ request()->routeIs('admin.media-library.*') ? 'active' : '' }}">
                            Media Library
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Sección para scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>