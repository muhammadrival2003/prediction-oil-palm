<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
        @foreach($afdelings as $afdeling)
        <div 
            x-data="{ hover: false }"
            @mouseenter="hover = true" 
            @mouseleave="hover = false"
            class="relative"
        >
            <!-- Glow effect on hover -->
            <div 
                x-show="hover"
                class="absolute inset-0 bg-primary-500/10 dark:bg-primary-400/10 rounded-2xl blur-lg scale-105 -z-10 transition-all duration-500"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-105"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-105"
                x-transition:leave-end="opacity-0 scale-95"
            ></div>

            <a 
                href="{{ route('filament.admin.pages.afdeling.menu', ['afdeling_id' => $afdeling->id]) }}" 
                class="group relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:scale-[1.02] border border-gray-200/50 dark:from-gray-800 dark:to-gray-900 dark:border-gray-700/50 hover:border-primary-400/30 dark:hover:border-primary-500/30"
            >
                <!-- Animated gradient overlay -->
                <div 
                    class="absolute inset-0 bg-gradient-to-br from-primary-500/5 via-primary-500/10 to-primary-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"
                ></div>

                <!-- Image/Icon with floating animation -->
                <div class="mb-5 flex justify-center">
                    <div 
                        class="p-4 rounded-full bg-gradient-to-br from-primary-100/80 to-primary-200/80 dark:from-primary-800/80 dark:to-primary-900/80 group-hover:from-primary-100 group-hover:to-primary-200 dark:group-hover:from-primary-700 dark:group-hover:to-primary-800 transition-all duration-500 group-hover:shadow-md"
                        :class="{ 'animate-bounce': hover }"
                    >
                        <!-- Dynamic image with fallback -->
                        @if($afdeling->image_url)
                            <img 
                                src="{{ $afdeling->image_url }}" 
                                alt="{{ $afdeling->nama }}"
                                class="w-10 h-10 object-cover rounded-full transition-transform duration-500 group-hover:scale-110"
                                loading="lazy"
                            >
                        @else
                            <div class="w-10 h-10 flex items-center justify-center">
                                <x-heroicon-o-map 
                                    class="w-6 h-6 text-primary-600 dark:text-primary-300 group-hover:text-primary-700 dark:group-hover:text-primary-200 transition-colors duration-500" 
                                />
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Content with staggered animation -->
                <div class="flex-grow text-center space-y-3">
                    <h3 
                        class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-500"
                        :style="`transform: translateY(${hover ? '-5px' : '0'});`"
                    >
                        {{ $afdeling->nama }}
                    </h3>
                    <p 
                        class="mt-2 text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-500 delay-75"
                        :style="`transform: translateY(${hover ? '-3px' : '0'});`"
                    >
                        Kelola Data {{ $afdeling->nama }}
                    </p>
                </div>

                <!-- Animated arrow indicator with trail effect -->
                <div 
                    class="mt-5 flex items-center justify-center text-sm font-medium text-primary-600 dark:text-primary-400 opacity-90 group-hover:opacity-100 transition-all duration-500"
                    :style="`transform: translateY(${hover ? '5px' : '0'});`"
                >
                    <span class="relative overflow-hidden inline-block">
                        <span 
                            class="inline-block transition-transform duration-500"
                            :style="`transform: translateX(${hover ? '0' : '-100%'});`"
                        >
                            Akses Menu
                        </span>
                        <span 
                            class="absolute left-0 top-0 inline-block transition-transform duration-500"
                            :style="`transform: translateX(${hover ? '100%' : '0%'});`"
                        >
                            Akses Menu
                        </span>
                    </span>
                    <svg 
                        xmlns="http://www.w3.org/2000/svg" 
                        class="ml-2 h-4 w-4 transition-all duration-500"
                        :class="{ 'translate-x-2': hover }"
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>

                <!-- Subtle animated background pattern -->
                <div 
                    class="absolute bottom-0 right-0 w-24 h-24 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjYiPgo8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSI2IiBmaWxsPSIjZmZmIj48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDZMNiAwWiIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZT0iI2RkZCI+PC9wYXRoPgo8L3N2Zz4=')] opacity-10 dark:opacity-5 group-hover:opacity-20 dark:group-hover:opacity-10 transition-all duration-500"
                    :style="`background-position: ${hover ? '100% 100%' : '0% 0%'};`"
                ></div>
            </a>
        </div>
        @endforeach
    </div>
</x-filament-panels::page>