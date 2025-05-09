<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-2">
        <!-- Card Tahun Tanam -->
        <a href="{{ route('filament.admin.pages.tahun-tanam', ['afdeling_id' => $this->afdeling_id]) }}"
            class="group relative block overflow-hidden rounded-xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">

            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400">
                Tahun Tanam
            </h3>

            <!-- Description -->
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Kelola Data Tahun Tanam
            </p>

            <!-- Arrow indicator -->
            <div class="mt-4 flex items-center text-sm font-medium text-primary-600 dark:text-primary-400">
                Buka menu
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>

        <!-- Card Pekerjaan -->
        <a href="{{ url('/admin/chemis') }}"
            class="group relative block overflow-hidden rounded-xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">

            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400">
                Pekerjaan
            </h3>

            <!-- Description -->
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Kelola Data Pekerjaan
            </p>

            <!-- Arrow indicator -->
            <div class="mt-4 flex items-center text-sm font-medium text-primary-600 dark:text-primary-400">
                Buka menu
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>

        <!-- Card Hasil Produksi -->
        <a href="{{ url('/admin/chemis') }}"
            class="group relative block overflow-hidden rounded-xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">

            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400">
                Hasil Produksi
            </h3>

            <!-- Description -->
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Kelola Data Hasil Produksi
            </p>

            <!-- Arrow indicator -->
            <div class="mt-4 flex items-center text-sm font-medium text-primary-600 dark:text-primary-400">
                Buka menu
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>
    </div>
</x-filament-panels::page>