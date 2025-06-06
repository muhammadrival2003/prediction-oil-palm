<x-filament-panels::page>
    {{-- Tabel Prediksi --}}
    {{ $this->table }}

    {{-- Chart Section --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mt-6">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Grafik Historis Produksi
            </h3>
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Production Chart -->
                <div>
                    <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Hasil Produksi (kg)
                    </h4>
                    <div class="h-64">
                        <canvas id="productionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Production Chart
                const productionCtx = document.getElementById('productionChart').getContext('2d');
                new Chart(productionCtx, {
                    type: 'line',
                    data: {
                        labels: @json($this->getViewData()['chartData']['labels']),
                        datasets: [{
                            label: 'Produksi (kg)',
                            data: @json($this->getViewData()['chartData']['prediction']),
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 2,
                            tension: 0.1,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: false
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-filament-panels::page>