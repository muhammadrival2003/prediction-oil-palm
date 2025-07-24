<x-filament::page>
    <div class="space-y-8">
        <!-- Prediction Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-md">
            <div class="p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Production Prediction</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            <!-- Enter parameters to predict production output -->
                        </p>
                        <div>
                            <p class="text-sm text-primary-600 dark:text-primary-300 mt-1">
                                Total {{ $totalData }} data historis untuk prediksi.
                                12 bulan terakhir yang digunakan
                            </p>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center justify-center p-3 rounded-xl bg-emerald-50/50 dark:bg-emerald-900/20 backdrop-blur-sm">
                        <x-heroicon-o-sparkles class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                </div>

                <form wire:submit.prevent="predictCustom" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Month Select -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Bulan
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select wire:model="selected_month" required
                                    class="w-full pl-4 pr-10 py-3 text-sm border-gray-200 dark:border-gray-700 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 appearance-none transition-all duration-200">
                                    @foreach([
                                    1 => 'Januari',
                                    2 => 'Februari',
                                    3 => 'Maret',
                                    4 => 'April',
                                    5 => 'Mai',
                                    6 => 'Juni',
                                    7 => 'Juli',
                                    8 => 'Augustus',
                                    9 => 'September',
                                    10 => 'Oktober',
                                    11 => 'November',
                                    12 => 'Desember'
                                    ] as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                    <x-heroicon-o-chevron-down class="w-4 h-4" />
                                </div>
                            </div>
                        </div>

                        <!-- Year Select -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tahun
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select wire:model="selected_year" required
                                    class="w-full pl-4 pr-10 py-3 text-sm border-gray-200 dark:border-gray-700 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 appearance-none transition-all duration-200">
                                    @php
                                    $currentYear = date('Y');
                                    for ($i = 0; $i < 10; $i++) {
                                        $year=$currentYear + $i;
                                        echo "<option value=\" $year\">$year</option>";
                                        }
                                        @endphp
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                    <x-heroicon-o-chevron-down class="w-4 h-4" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                        <button type="submit"
                            class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm hover:shadow-md transition-all duration-200">
                            <x-heroicon-o-sparkles class="w-5 h-5 mr-2 -ml-1" />
                            Generate Prediction
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Prediction Results -->
        @if(isset($monthPrediction))
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-md">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-emerald-600 dark:text-emerald-400 uppercase">Production Forecast</p>
                        <h2 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $this->getMonthName($monthPrediction['month']) }} {{ $monthPrediction['year'] }}
                        </h2>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 px-3 py-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-xs font-medium text-emerald-700 dark:text-emerald-300">Live Prediction</span>
                        </div>
                        <a href="{{ route('filament.admin.pages.model-lstm', ['model_performance' => $this->model_performance]) }}"
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors duration-300 shadow-sm">
                            Evaluasi Model
                        </a>
                    </div>
                </div>

                <!-- Prediction Metrics -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Main Prediction -->
                    <div class="bg-white dark:bg-gray-700 p-5 rounded-xl border border-gray-100 dark:border-gray-600 shadow-xs">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Predicted Production</h3>
                            <x-heroicon-o-scale class="w-5 h-5 text-gray-400 dark:text-gray-500" />
                        </div>
                        <div class="mt-4">
                            <p class="text-3xl font-bold text-gray-800 dark:text-white">
                                {{ number_format($monthPrediction['prediction'], 0, ',', '.') }}
                                <span class="text-lg font-medium text-gray-500 dark:text-gray-400">kg</span>
                            </p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ number_format($monthPrediction['prediction'] / 100, 0, ',', '.') }} ton
                            </p>
                        </div>
                    </div>

                    <!-- Confidence Score -->
                    <div class="bg-white dark:bg-gray-700 p-5 rounded-xl border border-gray-100 dark:border-gray-600 shadow-xs">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Confidence Level</h3>
                            <x-heroicon-o-shield-check class="w-5 h-5 text-gray-400 dark:text-gray-500" />
                        </div>
                        <div class="mt-4">
                            <div class="flex items-end gap-2">
                                <p class="text-3xl font-bold text-gray-800 dark:text-white">
                                    {{ number_format($monthPrediction['confidence_score'], 1) }}<span class="text-xl">%</span>
                                </p>
                                @if($monthPrediction['confidence_score'] > 80)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    High
                                </span>
                                @elseif($monthPrediction['confidence_score'] > 60)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    Medium
                                </span>
                                @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Low
                                </span>
                                @endif
                            </div>
                            <div class="mt-3 w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-emerald-500 h-2 rounded-full"
                                    style="width: {{ $monthPrediction['confidence_score'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Historical Data Table -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                        Historikal Data (12 Bulan Terakhir)
                    </h3>

                    @php
                    $historicalData = $this->getHistoricalData(
                    $monthPrediction['month'] ?? now()->month,
                    $monthPrediction['year'] ?? now()->year
                    );
                    @endphp

                    @if($historicalData->count() > 0)
                    <div class="overflow-hidden rounded-lg border border-gray-100 dark:border-gray-700 shadow-xs">
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
                                            Hasil Produksi (kg)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($historicalData as $data)
                                    @php
                                    $productionDiff = $monthPrediction['prediction'] - $data->total_hasil_produksi;
                                    $productionDiffPercent = $data->total_hasil_produksi > 0 ? ($productionDiff / $data->total_hasil_produksi) * 100 : 0;
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">
                                            {{ $this->getMonthName($data->month) }} {{ $data->year }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ number_format($data->total_curah_hujan, 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ number_format($data->total_pemupukan, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ number_format($data->total_hasil_produksi, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-12 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-600 flex items-center justify-center mb-4">
                            <x-heroicon-o-document-magnifying-glass class="w-8 h-8 text-gray-400 dark:text-gray-500" />
                        </div>
                        <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300">No historical data available</h4>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">We couldn't find any historical production data</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</x-filament::page>