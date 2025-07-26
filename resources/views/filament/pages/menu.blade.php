<x-filament-panels::page>
    <!-- Bradcrumb -->
    <x-filament::breadcrumbs :breadcrumbs="[
    '/admin/afdeling' => 'Afdeling',
    '#' => 'Menu',
    ]" />

    <!-- Enhanced Header with Gradient Background -->
    <div class="bg-gradient-to-r from-emerald-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-xl p-6 mb-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Menu</h1>
                <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-1">
                    Pilih menu untuk mengelola data Afdeling  {{ $this->afdeling_id }}
                </p>
            </div>
            <div>
                <a href="{{ route('filament.admin.pages.afdeling') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Card Grid with Enhanced Design -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <!-- Card Tahun Tanam -->
        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative group">
            <!-- Glow effect -->
            <div x-show="hover" class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-emerald-600/10 rounded-2xl blur-xl scale-105 -z-10 transition-all duration-500"></div>

            <a href="{{ route('filament.admin.pages.tahun-tanam', ['afdeling_id' => $this->afdeling_id]) }}"
               class="relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white via-emerald-50 to-white dark:from-gray-800 dark:via-emerald-900/20 dark:to-gray-800 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-1 border border-gray-200/70 dark:border-gray-700/50 hover:border-emerald-300 dark:hover:border-emerald-500/50">
                
                <!-- Animated background pattern -->
                <div class="absolute inset-0 opacity-5 group-hover:opacity-10 transition-opacity duration-500">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjYiPgo8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSI2IiBmaWxsPSIjMDAwMDAwIiBvcGFjaXR5PSIwLjA1Ij48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDZMNiAwWiIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZT0iIzEwYjk4MSIgb3BhY2l0eT0iMC4zIj48L3BhdGg+Cjwvc3ZnPg==')]"></div>
                </div>

                <!-- Header with icon -->
                <div class="flex items-center justify-between mb-4 z-10">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                        Tahun Tanam
                    </h3>
                    <div class="p-2 rounded-lg bg-emerald-100/50 dark:bg-emerald-900/30 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600 dark:text-emerald-400 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                

                <!-- Footer with animated button -->
                <div class="mt-auto z-10">
                    <div class="inline-flex items-center text-sm font-medium text-emerald-600 dark:text-emerald-400 group-hover:text-emerald-700 dark:group-hover:text-emerald-300 transition-colors duration-300">
                        <span>Buka Menu</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>

                <!-- Corner accent -->
                <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 dark:bg-emerald-400/5 transform rotate-45 origin-bottom-left translate-x-1/2 -translate-y-1/2 transition-all duration-500 group-hover:bg-emerald-500/10 dark:group-hover:bg-emerald-400/10"></div>
                </div>
            </a>
        </div>

        <!-- Karyawan Lapangan -->
        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative group">
            <div x-show="hover" class="absolute inset-0 bg-emerald-400/20 rounded-2xl blur-xl scale-105 -z-10 transition-all duration-500"></div>

            <a href="{{ route('filament.admin.resources.karyawan-lapangans.index', ['afdeling_id' => $this->afdeling_id]) }}"
               class="relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white via-emerald-50 to-white dark:from-gray-800 dark:via-emerald-900/20 dark:to-gray-800 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-1 border border-gray-200/70 dark:border-gray-700/50 hover:border-emerald-300 dark:hover:border-emerald-500/50">
                
                <div class="absolute inset-0 opacity-5 group-hover:opacity-10 transition-opacity duration-500">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjYiPgo8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSI2IiBmaWxsPSIjMDAwMDAwIiBvcGFjaXR5PSIwLjA1Ij48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDZMNiAwWiIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZT0iIzEwYjk4MSIgb3BhY2l0eT0iMC4zIj48L3BhdGg+Cjwvc3ZnPg==')]"></div>
                </div>

                <div class="flex items-center justify-between mb-4 z-10">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                        Karyawan Lapangan
                    </h3>
                    <div class="p-2 rounded-lg bg-emerald-100/50 dark:bg-emerald-900/30 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600 dark:text-emerald-400 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>

                <div class="mt-auto z-10">
                    <div class="inline-flex items-center text-sm font-medium text-emerald-600 dark:text-emerald-400 group-hover:text-emerald-700 dark:group-hover:text-emerald-300 transition-colors duration-300">
                        <span>Buka Menu</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>

                <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 dark:bg-emerald-400/5 transform rotate-45 origin-bottom-left translate-x-1/2 -translate-y-1/2 transition-all duration-500 group-hover:bg-emerald-500/10 dark:group-hover:bg-emerald-400/10"></div>
                </div>
            </a>
        </div>

        <!-- Card Pekerjaan -->
        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative group">
            <div x-show="hover" class="absolute inset-0 bg-emerald-400/20 rounded-2xl blur-xl scale-105 -z-10 transition-all duration-500"></div>

            <a href="{{ route('filament.admin.pages.menu-pekerjaan', ['afdeling_id' => $this->afdeling_id]) }}"
               class="relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white via-emerald-50 to-white dark:from-gray-800 dark:via-emerald-900/20 dark:to-gray-800 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-1 border border-gray-200/70 dark:border-gray-700/50 hover:border-emerald-300 dark:hover:border-emerald-500/50">
                
                <div class="absolute inset-0 opacity-5 group-hover:opacity-10 transition-opacity duration-500">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjYiPgo8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSI2IiBmaWxsPSIjMDAwMDAwIiBvcGFjaXR5PSIwLjA1Ij48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDZMNiAwWiIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZT0iIzEwYjk4MSIgb3BhY2l0eT0iMC4zIj48L3BhdGg+Cjwvc3ZnPg==')]"></div>
                </div>

                <div class="flex items-center justify-between mb-4 z-10">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                        Pekerjaan
                    </h3>
                    <div class="p-2 rounded-lg bg-emerald-100/50 dark:bg-emerald-900/30 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600 dark:text-emerald-400 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>

                <div class="mt-auto z-10">
                    <div class="inline-flex items-center text-sm font-medium text-emerald-600 dark:text-emerald-400 group-hover:text-emerald-700 dark:group-hover:text-emerald-300 transition-colors duration-300">
                        <span>Buka Menu</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>

                <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 dark:bg-emerald-400/5 transform rotate-45 origin-bottom-left translate-x-1/2 -translate-y-1/2 transition-all duration-500 group-hover:bg-emerald-500/10 dark:group-hover:bg-emerald-400/10"></div>
                </div>
            </a>
        </div>

        <!-- Card Hasil Produksi -->
        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative group">
            <div x-show="hover" class="absolute inset-0 bg-emerald-400/20 rounded-2xl blur-xl scale-105 -z-10 transition-all duration-500"></div>

            <a href="{{ route('filament.admin.pages.blok-produksi', ['afdeling_id' => $this->afdeling_id]) }}"
               class="relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white via-emerald-50 to-white dark:from-gray-800 dark:via-emerald-900/20 dark:to-gray-800 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-1 border border-gray-200/70 dark:border-gray-700/50 hover:border-emerald-300 dark:hover:border-emerald-500/50">
                
                <div class="absolute inset-0 opacity-5 group-hover:opacity-10 transition-opacity duration-500">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjYiPgo8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSI2IiBmaWxsPSIjMDAwMDAwIiBvcGFjaXR5PSIwLjA1Ij48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDZMNiAwWiIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZT0iIzEwYjk4MSIgb3BhY2l0eT0iMC4zIj48L3BhdGg+Cjwvc3ZnPg==')]"></div>
                </div>

                <div class="flex items-center justify-between mb-4 z-10">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                        Hasil Produksi
                    </h3>
                    <div class="p-2 rounded-lg bg-emerald-100/50 dark:bg-emerald-900/30 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600 dark:text-emerald-400 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>

                <div class="mt-auto z-10">
                    <div class="inline-flex items-center text-sm font-medium text-emerald-600 dark:text-emerald-400 group-hover:text-emerald-700 dark:group-hover:text-emerald-300 transition-colors duration-300">
                        <span>Buka Menu</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>

                <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 dark:bg-emerald-400/5 transform rotate-45 origin-bottom-left translate-x-1/2 -translate-y-1/2 transition-all duration-500 group-hover:bg-emerald-500/10 dark:group-hover:bg-emerald-400/10"></div>
                </div>
            </a>
        </div>
    </div>
</x-filament-panels::page>