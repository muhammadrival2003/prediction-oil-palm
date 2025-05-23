<x-filament::page>
    <!-- Metrics Cards Section -->
    <x-filament::card class="rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Model Evaluation Metrics</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    Latest Results
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- MAE Card -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-300">MAE</p>
                        <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $evaluationMetrics['MAE'] ?? 'N/A' }}
                    </p>
                    <p class="mt-1 text-xs text-blue-500 dark:text-blue-400">Mean Absolute Error</p>
                </div>

                <!-- RMSE Card -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-purple-600 dark:text-purple-300">RMSE</p>
                        <svg class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $evaluationMetrics['RMSE'] ?? 'N/A' }}
                    </p>
                    <p class="mt-1 text-xs text-purple-500 dark:text-purple-400">Root Mean Squared Error</p>
                </div>

                <!-- R2 Score Card -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-green-600 dark:text-green-300">R² Score</p>
                        <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $evaluationMetrics['R2_Score'] ?? 'N/A' }}
                    </p>
                    <p class="mt-1 text-xs text-green-500 dark:text-green-400">Coefficient of Determination</p>
                </div>

                <!-- Threshold MAE Card -->
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900 dark:to-amber-800 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border-l-4 border-amber-500">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-amber-600 dark:text-amber-300">Threshold MAE</p>
                        <svg class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $evaluationMetrics['Threshold_MAE'] ?? 'N/A' }}
                    </p>
                    <p class="mt-1 text-xs text-amber-500 dark:text-amber-400">Acceptable Error Margin</p>
                </div>
            </div>
        </div>
    </x-filament::card>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 mt-6">
        <x-filament::button
            wire:click="predictByMonth"
            icon="heroicon-o-sparkles"
            color="primary"
            size="lg"
            class="w-full sm:w-auto justify-center hover:shadow-lg transition-all duration-300">
            Prediksi Next Month
        </x-filament::button>
    </div>

    @if(isset($monthPrediction) && is_array($monthPrediction) && isset($monthPrediction['prediction']))
    <x-filament::card class="mt-4">
        <h2 class="text-xl font-bold mb-2">Hasil Prediksi Otomatis</h2>

        @if(isset($monthPrediction['month']) && isset($monthPrediction['year']))
        <p>Bulan: {{ $this->getMonthName($monthPrediction['month']) }} {{ $monthPrediction['year'] }}</p>
        @endif

        @if(isset($monthPrediction['prediction']))
        <p class="text-2xl font-bold mt-2">
            Prediksi Produksi: {{ $monthPrediction['prediction'] }} ton
        </p>
        @endif

        @if(isset($monthPrediction['input_features']))
        <p class="text-sm text-gray-500 mt-2">
            Menggunakan nilai rata-rata historis:
        </p>
        <p class="text-sm text-gray-500 mt-2">
            Curah Hujan {{ $monthPrediction['input_features']['estimated_rainfall'] }}mm,
        </p>
        <p class="text-sm text-gray-500 mt-2">
            Pemupukan {{ $monthPrediction['input_features']['estimated_fertilizer'] }}kg
        </p>
        <p class="text-sm text-gray-500 mt-2">
            Hasil ProduksiR {{ $monthPrediction['input_features']['production'] }}kg
        </p>
        @endif

        @if(isset($monthPrediction['used_historical_data']))
        <div class="mt-4">
            <h3 class="font-medium mb-2">Data Historis yang Digunakan (12 Bulan Terakhir):</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan/Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curah Hujan (mm)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemupukan (kg)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produksi (ton)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($monthPrediction['used_historical_data']->reverse() as $data)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $this->getMonthName($data->month) }} {{ $data->year }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $data->rainfall }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $data->fertilizer }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $data->production }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </x-filament::card>
    @endif

    <!-- Historical Data Section -->
    @if(!empty($usedHistoricalData))
    <x-filament::card class="mt-6 rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Historical Data Used</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                    {{ count($usedHistoricalData) }} Records
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Period</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rainfall (mm)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fertilization (kg)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Production (ton)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach(array_reverse($usedHistoricalData->toArray()) as $data)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $this->getMonthName($data['month']) }} {{ $data['year'] }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $data['rainfall'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $data['fertilizer'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $data['production'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($nextMonthPrediction)
            <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg border border-blue-200 dark:border-blue-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-blue-800 dark:text-blue-200">Predicted Month</h3>
                        <div class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                            <p>{{ $this->getMonthName($nextMonthPrediction['month']) }} {{ $nextMonthPrediction['year'] }} -
                                <span class="font-bold">{{ $nextMonthPrediction['prediction'] }} ton</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </x-filament::card>
    @endif
</x-filament::page>