
<x-filament::page wire:navigate>
    <x-filament::card class="!rounded-xl">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Tahun Tanam
                </h2>
                <div>
                    <x-filament::button
                        icon="heroicon-o-arrow-left"
                        size="sm"
                        color="gray"
                        tag="a"
                        href="{{ route('filament.admin.pages.menu', ['afdeling_id' => $this->afdeling_id]) }}">
                        Kembali
                    </x-filament::button>
                    <x-filament::button
                        icon="heroicon-o-plus"
                        size="sm"
                        tag="a"
                        href="{{ route('filament.admin.resources.tahun-tanams.create', ['afdeling_id' => $this->afdeling_id]) }}">
                        Tambah Tahun
                    </x-filament::button>
                </div>
            </div>

            <!-- Statistik -->
            <div class="mt-6 pb-6 border-b mb-6 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <x-filament::card class="!bg-blue-50 dark:!bg-blue-900/50 !border-blue-200 dark:!border-blue-800">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-800">
                            <x-heroicon-o-calendar class="h-6 w-6 text-blue-600 dark:text-blue-300" />
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun Tanam</h4>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $totalTahunTanam }}</p>
                        </div>
                    </div>
                </x-filament::card>

                <x-filament::card class="!bg-green-50 dark:!bg-green-900/50 !border-green-200 dark:!border-green-800">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-800">
                            <x-heroicon-o-map-pin class="h-6 w-6 text-green-600 dark:text-green-300" />
                        </div>
                        <div class="w-full">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Blok</h4>
                            <div class="w-full flex justify-between">
                                <p class="text-2xl font-bold text-green-600 dark:text-green-300">{{ $totalBlok }}</p>
                            </div>
                        </div>
                    </div>
                </x-filament::card>

                <x-filament::card class="!bg-green-50 dark:!bg-green-900/50 !border-green-200 dark:!border-green-800">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-800">
                            <x-heroicon-o-map-pin class="h-6 w-6 text-green-600 dark:text-green-300" />
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pokok</h4>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-300">{{ $totalPokok }}</p>
                        </div>
                    </div>
                </x-filament::card>
            </div>

            <!-- Data Tahun Tanam -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($tahunTanams as $tahun)
                <div class="relative group bg-gradient-to-br rounded-lg border overflow-hidden transition-all duration-300 hover:scale-[1.02] shadow-sm hover:shadow-lg cursor-pointer"
                    onclick="window.location.href='{{ route('filament.admin.pages.tahun-tanam-blok', ['tahun_tanam_id' => $tahun->id, 'afdeling_id' => $this->afdeling_id]) }}'">
                    <!-- BG Image Card -->
                    <!-- <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=500')] opacity-20 group-hover:opacity-30 transition-opacity"></div> -->
                    <div class="relative p-6">
                        <div class="flex justify-between items-start">
                            <div class="w-full text-center">
                                <!-- Text Tahun Tanam -->
                                <!-- <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-dark dark:bg-{{ $this->getColor($tahun) }}-800 dark:text-{{ $this->getColor($tahun) }}-100 mb-2">
                                    {{ $this->getStatus($tahun) }}
                                </span> -->
                                <!-- <span class="inline-block px-3 py-1 text-xs font-semibol text-dark dark:bg-{{ $this->getColor($tahun) }}-800 dark:text-{{ $this->getColor($tahun) }}-100 mb-2">
                                    {{ $this->getStatus($tahun) }}
                                </span> -->
                                <h3 class="text-2xl font-bold text-{{ $this->getColor($tahun) }}-800 dark:text-{{ $this->getColor($tahun) }}-100">{{ $tahun->tahun_tanam }}</h3>

                            </div>
                            <span class="text-4xl text-{{ $this->getColor($tahun) }}-300 dark:text-{{ $this->getColor($tahun) }}-400">
                                <!-- {{ $this->getIcon($tahun) }} -->
                            </span>
                        </div>
                        <!-- Description -->
                        <!-- <p class="mt-3 text-{{ $this->getColor($tahun) }}-700 dark:text-{{ $this->getColor($tahun) }}-200">
                            {{ $this->getDescription($tahun) }}
                        </p> -->
                        <div class="mt-3 pt-4 border-t border-dark dark:border-{{ $this->getColor($tahun) }}-700 flex justify-center items-center">
                            <span class="inline-block px-5 py-1 text-xs font-semibold rounded-full bg-gray-100  text-dark dark:bg-{{ $this->getColor($tahun) }}-800 dark:text-{{ $this->getColor($tahun) }}-100">
                                {{ $tahun->bloks_count }} Blok
                            </span>
                        </div>
                        <!-- Tombol delete dipindahkan keluar dari tag <a> -->
                        <div class="absolute top-2 right-2 z-20">
                            <button
                                wire:click.stop="$dispatch('open-modal', { id: 'confirm-delete-{{ $tahun->id }}' })"
                                class="p-1.5 hover:bg-red-600 text-red-500 hover:text-white rounded-full"
                                title="Hapus Tahun Tanam">
                                <x-heroicon-o-trash class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
                <div class="absolute">
                    <x-filament::modal alignment="center" id="confirm-delete-{{ $tahun->id }}" heading="Hapus?">
                        <x-slot name="description">
                            Apakah anda yakin ingin menghapus data Tahun Tanam {{ $tahun->tahun_tanam }}
                        </x-slot>
                        <x-slot name="footerActions">
                            <div class="flex justify-center space-x-2 w-full"> <!-- Tambah div wrapper -->
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
        </div>
    </x-filament::card>
</x-filament::page>