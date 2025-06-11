<x-filament-panels::page>
    {{-- Tabel Prediksi --}}
    {{ $this->table }}

    {{-- Modern Chart Section - Only shown if there's prediction data --}}
    @if(!empty($this->getViewData()['chartData']['prediction']) && count($this->getViewData()['chartData']['prediction']) > 0)
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl overflow-hidden mt-8 border border-gray-200 dark:border-gray-700">
        <div class="p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Grafik Hasil Prediksi
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Visualisasi data prediksi dalam satuan kilogram
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="flex items-center space-x-2">
                        <span class="inline-block w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Produksi (kg)</span>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-8">
                <!-- Production Chart -->
                <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg">
                    <div class="h-80">
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
                // Modern Production Chart
                const productionCtx = document.getElementById('productionChart').getContext('2d');
                const gradient = productionCtx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                new Chart(productionCtx, {
                    type: 'line',
                    data: {
                        labels: @json($this->getViewData()['chartData']['labels']),
                        datasets: [{
                            label: 'Produksi (kg)',
                            data: @json($this->getViewData()['chartData']['prediction']),
                            borderColor: '#10B981',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#10B981',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1F2937',
                                titleColor: '#F9FAFB',
                                bodyColor: '#E5E7EB',
                                borderColor: '#374151',
                                borderWidth: 1,
                                padding: 12,
                                usePointStyle: true,
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${context.parsed.y} kg`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#6B7280'
                                }
                            },
                            y: {
                                grid: {
                                    color: '#E5E7EB',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#6B7280',
                                    callback: function(value) {
                                        return value + ' kg';
                                    }
                                },
                                beginAtZero: false
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            });
        </script>
    @endpush
    @else
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl overflow-hidden mt-8 border border-gray-200 dark:border-gray-700">
        <div class="p-6 md:p-8">
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Tidak ada data prediksi</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Belum ada data prediksi yang tersedia untuk ditampilkan dalam grafik.
                </p>
            </div>
        </div>
    </div>
    @endif
</x-filament-panels::page>