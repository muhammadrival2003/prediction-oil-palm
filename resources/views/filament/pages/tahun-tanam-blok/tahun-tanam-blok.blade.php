<x-filament-panels::page>
    <div class="p-6 bg-white rounded-lg shadow">
        @if($header = $this->getHeaders())
        {!! $header !!}
        @endif

        <div class="overflow-x-auto mt-6">
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
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $blok->nama_blok }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $blok->luas_lahan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $blok->jumlah_pokok }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button
                                    x-on:click="window.location.href='{{ route('filament.admin.resources.bloks.edit', $blok->id) }}?tahun_tanam_id={{ request('tahun_tanam_id') }}'"
                                    class="p-1.5 hover:bg-yellow-100 text-yellow-600 rounded-full"
                                    title="Edit">
                                    <x-heroicon-o-pencil class="w-5 h-5" />
                                </button>
                                <button
                                    wire:click="$dispatch('open-modal', { id: 'confirm-delete-{{ $blok->id }}' })"
                                    class="p-1.5  hover:bg-red-600 text-red hover:text-white rounded-full z-10"
                                    title="Hapus Blok">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                                <x-filament::modal id="confirm-delete-{{ $blok->id }}" heading="Hapus?" subheading="Apakah Anda yakin ingin menghapus blok {{ $blok->nama_blok }}?">
                                    <x-slot name="footer" disabled>
                                        <x-filament::button class="text-xs" color="danger" wire:click="deleteBlok({{ $blok->id }})">
                                            Ya, Hapus
                                        </x-filament::button>
                                        <x-filament::button class="text-xs" color="gray" wire:click="$dispatch('close-modal', { id: 'confirm-delete-{{ $blok->id }}' })">
                                            Batal
                                        </x-filament::button>
                                    </x-slot>
                                </x-filament::modal>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data blok yang ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>