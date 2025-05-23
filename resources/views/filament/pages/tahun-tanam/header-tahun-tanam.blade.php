<div class="flex flex-row justify-between">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
        Tahun Tanam
    </h2>
    <div class="flex flex-row gap-3">
        <x-filament::button
            size="sm"
            color="gray"
            tag="a"
            href="{{ route('filament.admin.pages.afdeling.menu', ['afdeling_id' => $this->afdeling_id]) }}">
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
<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
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