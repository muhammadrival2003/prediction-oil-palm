<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header Section --}}
        @if($header = $this->getHeaders())
        <div class="px-4 sm:px-0">
            {!! $header !!}
        </div>
        @endif

        {{-- Table Container --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No Blok
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Luas Blok (Ha)
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah Pohon
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($this->bloks as $blok)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $blok->nama_blok }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $blok->luas_lahan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $blok->jumlah_pokok }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    {{-- Edit Button --}}
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
                                    />
                                    
                                    {{-- Delete Button --}}
                                    <x-filament::icon-button
                                        icon="heroicon-o-trash"
                                        color="danger"
                                        size="sm"
                                        wire:click="$dispatch('open-modal', { id: 'confirm-delete-{{ $blok->id }}' })"
                                        tooltip="Hapus"
                                    />
                                </div>
                                
                                {{-- Delete Confirmation Modal --}}
                                <x-filament::modal
                                    id="confirm-delete-{{ $blok->id }}"
                                    heading="Konfirmasi Hapus Blok"
                                    subheading="Apakah Anda yakin ingin menghapus blok {{ $blok->nama_blok }}?"
                                    maxWidth="md"
                                >
                                    <x-slot name="footer">
                                        <div class="flex items-center justify-end space-x-4">
                                            <x-filament::button
                                                color="gray"
                                                outlined
                                                wire:click="$dispatch('close-modal', { id: 'confirm-delete-{{ $blok->id }}' })"
                                            >
                                                Batal
                                            </x-filament::button>
                                            
                                            <x-filament::button
                                                color="danger"
                                                wire:click="deleteBlok({{ $blok->id }}, {{ request('afdeling_id') }})"
                                                wire:loading.attr="disabled"
                                            >
                                                <span wire:loading.remove>Ya, Hapus</span>
                                                <span wire:loading wire:target="deleteBlok">
                                                    <x-filament::loading-indicator class="w-4 h-4" />
                                                </span>
                                            </x-filament::button>
                                        </div>
                                    </x-slot>
                                </x-filament::modal>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center space-y-2 text-gray-500">
                                    <x-heroicon-o-inbox class="w-12 h-12" />
                                    <p class="text-sm font-medium">Tidak ada data blok yang ditemukan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>