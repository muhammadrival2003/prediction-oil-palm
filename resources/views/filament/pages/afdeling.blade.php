<x-filament-panels::page>
    <!-- Bradcrumb -->
    <x-filament::breadcrumbs :breadcrumbs="[
    '/admin/afdeling' => 'Afdeling',
    ]" />
    
    <!-- Enhanced Header with Gradient Background -->
    <div class="bg-gradient-to-r from-emerald-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-xl p-6 mb-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">AFDELING</h1>
                <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-1">
                    Pilih menu untuk mengelola data afdeling
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
        @foreach($afdelings as $afdeling)
        <div
            x-data="{ hover: false }"
            @mouseenter="hover = true"
            @mouseleave="hover = false"
            class="relative group">

            <!-- Gradient glow effect -->
            <div
                x-show="hover"
                class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-emerald-600/10 rounded-2xl blur-xl scale-105 -z-10 transition-all duration-500"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-105"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-105"
                x-transition:leave-end="opacity-0 scale-95">
            </div>

            <a
                href="{{ route('filament.admin.pages.afdeling.menu', ['afdeling_id' => $afdeling->id]) }}"
                class="relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white via-emerald-50 to-white dark:from-gray-800 dark:via-emerald-900/20 dark:to-gray-800 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-2 border border-gray-200/70 dark:border-gray-700/50 hover:border-emerald-300 dark:hover:border-emerald-500/50">

                <!-- Animated background pattern -->
                <div class="absolute inset-0 opacity-5 group-hover:opacity-10 transition-opacity duration-500">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjYiPgo8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSI2IiBmaWxsPSIjMDAwMDAwIiBvcGFjaXR5PSIwLjA1Ij48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDZMNiAwWiIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZT0iIzEwYjk4MSIgb3BhY2l0eT0iMC4zIj48L3BhdGg+Cjwvc3ZnPg==')]"></div>
                </div>

                <!-- Icon container with gradient -->
                <div class="mb-5 flex justify-center">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/80 dark:to-emerald-800/80 shadow-sm group-hover:shadow-md group-hover:from-emerald-200 group-hover:to-emerald-300 dark:group-hover:from-emerald-800 dark:group-hover:to-emerald-700 transition-all duration-500">
                        @if($afdeling->image_url)
                        <img
                            src="{{ $afdeling->image_url }}"
                            alt="{{ $afdeling->nama }}"
                            class="w-12 h-12 object-cover rounded-lg transition-transform duration-500 group-hover:scale-110 group-hover:rotate-2"
                            loading="lazy">
                        @else
                        <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-white/80 dark:bg-gray-800/80">
                            <x-heroicon-o-map
                                class="w-8 h-8 text-emerald-600 dark:text-emerald-400 group-hover:text-emerald-700 dark:group-hover:text-emerald-300 transition-colors duration-500" />
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-grow text-center space-y-3 z-10">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-500">
                        {{ $afdeling->nama }}
                    </h3>

                    @if($afdeling->description)
                    <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                        {{ $afdeling->description }}
                    </p>
                    @endif
                </div>

                <!-- Footer with animated button -->
                <div class="mt-6 flex justify-center z-10">
                    <div class="relative overflow-hidden rounded-lg">
                        <!-- Button background (hidden until hover) -->
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <!-- Button content -->
                        <div class="relative px-4 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm group-hover:bg-transparent transition-all duration-300">
                            <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400 group-hover:text-white transition-colors duration-300 flex items-center">
                                <span>Kelola Menu</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Corner accent -->
                <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 dark:bg-emerald-400/5 transform rotate-45 origin-bottom-left translate-x-1/2 -translate-y-1/2 transition-all duration-500 group-hover:bg-emerald-500/10 dark:group-hover:bg-emerald-400/10"></div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</x-filament-panels::page>