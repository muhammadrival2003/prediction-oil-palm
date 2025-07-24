<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Manager Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <h1 class="text-white text-xl font-bold">
                                <i class="fas fa-seedling mr-2"></i>
                                Palm Oil Manager
                            </h1>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <!-- <a href="{{ route('manager.beranda') }}" 
                               class="nav-link {{ request()->routeIs('manager.beranda') ? 'active' : '' }}">
                                <i class="fas fa-home mr-2"></i>Beranda
                            </a> -->
                            <a href="{{ route('manager.laporan') }}" 
                               class="nav-link {{ request()->routeIs('manager.laporan') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar mr-2"></i>Laporan
                            </a>
                            <a href="{{ route('manager.statistik') }}" 
                               class="nav-link {{ request()->routeIs('manager.statistik') ? 'active' : '' }}">
                                <i class="fas fa-chart-line mr-2"></i>Statistik
                            </a>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="relative">
                            <button type="button" class="flex items-center text-sm text-white hover:text-gray-200 focus:outline-none focus:text-gray-200 transition duration-150 ease-in-out" 
                                    onclick="toggleDropdown()">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                    <span>{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down ml-2 text-xs"></i>
                                </div>
                            </button>

                            <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <div class="px-4 py-2 text-xs text-gray-400 border-b">
                                    Manager Dashboard
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-edit mr-2"></i>Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-200 hover:bg-white hover:bg-opacity-10 focus:outline-none focus:bg-white focus:bg-opacity-10 transition duration-150 ease-in-out">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div id="mobile-menu" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <!-- <a href="{{ route('manager.beranda') }}" 
                       class="mobile-nav-link {{ request()->routeIs('manager.beranda') ? 'active' : '' }}">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a> -->
                    <a href="{{ route('manager.laporan') }}" 
                       class="mobile-nav-link {{ request()->routeIs('manager.laporan') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar mr-2"></i>Laporan
                    </a>
                    <a href="{{ route('manager.statistik') }}" 
                       class="mobile-nav-link {{ request()->routeIs('manager.statistik') ? 'active' : '' }}">
                        <i class="fas fa-chart-line mr-2"></i>Statistik
                    </a>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-white border-opacity-20">
                    <div class="px-4">
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="mobile-nav-link">
                            <i class="fas fa-user-edit mr-2"></i>Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left mobile-nav-link">
                                <i class="fas fa-sign-out-alt mr-2"></i>Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="text-gray-500 text-sm">
                        © {{ date('Y') }} Palm Oil Management System. Manager Dashboard - Read Only Access.
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-shield-alt mr-2 text-green-500"></i>
                        Secure Manager Portal
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <style>
        .nav-link {
            @apply inline-flex items-center px-4 py-2 text-sm font-medium text-white hover:text-gray-200 hover:bg-white hover:bg-opacity-10 rounded-lg transition duration-150 ease-in-out;
        }
        
        .nav-link.active {
            @apply bg-white bg-opacity-20 text-white;
        }
        
        .mobile-nav-link {
            @apply block pl-3 pr-4 py-2 text-base font-medium text-white hover:text-gray-200 hover:bg-white hover:bg-opacity-10 transition duration-150 ease-in-out;
        }
        
        .mobile-nav-link.active {
            @apply bg-white bg-opacity-20 text-white;
        }
    </style>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdown');
            const button = event.target.closest('button');
            
            if (!button || !button.onclick || button.onclick.toString().indexOf('toggleDropdown') === -1) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>