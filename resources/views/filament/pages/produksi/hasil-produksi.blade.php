<x-filament::page>
    <div class="space-y-8">
        <!-- Enhanced Header with Gradient Background -->
        <div class="bg-gradient-to-r from-emerald-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Hasil Produksi</h1>
                    <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-1">
                        Blok {{ $blokId }} - Kelola data hasil produksi
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('filament.admin.pages.blok-produksi', ['afdeling_id' => $afdeling_id]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors duration-300 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                    <x-filament::button
                        wire:click="openCreateModal"
                        icon="heroicon-o-plus"
                        color="emerald"
                        class="shadow-sm">
                        Tambah Data Baru
                    </x-filament::button>
                </div>
            </div>
        </div>

        @if($hasilProduksis->isEmpty())
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50 p-8 text-center">
            <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Data hasil produksi kosong</h3>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada data hasil produksi untuk blok ini.</p>
            <x-filament::button
                wire:click="openCreateModal"
                icon="heroicon-o-plus"
                color="emerald"
                class="mt-6">
                Tambah Data Produksi
            </x-filament::button>
        </div>
        @else
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Rencana</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ number_format($hasilProduksis->sum('rencana_produksi'), 0, ',', '.') }} kg
                </p>
            </div>
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-emerald-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Realisasi</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ number_format($hasilProduksis->sum('realisasi_produksi'), 0, ',', '.') }} kg
                </p>
            </div>
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-amber-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Selisih</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ number_format($hasilProduksis->sum('realisasi_produksi') - $hasilProduksis->sum('rencana_produksi'), 0, ',', '.') }} kg
                </p>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Rencana (kg)
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Realisasi (kg)
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Selisih
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($hasilProduksis as $hasil)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($hasil->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ number_format($hasil->rencana_produksi, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ number_format($hasil->realisasi_produksi, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm {{ ($hasil->realisasi_produksi - $hasil->rencana_produksi) >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ number_format($hasil->realisasi_produksi - $hasil->rencana_produksi, 0, ',', '.') }} kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $selisih = $hasil->realisasi_produksi - $hasil->rencana_produksi;
                                    $status = $selisih >= 0 ? 'Terpenuhi' : 'Belum Terpenuhi';
                                    $color = $selisih >= 0 ? 'emerald' : 'red';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 text-{{ $color }}-800 dark:text-{{ $color }}-400">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex space-x-2 justify-end">
                                    <x-filament::button
                                        wire:click="edit({{ $hasil->id }})"
                                        wire:loading.attr="disabled"
                                        size="sm"
                                        class="bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors duration-300 shadow-sm"
                                        >
                                        Edit
                                    </x-filament::button>

                                    <x-filament::button
                                        wire:click="confirmDelete({{ $hasil->id }})"
                                        wire:loading.attr="disabled"
                                        size="sm"
                                        color="danger"
                                        >
                                        Delete
                                    </x-filament::button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Form Modal -->
        <x-filament::modal id="form-modal" wire:model="isFormModalOpen">
            <x-slot name="heading">
                <div class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $editMode ? 'Edit Data Produksi' : 'Tambah Data Produksi' }}
                </div>
            </x-slot>

            <div class="space-y-4">
                {{ $this->form }}
            </div>

            <x-slot name="footer">
                <div class="flex justify-end space-x-3">
                    <x-filament::button
                        color="gray"
                        wire:click="closeModal"
                        class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        Batal
                    </x-filament::button>

                    @if($editMode)
                    <x-filament::button
                        color="emerald"
                        wire:click="update"
                        wire:loading.attr="disabled"
                        class="hover:bg-emerald-600 dark:hover:bg-emerald-500">
                        <span wire:loading.remove>Simpan Perubahan</span>
                        <span wire:loading>Menyimpan...</span>
                    </x-filament::button>
                    @else
                    <x-filament::button
                        color="emerald"
                        wire:click="store"
                        wire:loading.attr="disabled"
                        class="hover:bg-emerald-600 dark:hover:bg-emerald-500">
                        <span wire:loading.remove>Tambah Data</span>
                        <span wire:loading>Menyimpan...</span>
                    </x-filament::button>
                    @endif
                </div>
            </x-slot>
        </x-filament::modal>

        <!-- Delete Confirmation Modal -->
        <x-filament::modal id="delete-modal" wire:model="isDeleteModalOpen">
            <x-slot name="heading">
                <div class="text-lg font-semibold text-gray-900 dark:text-white">
                    Konfirmasi Hapus Data
                </div>
            </x-slot>

            <div class="space-y-4">
                <p class="text-gray-700 dark:text-gray-300">Apakah Anda yakin ingin menghapus data produksi ini?</p>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end space-x-3">
                    <x-filament::button
                        color="gray"
                        wire:click="closeDeleteModal"
                        class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        Batal
                    </x-filament::button>

                    <x-filament::button
                        color="danger"
                        wire:click="delete"
                        wire:loading.attr="disabled"
                        class="hover:bg-red-600 dark:hover:bg-red-500">
                        <span wire:loading.remove>Hapus</span>
                        <span wire:loading>Menghapus...</span>
                    </x-filament::button>
                </div>
            </x-slot>
        </x-filament::modal>
    </div>
</x-filament::page>