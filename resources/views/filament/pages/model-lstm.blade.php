<x-filament::page>
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Evaluasi Performa Model</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Infromasi performa model LSTM yang telah dilatih dan diuji.
                </p>
            </div>

            <div class="flex items-center gap-3">
                @if($this->modelPerformance['last_training_date'] ?? false)
                <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <x-heroicon-o-clock class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Terakhir Latih Model: {{ \Carbon\Carbon::parse($this->modelPerformance['last_training_date'])->format('M d, Y H:i') }}
                    </span>
                </div>
                <a href="{{ route('filament.admin.pages.prediction') }}"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali
                </a>
                @endif
            </div> 
        </div>

        <!-- Main Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Training Metrics Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Training Metrics</h3>
                        <div class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            Training Data
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- RMSE -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                                    <x-heroicon-o-scale class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">RMSE</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Root Mean Square Error</p>
                                </div>
                            </div>
                            <p class="text-xl font-bold text-gray-800 dark:text-white">
                                {{ number_format($this->modelPerformance['training_metrics']['RMSE'] ?? 0, 2) }}
                            </p>
                        </div>

                        <!-- MAE -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                                    <x-heroicon-o-arrow-trending-up class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">MAE</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Mean Absolute Error</p>
                                </div>
                            </div>
                            <p class="text-xl font-bold text-gray-800 dark:text-white">
                                {{ number_format($this->modelPerformance['training_metrics']['MAE'] ?? 0, 2) }}
                            </p>
                        </div>

                        <!-- R2 Score -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                                    <x-heroicon-o-chart-bar class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">R² Score</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Coefficient of Determination</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <p class="text-xl font-bold text-gray-800 dark:text-white">
                                    {{ number_format($this->modelPerformance['training_metrics']['R2'] ?? 0, 3) }}
                                </p>
                                @php
                                $r2Score = $this->modelPerformance['training_metrics']['R2'] ?? 0;
                                $r2Color = $r2Score >= 0.8 ? 'text-green-600 dark:text-green-400' :
                                ($r2Score >= 0.6 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400');
                                $r2Label = $r2Score >= 0.8 ? 'Excellent' :
                                ($r2Score >= 0.6 ? 'Good' : 'Needs Improvement');
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $r2Color }} bg-opacity-20">
                                    {{ $r2Label }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testing Metrics Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Testing Metrics</h3>
                        <div class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                            Testing Data
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- RMSE -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-purple-50 dark:bg-purple-900/30">
                                    <x-heroicon-o-scale class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">RMSE</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Root Mean Square Error</p>
                                </div>
                            </div>
                            <p class="text-xl font-bold text-gray-800 dark:text-white">
                                {{ number_format($this->modelPerformance['testing_metrics']['RMSE'] ?? 0, 2) }}
                            </p>
                        </div>

                        <!-- MAE -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-purple-50 dark:bg-purple-900/30">
                                    <x-heroicon-o-arrow-trending-up class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">MAE</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Mean Absolute Error</p>
                                </div>
                            </div>
                            <p class="text-xl font-bold text-gray-800 dark:text-white">
                                {{ number_format($this->modelPerformance['testing_metrics']['MAE'] ?? 0, 2) }}
                            </p>
                        </div>

                        <!-- R2 Score -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-purple-50 dark:bg-purple-900/30">
                                    <x-heroicon-o-chart-bar class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">R² Score</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Coefficient of Determination</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <p class="text-xl font-bold text-gray-800 dark:text-white">
                                    {{ number_format($this->modelPerformance['testing_metrics']['R2'] ?? 0, 3) }}
                                </p>
                                @php
                                $r2Score = $this->modelPerformance['testing_metrics']['R2'] ?? 0;
                                $r2Color = $r2Score >= 0.8 ? 'text-green-600 dark:text-green-400' :
                                ($r2Score >= 0.6 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400');
                                $r2Label = $r2Score >= 0.8 ? 'Excellent' :
                                ($r2Score >= 0.6 ? 'Good' : 'Needs Improvement');
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $r2Color }} bg-opacity-20">
                                    {{ $r2Label }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Analysis Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Analisa Performa Model</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Overfitting Check -->
                    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 rounded-lg bg-amber-50 dark:bg-amber-900/20">
                                <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                            </div>
                            <h4 class="font-medium text-gray-800 dark:text-white">Overfitting</h4>
                        </div>
                        @php
                        $trainRmse = $this->modelPerformance['training_metrics']['RMSE'] ?? 0;
                        $testRmse = $this->modelPerformance['testing_metrics']['RMSE'] ?? 0;
                        $overfittingRatio = $trainRmse > 0 ? $testRmse / $trainRmse : 0;

                        if ($overfittingRatio > 1.5) {
                        $status = 'Potential Overfitting';
                        $color = 'text-red-600 dark:text-red-400';
                        $icon = 'heroicon-o-exclamation-circle';
                        $description = 'Kesalahan pengujian jauh lebih tinggi daripada kesalahan pelatihan. Pertimbangkan teknik regularisasi.';
                        } elseif ($overfittingRatio > 1.2) {
                        $status = 'Mild Overfitting';
                        $color = 'text-yellow-600 dark:text-yellow-400';
                        $icon = 'heroicon-o-exclamation-triangle';
                        $description = 'Kesalahan pengujian agak lebih tinggi daripada kesalahan pelatihan. Pantau dengan saksama.';
                        } else {
                        $status = 'No Significant Overfitting';
                        $color = 'text-green-600 dark:text-green-400';
                        $icon = 'heroicon-o-check-circle';
                        $description = 'Model dapat digeneralisasi dengan baik ke data yang tidak terlihat.';
                        }
                        @endphp
                        <p class="text-sm {{ $color }} font-medium mb-2 flex items-center gap-1">
                            <x-dynamic-component :component="$icon" class="w-4 h-4" />
                            {{ $status }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $description }}</p>
                        <p class="text-xs mt-2 text-gray-500 dark:text-gray-400">
                            Ratio: {{ number_format($overfittingRatio, 2) }} (Test RMSE / Train RMSE)
                        </p>
                    </div>

                    <!-- Model Quality -->
                    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-900/20">
                                <x-heroicon-o-star class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <h4 class="font-medium text-gray-800 dark:text-white">Kualitas Model</h4>
                        </div>
                        @php
                        $r2Score = $this->modelPerformance['testing_metrics']['R2'] ?? 0;

                        if ($r2Score >= 0.8) {
                        $status = 'Excellent';
                        $color = 'text-green-600 dark:text-green-400';
                        $icon = 'heroicon-o-sparkles';
                        $description = 'Model menjelaskan sebagian besar variabilitas dalam data.';
                        } elseif ($r2Score >= 0.6) {
                        $status = 'Good';
                        $color = 'text-blue-600 dark:text-blue-400';
                        $icon = 'heroicon-o-thumb-up';
                        $description = 'Model berkinerja cukup baik tetapi dapat ditingkatkan.';
                        } elseif ($r2Score >= 0.4) {
                        $status = 'Fair';
                        $color = 'text-yellow-600 dark:text-yellow-400';
                        $icon = 'heroicon-o-arrow-path';
                        $description = 'Model menjelaskan beberapa variabilitas tetapi perlu perbaikan.';
                        } else {
                        $status = 'Poor';
                        $color = 'text-red-600 dark:text-red-400';
                        $icon = 'heroicon-o-x-circle';
                        $description = 'Model gagal menjelaskan sebagian besar variabilitas.';
                        }
                        @endphp
                        <p class="text-sm {{ $color }} font-medium mb-2 flex items-center gap-1">
                            <x-dynamic-component :component="$icon" class="w-4 h-4" />
                            {{ $status }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $description }}</p>
                        <p class="text-xs mt-2 text-gray-500 dark:text-gray-400">
                            Based on Testing R²: {{ number_format($r2Score, 3) }}
                        </p>
                    </div>

                    <!-- Error Analysis -->
                    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 rounded-lg bg-rose-50 dark:bg-rose-900/20">
                                <x-heroicon-o-magnifying-glass class="w-5 h-5 text-rose-600 dark:text-rose-400" />
                            </div>
                            <h4 class="font-medium text-gray-800 dark:text-white">Error</h4>
                        </div>
                        @php
                        $mae = $this->modelPerformance['testing_metrics']['MAE'] ?? 0;
                        $avgProduction = 1000; // Ganti dengan nilai rata-rata produksi aktual jika tersedia
                        $relativeError = $avgProduction > 0 ? ($mae / $avgProduction) * 100 : 0;

                        if ($relativeError < 10) {
                            $status='Low Error' ;
                            $color='text-green-600 dark:text-green-400' ;
                            $icon='heroicon-o-check-circle' ;
                            $description='Prediksi model sangat dekat dengan nilai sebenarnya.' ;
                            } elseif ($relativeError < 20) {
                            $status='Moderate Error' ;
                            $color='text-yellow-600 dark:text-yellow-400' ;
                            $icon='heroicon-o-exclamation-triangle' ;
                            $description='Prediksi model cukup akurat.' ;
                            } else {
                            $status='High Error' ;
                            $color='text-red-600 dark:text-red-400' ;
                            $icon='heroicon-o-x-circle' ;
                            $description='Prediksi model menyimpang secara signifikan dari nilai sebenarnya.' ;
                            }
                            @endphp
                            <p class="text-sm {{ $color }} font-medium mb-2 flex items-center gap-1">
                            <x-dynamic-component :component="$icon" class="w-4 h-4" />
                            {{ $status }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $description }}</p>
                            <p class="text-xs mt-2 text-gray-500 dark:text-gray-400">
                                Relative Error: {{ number_format($relativeError, 1) }}% of average production
                            </p>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</x-filament::page>