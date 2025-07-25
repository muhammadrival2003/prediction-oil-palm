<x-filament-panels::page>
    <!-- Bradcrumb -->
    <x-filament::breadcrumbs :breadcrumbs="[
    '/admin/afdeling' => 'Afdeling',
    '/admin/afdeling/menu' => 'Menu',
    '/admin/menu-pekerjaan' => 'Pekerjaan',
    '/admin/blok-pemupukan' => 'Blok Pemupukan',
    '#' => 'Data Pemupukan',
    ]" />
    <div class="space-y-6">
        <!-- Header -->
        <x-page-header
            title="Pemupukan"
            subtitle="Blok {{ $this->blok->nama_blok }} - Kelola data pemupukan"
            :back-url="route('filament.admin.pages.blok-pemupukan', ['afdeling_id' => $afdeling_id])" />

        @if($pemupukans->isEmpty())
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50 p-8 text-center">
            <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Data pemupukan kosong</h3>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada data pemupukan untuk blok ini.</p>
            <x-filament::button
                wire:click="openCreateModal"
                icon="heroicon-o-plus"
                color="emerald"
                class="mt-6">
                Tambah Data Pemupukan
            </x-filament::button>
        </div>
        @else
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Pokok</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ $this->blok->jumlah_pokok }} Pokok
                </p>
            </div>
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-emerald-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Dosis</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ number_format($pemupukans->sum('dosis'), 0, ',', '.') }} kg
                </p>
            </div>
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-amber-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Volume</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ number_format($pemupukans->sum('volume'), 2, ',', '.') }} kg
                </p>
            </div>
        </div>

        <x-filament::button
            wire:click="openCreateModal"
            icon="heroicon-o-plus"
            color="emerald"
            class="shadow-sm">
            Tambah Data Baru
        </x-filament::button>

        <!-- Tabel Data -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jenis Pupuk
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Dosis
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Volume (Kg)
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($pemupukans as $pemupukan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($pemupukan->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $pemupukan->jenisPupuk->nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ ucfirst($pemupukan->dosis) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ ucfirst($pemupukan->volume) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex space-x-2 justify-center">
                                    <x-filament::button
                                        wire:click="edit({{ $pemupukan->id }})"
                                        wire:loading.attr="disabled"
                                        size="sm"
                                        class="bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors duration-300 shadow-sm">
                                        Edit
                                    </x-filament::button>

                                    <x-filament::button
                                        wire:click="confirmDelete({{ $pemupukan->id }})"
                                        wire:loading.attr="disabled"
                                        size="sm"
                                        color="danger">
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
                    {{ $editMode ? 'Edit Data Pemupukan' : 'Tambah Data Pemupukan' }}
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
                <p class="text-gray-700 dark:text-gray-300">Apakah Anda yakin ingin menghapus data pemupukan ini?</p>
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
</x-filament-panels::page>