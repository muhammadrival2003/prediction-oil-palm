<x-filament::page>
    <div class="space-y-6">
        <!-- Header dengan Tombol Create -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Hasil Produksi</h1>
                <p class="text-gray-500">Blok {{ $blokId }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('filament.admin.pages.blok-produksi') }}" class="inline-flex items-center text-primary-600 hover:text-primary-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali
                </a>
                <x-filament::button
                    wire:click="openCreateModal"
                    icon="heroicon-o-plus"
                    color="primary"
                    class="">
                    Tambah Data Baru
                </x-filament::button>
            </div>
        </div>

        @if($hasilProduksis->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <div class="mx-auto h-12 w-12 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="mt-3 text-lg font-medium text-gray-900">Data tidak tersedia</h3>
            <p class="mt-1 text-gray-500">Belum ada hasil produksi untuk blok ini.</p>
            <x-filament::button
                wire:click="openCreateModal"
                icon="heroicon-o-plus"
                color="primary"
                class="mt-4">
                Tambah Data Baru
            </x-filament::button>
        </div>
        @else
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
                <p class="text-sm font-medium text-gray-500">Total Rencana Produksi</p>
                <p class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ number_format($hasilProduksis->sum('rencana_produksi'), 0, ',', '.') }} kg
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                <p class="text-sm font-medium text-gray-500">Total Realisasi Produksi</p>
                <p class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ number_format($hasilProduksis->sum('realisasi_produksi'), 0, ',', '.') }} kg
                </p>
            </div>
        </div>

        <!-- Table dengan Action Buttons -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rencana (kg)
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Realisasi (kg)
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Selisih
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($hasilProduksis as $hasil)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($hasil->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($hasil->rencana_produksi, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($hasil->realisasi_produksi, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm {{ ($hasil->realisasi_produksi - $hasil->rencana_produksi) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($hasil->realisasi_produksi - $hasil->rencana_produksi, 0, ',', '.') }} kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                $selisih = $hasil->realisasi_produksi - $hasil->rencana_produksi;
                                $status = $selisih >= 0 ? 'Terpenuhi' : 'Belum Terpenuhi';
                                $color = $selisih >= 0 ? 'green' : 'red';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex space-x-2 justify-end">
                                    <x-filament::button
                                        wire:click="edit({{ $hasil->id }})"
                                        wire:loading.attr="disabled"
                                        size="sm"
                                        color="warning"
                                        icon="heroicon-o-pencil">
                                    </x-filament::button>

                                    <x-filament::button
                                        wire:click="confirmDelete({{ $hasil->id }})"
                                        wire:loading.attr="disabled"
                                        size="sm"
                                        color="danger"
                                        icon="heroicon-o-trash">
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
    </div>

    <!-- Form Modal -->
    <x-filament::modal id="form-modal" wire:model="isFormModalOpen">
        <x-slot name="heading">
            {{ $editMode ? 'Edit Hasil Produksi' : 'Tambah Hasil Produksi' }}
        </x-slot>

        {{ $this->form }}

        <x-slot name="footer">
            <div class="flex justify-end space-x-2">
                <x-filament::button
                    color="secondary"
                    wire:click="closeModal">
                    Batal
                </x-filament::button>

                @if($editMode)
                <x-filament::button
                    color="primary"
                    wire:click="update"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading>Menyimpan...</span>
                </x-filament::button>
                @else
                <x-filament::button
                    color="primary"
                    wire:click="store"
                    wire:loading.attr="disabled">
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
            Konfirmasi Hapus Data
        </x-slot>

        <p class="text-gray-700">Apakah Anda yakin ingin menghapus data hasil produksi ini?</p>

        <x-slot name="footer">
            <div class="flex justify-end space-x-2">
                <x-filament::button
                    color="secondary"
                    wire:click="$set('isDeleteModalOpen', false)">
                    Batal
                </x-filament::button>

                <x-filament::button
                    color="danger"
                    wire:click="delete"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Hapus</span>
                    <span wire:loading>Menghapus...</span>
                </x-filament::button>
            </div>
        </x-slot>
    </x-filament::modal>
</x-filament::page>