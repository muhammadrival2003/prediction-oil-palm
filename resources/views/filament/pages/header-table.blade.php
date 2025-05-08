<div class="flex items-center justify-between px-4 py-2 bg-gray-50 dark:bg-gray-800 rounded-lg mb-4">
    <div class="items-center space-x-2">
        <h1 class="text-xl font-medium text-gray-600 dark:text-gray-300">
            {{ $title }}
            <span class="font-bold text-primary-600 dark:text-primary-400">
                {{ $tahunTanam->tahun_tanam }}
            </span>
        </h1>
        <p class="text-sm">Berikut semua data {{ $subTitle }} pada {{ $title }} {{ $tahunTanam->tahun_tanam }}.</p>
    </div>
    <div>
        <a
            href="{{ route('filament.admin.pages.tahun-tanam', ['afdeling_id' => $this->afdeling_id]) }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Kembali
        </a>
        <a
            href="{{ route('filament.admin.resources.bloks.create', ['tahun_tanam_id' => request('tahun_tanam_id'), 'afdeling_id' => $this->afdeling_id]) }}"
            class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Tambah Blok
        </a>
    </div>
</div>