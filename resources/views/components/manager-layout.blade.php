<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Manager Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }
        
        .animate-scale-in {
            animation: scaleIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes scaleIn {
            from { 
                opacity: 0;
                transform: scale(0.9);
            }
            to { 
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .nav-link-modern {
            position: relative;
            overflow: hidden;
        }
        
        .nav-link-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .nav-link-modern:hover::before {
            left: 100%;
        }
        
        .floating-action {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }
        
        .dark .bg-gray-50 {
            background-color: #0f172a;
        }
        
        .dark .bg-white {
            background-color: #1e293b;
        }
        
        .dark .text-gray-900 {
            color: #f1f5f9;
        }
        
        .dark .text-gray-600 {
            color: #94a3b8;
        }
        
        .dark .border-gray-200 {
            border-color: #334155;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 transition-colors duration-300">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 shadow-2xl backdrop-blur-sm border-b border-white/10 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 animate-fade-in">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                    <i class="fas fa-seedling text-white text-xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-white text-xl font-bold tracking-tight">Palm Oil</h1>
                                    <p class="text-emerald-100 text-xs font-medium">Manager Portal</p>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden text-white space-x-2 sm:ml-10 sm:flex">
                            <a href="{{ route('manager.laporan') }}" 
                               class="nav-link-modern group px-6 py-3 rounded-xl font-medium transition-all duration-300 {{ request()->routeIs('manager.laporan') ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/10' }}">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-chart-bar text-sm group-hover:scale-110 transition-transform"></i>
                                    <span>Laporan</span>
                                </div>
                            </a>
                            <a href="{{ route('manager.statistik') }}" 
                               class="nav-link-modern group px-6 py-3 rounded-xl font-medium transition-all duration-300 {{ request()->routeIs('manager.statistik') ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/10' }}">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-chart-line text-sm group-hover:scale-110 transition-transform"></i>
                                    <span>Statistik</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-4">
                        <!-- Dark Mode Toggle -->
                        <button onclick="toggleDarkMode()" class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-200">
                            <i class="fas fa-moon text-white text-sm" id="darkModeIcon"></i>
                        </button>
                        
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-200">
                                <i class="fas fa-bell text-white text-sm"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                            </button>
                        </div>

                        <!-- User Dropdown -->
                        <div class="relative">
                            <button type="button" class="flex items-center space-x-3 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-200 group" 
                                    onclick="toggleDropdown()">
                                <div class="w-10 h-10 bg-gradient-to-br from-white/30 to-white/10 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div class="text-left">
                                    <p class="text-white font-medium text-sm">{{ Auth::user()->name }}</p>
                                    <p class="text-emerald-100 text-xs">Manager</p>
                                </div>
                                <i class="fas fa-chevron-down text-white text-xs group-hover:rotate-180 transition-transform duration-200"></i>
                            </button>

                            <div id="dropdown" class="hidden absolute right-0 mt-3 w-64 bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 overflow-hidden animate-scale-in">
                                <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                            <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                                            <span class="inline-block px-2 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full mt-1">Manager</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-user-edit text-emerald-500 mr-3"></i>
                                        <span>Edit Profile</span>
                                    </a>
                                    <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-cog text-gray-400 mr-3"></i>
                                        <span>Settings</span>
                                    </a>
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-6 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                            <i class="fas fa-sign-out-alt mr-3"></i>
                                            <span>Sign Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden">
                        <button onclick="toggleMobileMenu()" class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors">
                            <i class="fas fa-bars text-white"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div id="mobile-menu" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('manager.beranda') }}" 
                       class="mobile-nav-link {{ request()->routeIs('manager.beranda') ? 'active' : '' }}">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
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

        <!-- Floating Action Button -->
        <div class="floating-action">
            <button onclick="scrollToTop()" class="w-14 h-14 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-full shadow-2xl hover:shadow-emerald-500/25 hover:scale-110 transition-all duration-300 flex items-center justify-center">
                <i class="fas fa-arrow-up"></i>
            </button>
        </div>

        <!-- Footer -->
        <footer class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg border-t border-gray-200 dark:border-slate-700 mt-12">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-seedling text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white">Palm Oil</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Management System</p>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Sistem manajemen perkebunan kelapa sawit yang modern dan efisien untuk meningkatkan produktivitas.
                        </p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('manager.laporan') }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Laporan</a></li>
                            <li><a href="{{ route('manager.statistik') }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Statistik</a></li>
                            <li><a href="{{ route('profile.edit') }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Profile</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-4">System Info</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-shield-alt text-emerald-500 mr-2"></i>
                                <span>Secure Manager Portal</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-eye text-blue-500 mr-2"></i>
                                <span>Read-Only Access</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-clock text-purple-500 mr-2"></i>
                                <span>Last Updated: {{ now()->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 dark:border-slate-700 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">
                        © {{ date('Y') }} Palm Oil Management System. All rights reserved.
                    </div>
                    <div class="flex items-center space-x-4 mt-4 md:mt-0">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Powered by Laravel</span>
                        <div class="flex space-x-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-xs text-gray-500 dark:text-gray-400">System Online</span>
                        </div>
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
        // Dark mode functionality
        function toggleDarkMode() {
            const html = document.documentElement;
            const icon = document.getElementById('darkModeIcon');
            
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                icon.className = 'fas fa-moon text-white text-sm';
                localStorage.setItem('darkMode', 'false');
            } else {
                html.classList.add('dark');
                icon.className = 'fas fa-sun text-white text-sm';
                localStorage.setItem('darkMode', 'true');
            }
        }

        // Initialize dark mode
        document.addEventListener('DOMContentLoaded', function() {
            const darkMode = localStorage.getItem('darkMode');
            const icon = document.getElementById('darkModeIcon');
            
            if (darkMode === 'true') {
                document.documentElement.classList.add('dark');
                icon.className = 'fas fa-sun text-white text-sm';
            }
        });

        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdown');
            const button = event.target.closest('button');
            
            if (!button || !button.onclick || button.onclick.toString().indexOf('toggleDropdown') === -1) {
                dropdown.classList.add('hidden');
            }
        });

        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>