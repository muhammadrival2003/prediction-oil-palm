<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
        @foreach($afdelings as $afdeling)
        <a href="{{ route('filament.admin.pages.menu', ['afdeling_id' => $afdeling->id]) }}" 
            class="group relative block overflow-hidden rounded-xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">

            <!-- Icon Afdeling -->
            <div class="mb-4 flex justify-center">
                <div class="p-3 rounded-full bg-primary-100 dark:bg-primary-800">
                    <x-heroicon-o-map class="w-8 h-8 text-primary-600 dark:text-primary-300" />
                </div>
            </div>

            <!-- Title -->
            <h3 class="text-lg font-semibold text-center text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400">
                {{ $afdeling->nama }}
            </h3>

            <!-- Description -->
            <p class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">
                Kelola Data {{ $afdeling->nama }}
            </p>

            <!-- Arrow indicator -->
            <div class="mt-4 flex items-center justify-center text-sm font-medium text-primary-600 dark:text-primary-400">
                Akses Menu
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>
        @endforeach
    </div>
</x-filament-panels::page>