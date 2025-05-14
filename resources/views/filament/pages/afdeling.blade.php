<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4">
        @foreach($afdelings as $afdeling)
        <a href="{{ route('filament.admin.pages.menu', ['afdeling_id' => $afdeling->id]) }}" 
            class="group relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] border border-gray-200/50 dark:from-gray-800 dark:to-gray-900 dark:border-gray-700/50 hover:border-primary-400/30 dark:hover:border-primary-500/30">

            <!-- Gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-primary-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>

            <!-- Icon with pulse animation on hover -->
            <div class="mb-5 flex justify-center">
                <div class="p-3 rounded-full bg-primary-100/80 dark:bg-primary-800/80 group-hover:bg-primary-100 dark:group-hover:bg-primary-700 transition-colors duration-300 group-hover:animate-pulse">
                    <x-heroicon-o-map class="w-8 h-8 text-primary-600 dark:text-primary-300 group-hover:text-primary-700 dark:group-hover:text-primary-200 transition-colors duration-300" />
                </div>
            </div>

            <!-- Content -->
            <div class="flex-grow text-center">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">
                    {{ $afdeling->nama }}
                </h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-300">
                    Kelola Data {{ $afdeling->nama }}
                </p>
            </div>

            <!-- Animated arrow indicator -->
            <div class="mt-5 flex items-center justify-center text-sm font-medium text-primary-600 dark:text-primary-400 opacity-90 group-hover:opacity-100 translate-y-0 group-hover:translate-y-1 transition-all duration-300">
                Akses Menu
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>

            <!-- Subtle background pattern -->
            <div class="absolute bottom-0 right-0 w-24 h-24 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjYiPgo8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSI2IiBmaWxsPSIjZmZmIj48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDZMNiAwWiIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZT0iI2RkZCI+PC9wYXRoPgo8L3N2Zz4=')] opacity-10 dark:opacity-5 group-hover:opacity-20 dark:group-hover:opacity-10 transition-opacity duration-300"></div>
        </a>
        @endforeach
    </div>
</x-filament-panels::page>