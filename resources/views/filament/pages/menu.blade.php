<x-filament-panels::page>
    <!-- Header dengan Tombol Create -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Menu</h1>

        </div>
        <div class="flex space-x-2">
            <a href="{{ route('filament.admin.pages.afdeling') }}" class="inline-flex items-center text-primary-600 hover:text-primary-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <!-- Card Tahun Tanam -->
        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative">
            <!-- Glow effect -->
            <div x-show="hover" class="absolute inset-0 bg-primary-500/10 dark:bg-primary-400/10 rounded-2xl blur-lg scale-105 -z-10 transition-all duration-500"></div>

            <a href="{{ route('filament.admin.pages.tahun-tanam', ['afdeling_id' => $this->afdeling_id]) }}"
                class="group relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:scale-[1.02] border border-gray-200/50 dark:from-gray-800 dark:to-gray-900 dark:border-gray-700/50 hover:border-primary-400/30 dark:hover:border-primary-500/30">

                <!-- Animated gradient overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 via-primary-500/10 to-primary-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"
                    :style="`background-position: ${hover ? '100% 100%' : '0% 0%'};`"></div>

                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-500"
                        :style="`transform: translateY(${hover ? '-5px' : '0'});`">
                        Tahun Tanam
                    </h3>

                    <!-- Animated icon -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-500/10 dark:bg-primary-400/10 group-hover:bg-primary-500/20 transition-all duration-500"
                        :class="{'rotate-12': hover}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 dark:text-primary-400 transition-transform duration-500"
                            :class="{'scale-125': hover}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <!-- Content with staggered animation -->
                <div class="space-y-3">
                    <p class="text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-500 delay-75"
                        :style="`transform: translateY(${hover ? '-3px' : '0'});`">
                        Kelola Data Tahun Tanam
                    </p>
                </div>

                <!-- Animated footer -->
                <div class="mt-auto pt-4">
                    <div class="flex items-center text-sm font-medium text-primary-600 dark:text-primary-400 opacity-90 group-hover:opacity-100 transition-all duration-500"
                        :style="`transform: translateY(${hover ? '5px' : '0'});`">
                        <span class="relative overflow-hidden inline-block">
                            <span class="inline-block transition-transform duration-500"
                                :style="`transform: translateX(${hover ? '0' : '-100%'});`">
                                Buka menu
                            </span>
                            <span class="absolute left-0 top-0 inline-block transition-transform duration-500"
                                :style="`transform: translateX(${hover ? '100%' : '0%'});`">
                                Buka menu
                            </span>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-all duration-500"
                            :class="{'translate-x-2': hover}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card Pekerjaan -->
        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative">
            <div x-show="hover" class="absolute inset-0 bg-emerald-500/10 dark:bg-emerald-400/10 rounded-2xl blur-lg scale-105 -z-10 transition-all duration-500"></div>

            <a href="{{ route('filament.admin.pages.menu-pekerjaan', ['afdeling_id' => $this->afdeling_id]) }}"
                class="group relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:scale-[1.02] border border-gray-200/50 dark:from-gray-800 dark:to-gray-900 dark:border-gray-700/50 hover:border-emerald-400/30 dark:hover:border-emerald-500/30">

                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 via-emerald-500/10 to-emerald-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"
                    :style="`background-position: ${hover ? '100% 100%' : '0% 0%'};`"></div>

                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-500"
                        :style="`transform: translateY(${hover ? '-5px' : '0'});`">
                        Pekerjaan
                    </h3>

                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-500/10 dark:bg-emerald-400/10 group-hover:bg-emerald-500/20 transition-all duration-500"
                        :class="{'rotate-12': hover}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 dark:text-emerald-400 transition-transform duration-500"
                            :class="{'scale-125': hover}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-500 delay-75"
                        :style="`transform: translateY(${hover ? '-3px' : '0'});`">
                        Kelola Data Pekerjaan
                    </p>
                </div>

                <div class="mt-auto pt-4">
                    <div class="flex items-center text-sm font-medium text-emerald-600 dark:text-emerald-400 opacity-90 group-hover:opacity-100 transition-all duration-500"
                        :style="`transform: translateY(${hover ? '5px' : '0'});`">
                        <span class="relative overflow-hidden inline-block">
                            <span class="inline-block transition-transform duration-500"
                                :style="`transform: translateX(${hover ? '0' : '-100%'});`">
                                Buka menu
                            </span>
                            <span class="absolute left-0 top-0 inline-block transition-transform duration-500"
                                :style="`transform: translateX(${hover ? '100%' : '0%'});`">
                                Buka menu
                            </span>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-all duration-500"
                            :class="{'translate-x-2': hover}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card Hasil Produksi -->
        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative">
            <div x-show="hover" class="absolute inset-0 bg-amber-500/10 dark:bg-amber-400/10 rounded-2xl blur-lg scale-105 -z-10 transition-all duration-500"></div>

            <a href="{{ route('filament.admin.pages.blok-produksi', ['afdeling_id' => $this->afdeling_id]) }}"
                class="group relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:scale-[1.02] border border-gray-200/50 dark:from-gray-800 dark:to-gray-900 dark:border-gray-700/50 hover:border-amber-400/30 dark:hover:border-amber-500/30">

                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 via-amber-500/10 to-amber-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"
                    :style="`background-position: ${hover ? '100% 100%' : '0% 0%'};`"></div>

                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors duration-500"
                        :style="`transform: translateY(${hover ? '-5px' : '0'});`">
                        Hasil Produksi
                    </h3>

                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-500/10 dark:bg-amber-400/10 group-hover:bg-amber-500/20 transition-all duration-500"
                        :class="{'rotate-12': hover}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600 dark:text-amber-400 transition-transform duration-500"
                            :class="{'scale-125': hover}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-500 delay-75"
                        :style="`transform: translateY(${hover ? '-3px' : '0'});`">
                        Kelola Data Hasil Produksi
                    </p>
                </div>

                <div class="mt-auto pt-4">
                    <div class="flex items-center text-sm font-medium text-amber-600 dark:text-amber-400 opacity-90 group-hover:opacity-100 transition-all duration-500"
                        :style="`transform: translateY(${hover ? '5px' : '0'});`">
                        <span class="relative overflow-hidden inline-block">
                            <span class="inline-block transition-transform duration-500"
                                :style="`transform: translateX(${hover ? '0' : '-100%'});`">
                                Buka menu
                            </span>
                            <span class="absolute left-0 top-0 inline-block transition-transform duration-500"
                                :style="`transform: translateX(${hover ? '100%' : '0%'});`">
                                Buka menu
                            </span>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-all duration-500"
                            :class="{'translate-x-2': hover}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-filament-panels::page>