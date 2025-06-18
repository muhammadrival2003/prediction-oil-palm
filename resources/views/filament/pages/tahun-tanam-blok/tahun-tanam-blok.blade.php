<x-filament-panels::page>
    <div class="space-y-8">
        <!-- Enhanced Header with Gradient Background -->
        <div class="bg-gradient-to-r from-emerald-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-xl p-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data Blok</h1>
                    <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-1">
                        Kelola data blok per tahun tanam
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('filament.admin.pages.tahun-tanam', ['afdeling_id' => $this->afdeling_id]) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                    <x-filament::button
                        icon="heroicon-o-plus"
                        size="sm"
                        tag="a"
                        color="emerald"
                        href="{{ route('filament.admin.resources.bloks.create', [
                            'tahun_tanam_id' => request('tahun_tanam_id'),
                            'afdeling_id' => request('afdeling_id')
                        ]) }}"
                        class="shadow-sm hover:shadow-md transition-shadow">
                        Tambah Blok
                    </x-filament::button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Blok</p>
                <p class="mt-2 text-2xl font-semibold text-blue-600 dark:text-blue-300">
                    {{ $this->bloks->count() }}
                </p>
            </div>
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-emerald-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Luas Lahan</p>
                <p class="mt-2 text-2xl font-semibold text-emerald-600 dark:text-emerald-300">
                    {{ number_format($this->bloks->sum('luas_lahan'), 2) }} Ha
                </p>
            </div>
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-sm p-6 border-l-4 border-amber-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pohon</p>
                <p class="mt-2 text-2xl font-semibold text-amber-600 dark:text-amber-300">
                    {{ number_format($this->bloks->sum('jumlah_pokok'), 0) }}
                </p>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                No Blok
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Luas Blok (Ha)
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jumlah Pohon
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($this->bloks as $blok)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                <span class="inline-flex items-center">
                                    <x-heroicon-o-map-pin class="w-4 h-4 mr-2 text-emerald-500 dark:text-emerald-400" />
                                    {{ $blok->nama_blok }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ number_format($blok->luas_lahan, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ number_format($blok->jumlah_pokok, 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Edit Button -->
                                    <x-filament::icon-button
                                        icon="heroicon-o-pencil"
                                        color="warning"
                                        size="sm"
                                        tag="a"
                                        href="{{ route('filament.admin.resources.bloks.edit', [
                                            'record' => $blok->id,
                                            'tahun_tanam_id' => request('tahun_tanam_id'),
                                            'afdeling_id' => request('afdeling_id')
                                        ]) }}"
                                        tooltip="Edit"
                                        class="hover:shadow-md transition-shadow" />

                                    <!-- Delete Button -->
                                    <x-filament::icon-button
                                        icon="heroicon-o-trash"
                                        color="danger"
                                        size="sm"
                                        wire:click="$dispatch('open-modal', { id: 'confirm-delete-{{ $blok->id }}' })"
                                        tooltip="Hapus"
                                        class="hover:shadow-md transition-shadow" />
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4 text-gray-500 dark:text-gray-400">
                                    <div class="p-4 rounded-full bg-emerald-50 dark:bg-emerald-900/20">
                                        <x-heroicon-o-inbox class="w-10 h-10 text-emerald-500 dark:text-emerald-400" />
                                    </div>
                                    <p class="text-sm font-medium">Tidak ada data blok yang ditemukan</p>
                                    <x-filament::button
                                        icon="heroicon-o-plus"
                                        size="sm"
                                        tag="a"
                                        color="emerald"
                                        href="{{ route('filament.admin.resources.bloks.create', [
                                            'tahun_tanam_id' => request('tahun_tanam_id'),
                                            'afdeling_id' => request('afdeling_id')
                                        ]) }}"
                                        class="mt-2 shadow-sm">
                                        Tambah Blok
                                    </x-filament::button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        @foreach($this->bloks as $blok)
        <x-filament::modal
            id="confirm-delete-{{ $blok->id }}"
            heading="Konfirmasi Hapus Blok"
            subheading="Apakah Anda yakin ingin menghapus blok {{ $blok->nama_blok }}?"
            maxWidth="md"
            alignment="center">
            <x-slot name="footer">
                <div class="flex items-center justify-end space-x-4">
                    <x-filament::button
                        color="gray"
                        outlined
                        wire:click="$dispatch('close-modal', { id: 'confirm-delete-{{ $blok->id }}' })"
                        class="hover:shadow-sm transition-shadow">
                        Batal
                    </x-filament::button>

                    <x-filament::button
                        color="danger"
                        wire:click="deleteBlok({{ $blok->id }}, {{ request('afdeling_id') }})"
                        wire:loading.attr="disabled"
                        class="hover:shadow-sm transition-shadow">
                        <span wire:loading.remove>Ya, Hapus</span>
                        <span wire:loading wire:target="deleteBlok">
                            <x-filament::loading-indicator class="w-4 h-4" />
                        </span>
                    </x-filament::button>
                </div>
            </x-slot>
        </x-filament::modal>
        @endforeach
    </div>
</x-filament-panels::page>