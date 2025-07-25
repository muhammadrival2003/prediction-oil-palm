<x-filament::page>
    <!-- Bradcrumb -->
    <x-filament::breadcrumbs :breadcrumbs="[
    '/admin/afdeling' => 'Afdeling',
    '/admin/afdeling/menu' => 'Menu',
    '#' => 'Blok Produksi',
    ]" />

    <div class="space-y-8">
        <!-- Header -->
        <x-page-header
            title="Blok Produksi"
            subtitle="Pilih Blok untuk mengelola Hasil Produksi"
            :back-url="route('filament.admin.pages.afdeling.menu', ['afdeling_id' => $this->afdeling_id])" />

        <!-- Blok Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($bloks as $blok)
            <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" class="relative group">
                <!-- Glow effect -->
                <div x-show="hover" class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-emerald-600/10 rounded-2xl blur-xl scale-105 -z-10 transition-all duration-500"></div>

                <a href="{{ route('filament.admin.pages.hasil-produksi', ['blok_id' => $blok->id, 'afdeling_id' => $this->afdeling_id]) }}"
                    class="relative flex flex-col h-full overflow-hidden rounded-2xl bg-gradient-to-br from-white via-emerald-50 to-white dark:from-gray-800 dark:via-emerald-900/20 dark:to-gray-800 p-6 shadow-lg transition-all duration-500 hover:shadow-xl hover:-translate-y-1 border border-gray-200/70 dark:border-gray-700/50 hover:border-emerald-300 dark:hover:border-emerald-500/50">

                    <!-- Animated background pattern -->
                    <div class="absolute inset-0 opacity-5 group-hover:opacity-10 transition-opacity duration-500">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjYiPgo8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSI2IiBmaWxsPSIjMDAwMDAwIiBvcGFjaXR5PSIwLjA1Ij48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDZMNiAwWiIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZT0iIzEwYjk4MSIgb3BhY2l0eT0iMC4zIj48L3BhdGg+Cjwvc3ZnPg==')]"></div>
                    </div>

                    <!-- Header -->
                    <div class="flex items-start justify-between mb-4 z-10">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                            {{ $blok->nama_blok }}
                        </h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                            {{ $blok->tahunTanam->tahun_tanam }}
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="space-y-3 z-10">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors duration-300">
                            <svg class="w-4 h-4 mr-2 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Luas: {{ $blok->luas_lahan }} ha</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors duration-300">
                            <span>Jumlah Data: {{ $blok->hasilProduksis->count() }}</span>
                        </div>
                    </div>

                    <!-- Footer with animated button -->
                    <div class="mt-auto pt-4 z-10">
                        <div class="inline-flex items-center text-sm font-medium text-emerald-600 dark:text-emerald-400 group-hover:text-emerald-700 dark:group-hover:text-emerald-300 transition-colors duration-300">
                            <span>Lihat Produksi</span>
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
            @empty
            <div class="col-span-full">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50 p-8 text-center">
                    <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Tidak ada data blok</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada blok produksi yang terdaftar.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</x-filament::page>