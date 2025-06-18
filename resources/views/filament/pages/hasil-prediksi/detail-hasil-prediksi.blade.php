<x-filament::page>
    @php
    // Akses data melalui predictionRecord yang dikirim dari controller
    $prediction = $this->predictionRecord;
    // Asumsikan input_data sudah dalam bentuk array
    $inputData = $prediction->input_data;
    // Mengurutkan data berdasarkan tahun dan bulan
    usort($inputData, function ($a, $b) {
        // Urutkan berdasarkan tahun terlebih dahulu, kemudian bulan
        if ($a['year'] === $b['year']) {
            return $b['month'] <=> $a['month']; // Urutkan bulan dari terbesar ke terkecil
        }
            return $b['year'] <=> $a['year']; // Urutkan tahun dari terbesar ke terkecil
    });
    @endphp

    @if($prediction)
    <div class="space-y-6">
        <!-- Header dengan Title dan Tombol Kembali -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Detail Prediksi
            </h2>
            <a href="{{ route('filament.admin.resources.predictions.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                Kembali
            </a>
        </div>

        <!-- Card Prediksi Utama -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600 dark:text-green-300">Prediksi Hasil Produksi</p>
                        <h2 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $prediction->month_name }} {{ $prediction->year }}
                        </h2>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/50 rounded-lg">
                        <x-heroicon-o-chart-bar class="w-6 h-6 text-green-600 dark:text-green-300" />
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($prediction->prediction, 0, ',', '.') }}
                        <span class="text-lg text-gray-500 dark:text-gray-400">kg</span>
                    </p>
                    <div class="mt-4 flex items-center">
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Dibuat pada: {{ $prediction->created_at->format('d M Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Input Data -->
        @if(!empty($prediction->input_data))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Data Historis 12 Bulan Terakhir yang digunakan
                </h3>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan/Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Curah Hujan (mm)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemupukan (kg)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produksi (kg)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($inputData as $data)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::createFromFormat('!m', $data['month'])->locale('id')->translatedFormat('F') }} {{ $data['year'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ number_format($data['curah_hujan'], 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ number_format($data['pemupukan'], 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ number_format($data['hasil_produksi'], 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
    @else
    <div class="bg-red-50 dark:bg-red-900/10 p-6 rounded-lg">
        <p class="text-red-600 dark:text-red-300">Data prediksi tidak ditemukan</p>
    </div>
    @endif
</x-filament::page>