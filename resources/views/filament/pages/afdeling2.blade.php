<x-filament::page>
    <x-filament::card class="!rounded-xl">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Pilih Tahun Tanam
                </h2>
                <x-filament::button
                    icon="heroicon-o-plus"
                    size="sm"
                    wire:click="$dispatch('openModal', { component: 'create-tahun-tanam-modal' })">
                    Tambah Tahun
                </x-filament::button>
            </div>

            <!-- Statistik -->
            <div class="mb-5 mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-filament::card class="!bg-blue-50 dark:!bg-blue-900/50 !border-blue-200 dark:!border-blue-800">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-800">
                            <x-heroicon-o-calendar class="h-6 w-6 text-blue-600 dark:text-blue-300" />
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tahun Tanam</h4>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">3</p>
                        </div>
                    </div>
                </x-filament::card>

                <x-filament::card class="!bg-green-50 dark:!bg-green-900/50 !border-green-200 dark:!border-green-800">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-800">
                            <x-heroicon-o-map-pin class="h-6 w-6 text-green-600 dark:text-green-300" />
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Blok</h4>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-300">30</p>
                        </div>
                    </div>
                </x-filament::card>

                <x-filament::card class="!bg-purple-50 dark:!bg-purple-900/50 !border-purple-200 dark:!border-purple-800">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-800">
                            <x-heroicon-o-chart-bar class="h-6 w-6 text-purple-600 dark:text-purple-300" />
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Produktivitas</h4>
                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-300">+15%</p>
                        </div>
                    </div>
                </x-filament::card>
            </div>

            <!-- Dummy Data Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="relative group bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg border border-blue-200 dark:border-blue-700 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=500')] opacity-20 group-hover:opacity-30 transition-opacity"></div>
                    <div class="relative p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 mb-2">
                                    Aktif
                                </span>
                                <h3 class="text-2xl font-bold text-blue-800 dark:text-blue-100">2023</h3>
                            </div>
                            <span class="text-4xl text-blue-300 dark:text-blue-400">🌱</span>
                        </div>
                        <p class="mt-3 text-blue-700 dark:text-blue-200">
                            Tanaman produktif dengan hasil panen meningkat 15%
                        </p>
                        <div class="mt-6 pt-4 border-t border-blue-200 dark:border-blue-700 flex justify-between items-center">
                            <span class="text-sm text-blue-600 dark:text-blue-300">12 Blok</span>
                            <x-filament::button
                                size="xs"
                                color="primary"
                                tag="a"
                                href="#"
                                icon="heroicon-o-arrow-right">
                                Lihat
                            </x-filament::button>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="relative group bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg border border-green-200 dark:border-green-700 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=500')] opacity-20 group-hover:opacity-30 transition-opacity"></div>
                    <div class="relative p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 mb-2">
                                    Selesai
                                </span>
                                <h3 class="text-2xl font-bold text-green-800 dark:text-green-100">2022</h3>
                            </div>
                            <span class="text-4xl text-green-300 dark:text-green-400">🌾</span>
                        </div>
                        <p class="mt-3 text-green-700 dark:text-green-200">
                            Tahun dengan curah hujan tinggi, hasil stabil
                        </p>
                        <div class="mt-6 pt-4 border-t border-green-200 dark:border-green-700 flex justify-between items-center">
                            <span class="text-sm text-green-600 dark:text-green-300">10 Blok</span>
                            <x-filament::button
                                size="xs"
                                color="success"
                                tag="a"
                                href="#"
                                icon="heroicon-o-arrow-right">
                                Lihat
                            </x-filament::button>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="relative group bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900 dark:to-amber-800 rounded-lg border border-amber-200 dark:border-amber-700 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=500')] opacity-20 group-hover:opacity-30 transition-opacity"></div>
                    <div class="relative p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-800 dark:text-amber-100 mb-2">
                                    Arsip
                                </span>
                                <h3 class="text-2xl font-bold text-amber-800 dark:text-amber-100">2021</h3>
                            </div>
                            <span class="text-4xl text-amber-300 dark:text-amber-400">🍂</span>
                        </div>
                        <p class="mt-3 text-amber-700 dark:text-amber-200">
                            Tahun pertama tanam, masa adaptasi tanaman
                        </p>
                        <div class="mt-6 pt-4 border-t border-amber-200 dark:border-amber-700 flex justify-between items-center">
                            <span class="text-sm text-amber-600 dark:text-amber-300">8 Blok</span>
                            <x-filament::button
                                size="xs"
                                color="warning"
                                tag="a"
                                href="#"
                                icon="heroicon-o-arrow-right">
                                Lihat
                            </x-filament::button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::page>