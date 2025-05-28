<x-filament::page>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Blok Pemupukan</h1>
            <!-- Tambahkan tombol aksi jika diperlukan -->
            <a href="{{ route('filament.admin.pages.menu-pekerjaan') }}" class="inline-flex items-center text-primary-600 hover:text-primary-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse($bloks as $blok)
            <a
                href="{{ route('filament.admin.pages.pemupukan', ['blok_id' => $blok->id]) }}"
                class="group relative block rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="bg-white border border-gray-200 rounded-xl p-5 h-full flex flex-col">
                    <div class="flex items-start justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-primary-600 transition-colors">
                            {{ $blok->nama_blok }}
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                            {{ $blok->tahunTanam->tahun_tanam }}
                        </span>
                    </div>

                    <div class="mt-4 space-y-2 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Luas: {{ $blok->luas_lahan }} ha</span>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full">
                <div class="bg-white border border-gray-200 rounded-xl p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data blok</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada blok produksi yang terdaftar.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</x-filament::page>