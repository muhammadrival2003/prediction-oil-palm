<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg mb-4">
    <div>
        <h1 class="text-lg sm:text-xl font-medium text-gray-600 dark:text-gray-300">
            {{ $title }}
            <span class="font-bold text-emerald-600 dark:text-emerald-400">
                {{ $tahunTanam->tahun_tanam }}
            </span>
        </h1>
    </div>
    
    <div class="flex flex-wrap gap-2 w-full sm:w-auto">
        <x-filament::button
            tag="a"
            href="{{ route('filament.admin.pages.tahun-tanam', ['afdeling_id' => $this->afdeling_id]) }}"
            color="gray"
            size="sm"
            icon="heroicon-o-arrow-left"
            class="w-full sm:w-auto justify-center">
            Kembali
        </x-filament::button>
        
        <x-filament::button
            tag="a"
            href="{{ route('filament.admin.resources.bloks.create', [
                'tahun_tanam_id' => request('tahun_tanam_id'), 
                'afdeling_id' => $this->afdeling_id
            ]) }}"
            color="emerald"
            size="sm"
            icon="heroicon-o-plus"
            class="w-full sm:w-auto justify-center">
            Tambah Blok
        </x-filament::button>
    </div>
</div>