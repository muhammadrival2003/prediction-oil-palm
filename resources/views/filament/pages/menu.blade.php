<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <!-- Card Tahun Tanam -->
        <a href="{{ route('filament.admin.pages.tahun-tanam', ['afdeling_id' => $this->afdeling_id]) }}"
            class="group relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] border border-gray-200/50 dark:from-gray-800 dark:to-gray-900 dark:border-gray-700/50 hover:border-primary-400/30 dark:hover:border-primary-500/30">
            
            <!-- Header dengan teks kiri dan ikon kanan -->
            <div class="flex items-center justify-between mb-4">
                <!-- Text di kiri -->
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">
                    Tahun Tanam
                </h3>
                
                <!-- Icon di kanan -->
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-500/10 dark:bg-primary-400/10 group-hover:bg-primary-500/20 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <!-- Deskripsi -->
            <p class="text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-300 mb-4">
                Kelola Data Tahun Tanam
            </p>

            <!-- Footer dengan arrow -->
            <div class="mt-auto flex items-center text-sm font-medium text-primary-600 dark:text-primary-400 opacity-90 group-hover:opacity-100 transition-opacity duration-300">
                Buka menu
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>

        <!-- Card Pekerjaan -->
        <a href="{{ route('filament.admin.pages.menu-pekerjaan')}}"
            class="group relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] border border-gray-200/50 dark:from-gray-800 dark:to-gray-900 dark:border-gray-700/50 hover:border-emerald-400/30 dark:hover:border-emerald-500/30">
            
            <!-- Header dengan teks kiri dan ikon kanan -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                    Pekerjaan
                </h3>
                
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-500/10 dark:bg-emerald-400/10 group-hover:bg-emerald-500/20 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>

            <p class="text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-300 mb-4">
                Kelola Data Pekerjaan
            </p>

            <div class="mt-auto flex items-center text-sm font-medium text-emerald-600 dark:text-emerald-400 opacity-90 group-hover:opacity-100 transition-opacity duration-300">
                Buka menu
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>

        <!-- Card Hasil Produksi -->
        <a href="{{ url('/admin/chemis') }}"
            class="group relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] border border-gray-200/50 dark:from-gray-800 dark:to-gray-900 dark:border-gray-700/50 hover:border-amber-400/30 dark:hover:border-amber-500/30">
            
            <!-- Header dengan teks kiri dan ikon kanan -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors duration-300">
                    Hasil Produksi
                </h3>
                
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-500/10 dark:bg-amber-400/10 group-hover:bg-amber-500/20 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>

            <p class="text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-300 mb-4">
                Kelola Data Hasil Produksi
            </p>

            <div class="mt-auto flex items-center text-sm font-medium text-amber-600 dark:text-amber-400 opacity-90 group-hover:opacity-100 transition-opacity duration-300">
                Buka menu
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>
    </div>
</x-filament-panels::page>