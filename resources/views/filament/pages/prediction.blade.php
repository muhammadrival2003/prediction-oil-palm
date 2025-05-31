<x-filament::page>
    <!-- Section Metrics dengan Desain Modern -->
    <div class="space-y-8">

        <!-- Form Section dengan Desain Modern -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            
            <div class="p-6">
                <form wire:submit.prevent="predictCustom" class="space-y-6">
                    {{ $this->form }}
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 transition-all duration-200 shadow-sm">
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
                        <p class="text-sm font-medium text-green-600 dark:text-green-300">Production Forecast</p>
                        <h2 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $this->getMonthName($monthPrediction['month']) }} {{ $monthPrediction['year'] }}
                        </h2>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/50 rounded-lg">
                        
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($monthPrediction['prediction'], 0, ',', '.') }} 
                        <span class="text-lg text-gray-500 dark:text-gray-400">ton</span>
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
        @endif
    </div>
</x-filament::page>