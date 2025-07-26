<x-filament::page>
    <!-- Bradcrumb -->
    <x-filament::breadcrumbs :breadcrumbs="[
    '/admin/afdeling' => 'Afdeling',
    '/admin/afdeling/menu' => 'Menu',
    '#' => 'Tahun Tanam',
    ]" />

    <!-- Enhanced Header with Gradient Background -->
    <div class="bg-gradient-to-r from-emerald-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-xl p-6 mb-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tahun Tanam</h1>
                <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-1">
                    Pilih Menu untuk mengelola Data Tahun Tanam
                </p>
            </div>
            <div>
                <a href="{{ route('filament.admin.pages.afdeling.menu',  ['afdeling_id' => $this->afdeling_id]) }}"
                    class="inline-flex items-center text-sm px-4 py-2 me-2 bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali
                </a>
                <x-filament::button
                    icon="heroicon-o-plus"
                    size="sm"
                    tag="a"
                    class="inline-flex items-center text-sm px-4 py-2"
                    href="{{ route('filament.admin.resources.tahun-tanams.create', ['afdeling_id' => $this->afdeling_id]) }}">
                    Tambah Tahun
                </x-filament::button>
            </div>
        </div>
    </div>

    <!-- Statistik Cards with Emerald Accents -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center space-x-4">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-800">
                    <x-heroicon-o-calendar class="h-6 w-6 text-blue-600 dark:text-blue-300" />
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun Tanam</p>
                    <p class="mt-1 text-2xl font-semibold text-blue-600 dark:text-blue-300">{{ $totalTahunTanam }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-emerald-500">
            <div class="flex items-center space-x-4">
                <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-800">
                    <x-heroicon-o-map-pin class="h-6 w-6 text-emerald-600 dark:text-emerald-300" />
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Blok</p>
                    <p class="mt-1 text-2xl font-semibold text-emerald-600 dark:text-emerald-300">{{ $totalBlok }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-amber-500">
            <div class="flex items-center space-x-4">
                <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-800">

                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pokok</p>
                    <p class="mt-1 text-2xl font-semibold text-amber-600 dark:text-amber-300">{{ $totalPokok }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Headers -->

    <!-- Enhanced Data Tahun Tanam Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($tahunTanams as $tahun)
        <div class="relative group bg-gradient-to-br from-white via-emerald-50 to-emerald-100 dark:from-gray-800 dark:via-emerald-900/20 dark:to-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-200/50 dark:border-gray-700/50 hover:border-emerald-300/50 dark:hover:border-emerald-500/50"
            onclick="window.location.href='{{ route('filament.admin.pages.tahun-tanam-blok', ['tahun_tanam_id' => $tahun->id, 'afdeling_id' => $this->afdeling_id]) }}'">

            <!-- Glow Effect on Hover -->
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-100/50 to-transparent dark:from-emerald-900/20 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

            <!-- Delete Button -->
            <div class="absolute top-0 right-0 p-2 z-10">
                <button
                    wire:click.stop="$dispatch('open-modal', { id: 'confirm-delete-{{ $tahun->id }}' })"
                    class="p-1.5 rounded-full backdrop-blur-sm hover:bg-red-100 dark:hover:bg-red-900/60 text-red-500/80 hover:text-red-600 dark:hover:text-red-300 transition-all duration-200 shadow-sm hover:shadow-md"
                    title="Hapus Tahun Tanam">
                    <x-heroicon-o-trash class="w-4 h-4" />
                </button>
            </div>

            <!-- Card Content -->
            <div class="p-6 relative z-0">
                <div class="flex flex-col items-center text-center">
                    <!-- Status Badge with Gradient -->
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-3 bg-gradient-to-r from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/70 text-emerald-800 dark:text-emerald-200 shadow-sm group-hover:shadow-md transition-shadow">
                        {{ $this->getStatus($tahun) }}
                    </span>

                    <!-- Tahun Tanam with Hover Effect -->
                    <h3 class="text-3xl font-bold text-emerald-600 dark:text-emerald-300 mb-2 group-hover:text-emerald-700 dark:group-hover:text-emerald-200 transition-colors">
                        {{ $tahun->tahun_tanam }}
                    </h3>

                    <!-- Icon with Pulse Animation -->
                    <div class="text-5xl text-emerald-400/50 dark:text-emerald-500/30 mb-3 group-hover:text-emerald-500/70 dark:group-hover:text-emerald-400/50 transition-colors duration-300">
                        <x-heroicon-o-calendar class="group-hover:scale-110 transition-transform duration-300" />
                    </div>

                    <!-- Blok Count with Enhanced Styling -->
                    <div class="w-full pt-3 border-t border-gray-200/70 dark:border-gray-600/50 group-hover:border-emerald-200/50 dark:group-hover:border-emerald-500/30 transition-colors">
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/40 dark:to-emerald-800/60 text-emerald-800 dark:text-emerald-200 text-sm font-medium shadow-sm group-hover:shadow-md group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800/70 transition-all">
                            <x-heroicon-o-document-text class="w-4 h-4 mr-1.5 text-emerald-600 dark:text-emerald-300" />
                            {{ $tahun->bloks_count }} Blok
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="absolute">
            <x-filament::modal alignment="center" id="confirm-delete-{{ $tahun->id }}" heading="Hapus?">
                <x-slot name="description">
                    Apakah anda yakin ingin menghapus data Tahun Tanam {{ $tahun->tahun_tanam }}
                </x-slot>
                <x-slot name="footerActions">
                    <div class="flex justify-center space-x-2 w-full">
                        <x-filament::button
                            class="text-xs"
                            color="danger"
                            wire:click="deleteTahunTanam({{ $tahun->id }})">
                            Ya
                        </x-filament::button>
                        <x-filament::button
                            class="text-xs"
                            color="gray"
                            wire:click="$dispatch('close-modal', { id: 'confirm-delete-{{ $tahun->id }}' })">
                            Batal
                        </x-filament::button>
                    </div>
                </x-slot>
            </x-filament::modal>
        </div>
        @endforeach
    </div>
</x-filament::page>