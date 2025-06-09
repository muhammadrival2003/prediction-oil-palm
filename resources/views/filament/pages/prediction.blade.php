<x-filament::page>
    <!-- Section Metrics dengan Desain Modern -->
    <div class="space-y-8">

        <!-- Form Section dengan Desain Modern -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            <div class="p-6">
                <form wire:submit.prevent="predictCustom" class="space-y-6">
                    {{ $this->form }}
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 transition-all duration-200 shadow-sm">
                            <x-heroicon-o-sparkles class="w-5 h-5 mr-2" />
                            Generate Prediction
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hasil Prediksi dengan Desain Modern -->
        @if(isset($monthPrediction))
        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600 dark:text-green-300">Prediksi Hasil Produksi</p>
                        <h2 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $this->getMonthName($monthPrediction['month']) }} {{ $monthPrediction['year'] }}
                        </h2>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/50 rounded-lg">
                        <!-- Icon or additional info -->
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($monthPrediction['prediction'], 0, ',', '.') }}
                        <span class="text-lg text-gray-500 dark:text-gray-400">kg</span>
                    </p>
                    <div class="mt-4 flex items-center">
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            {{ $monthPrediction['confidence_score'] ?? 'N/A' }}% Confidence
                        </span>
                        <span class="ml-3 text-sm text-gray-500 dark:text-gray-400">
                            Last updated: {{ now()->format('d M Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabel Data Historis 12 Bulan -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Data Historis 12 Bulan Terakhir yang digunakan
                </h3>

                @php
                // Ambil data historis 12 bulan terakhir
                $historicalData = $this->getHistoricalData(
                $monthPrediction['month'] ?? now()->month,
                $monthPrediction['year'] ?? now()->year
                );
                @endphp

                @if($historicalData->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Bulan/Tahun
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Curah Hujan (mm)
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pemupukan (kg)
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Produksi (Kg)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($historicalData as $data)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $this->getMonthName($data->month) }} {{ $data->year }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ number_format($data->total_curah_hujan) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ number_format($data->total_pemupukan) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ number_format($data->total_hasil_produksi, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-2">Tidak ada data historis tersedia</p>
                </div>
                @endif
            </div>
        </div>
        @endif

    </div>
</x-filament::page>