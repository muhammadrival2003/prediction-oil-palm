<x-filament-panels::page>
    <!-- Bradcrumb -->
    <x-filament::breadcrumbs :breadcrumbs="[
    '/admin/afdeling' => 'Afdeling',
    '/admin/afdeling/menu' => 'Menu',
    '#' => 'Pekerjaan',
    ]" />

    <!-- Header -->
     <x-page-header 
        title="Menu Pekerjaan"
        subtitle="Kelola berbagai pekerjaan di Afdeling {{ $this->afdeling_id }}"
        :back-url="route('filament.admin.pages.afdeling.menu', ['afdeling_id' => $afdeling_id])"
    />

    <!-- Card Grid with Enhanced Design -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Card Rencana Pemupukan -->
        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative group">
            <!-- Glow effect -->
            <div x-show="hover" class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-emerald-600/10 rounded-2xl blur-xl scale-105 -z-10 transition-all duration-500"></div>

            <a href="{{ route('filament.admin.pages.blok-pemupukan', ['afdeling_id' => $this->afdeling_id]) }}"
               class="relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white via-emerald-50 to-white dark:from-gray-800 dark:via-emerald-900/20 dark:to-gray-800 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-1 border border-gray-200/70 dark:border-gray-700/50 hover:border-emerald-300 dark:hover:border-emerald-500/50">
                
                <!-- Animated background pattern -->
                <div class="absolute inset-0 opacity-5 group-hover:opacity-10 transition-opacity duration-500">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjYiPgo8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSI2IiBmaWxsPSIjMDAwMDAwIiBvcGFjaXR5PSIwLjA1Ij48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDZMNiAwWiIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZT0iIzEwYjk4MSIgb3BhY2l0eT0iMC4zIj48L3BhdGg+Cjwvc3ZnPg==')]"></div>
                </div>

                <!-- Header with icon -->
                <div class="flex items-center justify-between mb-4 z-10">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                        Rencana Pemupukan
                    </h3>
                    <div class="p-2 rounded-lg bg-emerald-100/50 dark:bg-emerald-900/30 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600 dark:text-emerald-400 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                        </svg>
                    </div>
                </div>

                <!-- Content -->
                <div class="mb-4 z-10">
                    <p class="text-gray-600 dark:text-gray-300 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors duration-300">
                        Rencana dan Realisasi Pemupukan sesuai dengan Blok Tanam
                    </p>
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

        <!-- You can add more cards here following the same pattern -->
        <!-- Example additional card -->
        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative group">
            <div x-show="hover" class="absolute inset-0 bg-emerald-400/20 rounded-2xl blur-xl scale-105 -z-10 transition-all duration-500"></div>

            <a href="#"
               class="relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white via-emerald-50 to-white dark:from-gray-800 dark:via-emerald-900/20 dark:to-gray-800 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-1 border border-gray-200/70 dark:border-gray-700/50 hover:border-emerald-300 dark:hover:border-emerald-500/50">
                
                <div class="absolute inset-0 opacity-5 group-hover:opacity-10 transition-opacity duration-500">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjYiPgo8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSI2IiBmaWxsPSIjMDAwMDAwIiBvcGFjaXR5PSIwLjA1Ij48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDZMNiAwWiIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZT0iIzEwYjk4MSIgb3BhY2l0eT0iMC4zIj48L3BhdGg+Cjwvc3ZnPg==')]"></div>
                </div>

                <div class="flex items-center justify-between mb-4 z-10">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                        Contoh Menu Lain
                    </h3>
                    <div class="p-2 rounded-lg bg-emerald-100/50 dark:bg-emerald-900/30 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600 dark:text-emerald-400 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>

                <div class="mb-4 z-10">
                    <p class="text-gray-600 dark:text-gray-300 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors duration-300">
                        Deskripsi contoh menu lainnya yang bisa ditambahkan
                    </p>
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