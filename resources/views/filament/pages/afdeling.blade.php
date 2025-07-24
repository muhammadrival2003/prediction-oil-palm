<x-filament-panels::page>
    <!-- Include Modern Styles -->
    <link rel="stylesheet" href="{{ asset('css/afdeling-modern.css') }}">
    
    <!-- Meta tags for better mobile experience -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#10b981">

    <!-- Breadcrumb -->
    <x-filament::breadcrumbs :breadcrumbs="[
        '/admin/afdeling' => 'Afdeling',
    ]" />
    
    <!-- Modern Header Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-emerald-900/20 rounded-3xl p-8 mb-8 shadow-xl border border-emerald-100/50 dark:border-gray-700/50">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute top-4 right-4 w-20 h-20 bg-emerald-200/30 dark:bg-emerald-500/20 rounded-full floating-animation"></div>
        <div class="absolute bottom-4 left-4 w-16 h-16 bg-blue-200/30 dark:bg-blue-500/20 rounded-full floating-animation" style="animation-delay: -2s;"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-center gap-4 mb-4">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <x-heroicon-o-map class="w-8 h-8 text-white" />
                        </div>
                        <div class="absolute inset-0 bg-emerald-500 rounded-2xl pulse-ring"></div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 via-emerald-800 to-emerald-600 dark:from-white dark:via-emerald-200 dark:to-emerald-400 bg-clip-text text-transparent">
                            Manajemen Afdeling
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mt-1">
                            Kelola dan pantau seluruh afdeling perkebunan kelapa sawit
                        </p>
                    </div>
                </div>
                
                <!-- Stats Cards -->
                <div class="flex flex-wrap gap-4 mt-6">
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl px-4 py-3 border border-gray-200/50 dark:border-gray-600/50">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Afdeling</span>
                            <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ $this->afdelings->count() }}</span>
                        </div>
                    </div>
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl px-4 py-3 border border-gray-200/50 dark:border-gray-600/50">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Status</span>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <x-heroicon-m-plus class="w-5 h-5 mr-2" />
                    Tambah Afdeling
                </button>
            </div>
        </div>
    </div>

    @if($this->afdelings->isEmpty())
        <!-- Enhanced Empty State -->
        <div class="text-center py-16">
            <div class="relative mx-auto w-32 h-32 mb-8">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/50 rounded-full"></div>
                <div class="absolute inset-4 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                    <x-heroicon-o-map class="w-12 h-12 text-emerald-500" />
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Belum Ada Afdeling</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                Mulai dengan menambahkan afdeling pertama untuk mengelola perkebunan kelapa sawit Anda.
            </p>
            <button class="inline-flex items-center px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <x-heroicon-m-plus class="w-5 h-5 mr-2" />
                Tambah Afdeling Pertama
            </button>
        </div>
    @else
        <!-- Modern Afdeling Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
            @foreach($this->afdelings as $index => $afdeling)
            <div class="group relative" style="animation-delay: {{ $index * 100 }}ms;">
                <a
                    href="{{ route('filament.admin.pages.afdeling.menu', ['afdeling_id' => $afdeling->id]) }}"
                    class="afdeling-card relative flex flex-col h-full overflow-hidden rounded-2xl p-6 shadow-lg border border-gray-200/50 dark:border-gray-700/50 hover:border-emerald-300 dark:hover:border-emerald-500/50"
                    aria-label="Kelola afdeling {{ $afdeling->nama }}"
                    role="button">

                    <!-- Status Indicator -->
                    <div class="absolute top-4 right-4 w-3 h-3 bg-emerald-500 rounded-full shadow-lg"></div>

                    <!-- Icon Container -->
                    <div class="mb-6 flex justify-center">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/50 rounded-2xl flex items-center justify-center group-hover:icon-glow transition-all duration-300 transform group-hover:scale-110">
                                @if(isset($afdeling->image_url) && $afdeling->image_url)
                                    <img
                                        src="{{ $afdeling->image_url }}"
                                        alt="Logo {{ $afdeling->nama }}"
                                        class="w-10 h-10 object-cover rounded-xl"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-10 h-10 hidden items-center justify-center">
                                        <x-heroicon-o-map class="w-8 h-8 text-emerald-600 dark:text-emerald-400" />
                                    </div>
                                @else
                                    <x-heroicon-o-map class="w-8 h-8 text-emerald-600 dark:text-emerald-400" />
                                @endif
                            </div>
                            <!-- Hover Ring Effect -->
                            <div class="absolute inset-0 rounded-2xl border-2 border-emerald-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300 animate-pulse"></div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-grow text-center space-y-3">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                            {{ $afdeling->nama }}
                        </h3>

                        <!-- Quick Stats -->
                        <div class="flex justify-center gap-4 pt-2">
                            <div class="text-center">
                                <div class="text-xs text-gray-500 dark:text-gray-400">Blok</div>
                                <div class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ rand(5, 15) }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-gray-500 dark:text-gray-400">Ha</div>
                                <div class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ rand(100, 500) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-6 flex justify-center">
                        <div class="inline-flex items-center px-4 py-2 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-xl border border-emerald-200 dark:border-emerald-700 group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 transition-all duration-300 transform group-hover:scale-105">
                            <span class="text-sm font-medium">Kelola Menu</span>
                            <x-heroicon-m-arrow-right class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Pagination or Load More (if needed) -->
        @if($this->afdelings->count() > 10)
        <div class="mt-12 text-center">
            <button class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium rounded-xl shadow-lg hover:shadow-xl border border-gray-200 dark:border-gray-600 hover:border-emerald-300 dark:hover:border-emerald-500 transition-all duration-300">
                <x-heroicon-m-arrow-down class="w-5 h-5 mr-2" />
                Muat Lebih Banyak
            </button>
        </div>
        @endif
    @endif

    <!-- Floating Action Button (Mobile) -->
    <div class="fixed bottom-6 right-6 lg:hidden z-50">
        <button class="w-14 h-14 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 flex items-center justify-center">
            <x-heroicon-m-plus class="w-6 h-6" />
        </button>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="text-center">
            <div class="w-16 h-16 border-4 border-emerald-200 border-t-emerald-600 rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-gray-600 dark:text-gray-400">Memuat data afdeling...</p>
        </div>
    </div>

    <!-- Include Modern JavaScript -->
    <script src="{{ asset('js/afdeling-modern.js') }}" defer></script>
    
    <!-- Additional Interactive Features -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add tabindex to cards for keyboard navigation
            const cards = document.querySelectorAll('.afdeling-card');
            cards.forEach((card, index) => {
                card.setAttribute('tabindex', '0');
                card.setAttribute('role', 'button');
                card.setAttribute('aria-describedby', `afdeling-${index}-description`);
            });

            // Add keyboard support for buttons
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });

            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';

            // Initialize tooltips for action buttons
            const actionButtons = document.querySelectorAll('[aria-label]');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', showTooltip);
                button.addEventListener('mouseleave', hideTooltip);
            });

            // Performance optimization: Intersection Observer for animations
            if ('IntersectionObserver' in window) {
                const animationObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-in');
                        }
                    });
                }, { threshold: 0.1 });

                document.querySelectorAll('.group').forEach(card => {
                    animationObserver.observe(card);
                });
            }
        });

        function showTooltip(event) {
            const element = event.target;
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute z-50 px-2 py-1 text-xs text-white bg-gray-900 rounded shadow-lg -top-8 left-1/2 transform -translate-x-1/2 whitespace-nowrap';
            tooltip.textContent = element.getAttribute('aria-label');
            tooltip.id = 'tooltip';
            
            element.style.position = 'relative';
            element.appendChild(tooltip);
        }

        function hideTooltip(event) {
            const tooltip = event.target.querySelector('#tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        }

        // Add error handling for images
        document.addEventListener('error', function(e) {
            if (e.target.tagName === 'IMG') {
                e.target.style.display = 'none';
                const fallback = e.target.nextElementSibling;
                if (fallback) {
                    fallback.style.display = 'flex';
                }
            }
        }, true);

        // Add focus management for better accessibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', function() {
            document.body.classList.remove('keyboard-navigation');
        });
    </script>

    <!-- CSS for additional animations -->
    <style>
        .animate-in {
            animation: slideInUp 0.6s ease forwards;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .keyboard-navigation *:focus {
            outline: 2px solid #10b981 !important;
            outline-offset: 2px !important;
        }

        /* Improved loading states */
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        .dark .loading-skeleton {
            background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
            background-size: 200% 100%;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Responsive improvements */
        @media (max-width: 640px) {
            .text-4xl { font-size: 2rem; line-height: 2.5rem; }
            .text-lg { font-size: 1rem; line-height: 1.5rem; }
            .p-8 { padding: 1.5rem; }
            .gap-6 { gap: 1rem; }
        }

        /* Print styles */
        @media print {
            .fixed, .floating-animation, .pulse-ring {
                display: none !important;
            }
            .afdeling-card {
                break-inside: avoid;
                box-shadow: none !important;
                border: 1px solid #ccc !important;
            }
        }
    </style>
</x-filament-panels::page>