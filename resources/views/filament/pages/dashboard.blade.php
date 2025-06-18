<x-filament::page>
    <div class="space-y-8">
        <!-- Enhanced Header with Emerald Gradient -->
        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Dashboard Produksi</h1>
                    <p class="opacity-90 mt-1">Ringkasan statistik produksi terkini</p>
                </div>
                <div class="text-sm bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 font-medium">
                    {{ now()->format('d F Y') }}
                </div>
            </div>
        </div>

        <!-- Stats Cards with Emerald Accents -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Blok Card -->
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border border-gray-200/50 dark:border-gray-700/50">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Blok</p>
                            <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($totalBlok, 0) }}
                            </p>
                            <div class="mt-2 flex items-center text-sm text-emerald-600 dark:text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span>+2.5% dari bulan lalu</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-800/50 text-emerald-600 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-3 text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200/50 dark:border-gray-700/50">
                    <span class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                        Update terakhir: {{ now()->subHours(2)->diffForHumans() }}
                    </span>
                </div>
            </div>

            <!-- Total Produksi Card -->
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border border-gray-200/50 dark:border-gray-700/50">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Produksi</p>
                            <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($totalProduksi, 0, ',', '.') }} <span class="text-xl">kg</span>
                            </p>
                            <div class="mt-2 flex items-center text-sm text-emerald-600 dark:text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span>+15% dari bulan lalu</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-800/50 text-emerald-600 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-3 text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200/50 dark:border-gray-700/50">
                    <span class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                        Update terakhir: {{ now()->subHours(1)->diffForHumans() }}
                    </span>
                </div>
            </div>

            <!-- Total Luas Lahan Card -->
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-emerald-900/20 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border border-gray-200/50 dark:border-gray-700/50">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Luas Lahan</p>
                            <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($totalLuasLahan, 2, ',', '.') }} <span class="text-xl">ha</span>
                            </p>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                                    Produktivitas: {{ number_format($produksiPerBlok, 2) }} kg/ha
                                </p>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-800/50 text-emerald-600 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-3 text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200/50 dark:border-gray-700/50">
                    <span class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                        Update terakhir: {{ now()->subHours(3)->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        @if(!empty($this->getViewData()['chartData']['prediction']) &&
        count($this->getViewData()['chartData']['prediction']) > 0 &&
        !empty($this->getViewData()['chartData']['actual']) &&
        count($this->getViewData()['chartData']['actual']) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Grafik Hasil Produksi vs Prediksi 
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Visualisasi data hasil produksi vs prediksi dalam satuan kilogram
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div class="flex items-center space-x-2">
                            <span class="inline-block w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Produksi (kg)</span>
                        </div>
                    </div>
                </div>

                <div class="bg-emerald-50/50 dark:bg-emerald-900/10 p-4 rounded-lg">
                    <div class="h-80">
                        <canvas id="productionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chartData = @json($this -> getViewData()['chartData']);
                const productionCtx = document.getElementById('productionChart').getContext('2d');

                // Siapkan datasets berdasarkan ketersediaan data
                const datasets = [];

                // Hanya tambahkan dataset prediksi jika ada data
                if (chartData.prediction && chartData.prediction.length > 0) {
                    const gradientPrediction = productionCtx.createLinearGradient(0, 0, 0, 400);
                    gradientPrediction.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                    gradientPrediction.addColorStop(1, 'rgba(16, 185, 129, 0)');

                    datasets.push({
                        label: 'Prediksi Produksi (kg)',
                        data: chartData.prediction,
                        borderColor: '#10B981',
                        backgroundColor: gradientPrediction,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10B981',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.3,
                        fill: true
                    });
                }

                // Hanya tambahkan dataset aktual jika ada data
                if (chartData.actual && chartData.actual.length > 0) {
                    const gradientActual = productionCtx.createLinearGradient(0, 0, 0, 400);
                    gradientActual.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
                    gradientActual.addColorStop(1, 'rgba(59, 130, 246, 0)');

                    datasets.push({
                        label: 'Produksi Aktual (kg)',
                        data: chartData.actual,
                        borderColor: '#3B82F6',
                        backgroundColor: gradientActual,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3B82F6',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.3,
                        fill: true
                    });
                }

                // Buat chart hanya jika ada dataset yang tersedia
                if (datasets.length > 0) {
                    new Chart(productionCtx, {
                        type: 'line',
                        data: {
                            labels: chartData.labels,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        color: '#6B7280',
                                        usePointStyle: true,
                                        padding: 20,
                                        font: {
                                            weight: '500'
                                        }
                                    }
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
                } else {
                    // Sembunyikan atau tampilkan pesan jika tidak ada data
                    document.getElementById('productionChart').closest('.bg-emerald-50/50').innerHTML = `
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Tidak ada data yang dapat dibandingkan</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Tidak ada bulan dimana data prediksi dan produksi aktual tersedia secara bersamaan.
                    </p>
                </div>
            `;
                }
            });
        </script>
        @endpush
        @else
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 md:p-8">
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-emerald-400">
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

        <!-- Bottom Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Blok Produktif -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Top 5 Blok Produktif</h2>

                    @php
                    $topBloks = \App\Models\Blok::withSum('hasilProduksis', 'realisasi_produksi')
                    ->orderByDesc('hasil_produksis_sum_realisasi_produksi')
                    ->take(5)
                    ->get();

                    $totalProduksiAll = $topBloks->sum('hasil_produksis_sum_realisasi_produksi');
                    @endphp

                    <div class="space-y-3">
                        @foreach($topBloks as $index => $blok)
                        @php
                        $produksi = $blok->hasil_produksis_sum_realisasi_produksi ?? 0;
                        $persentase = $totalProduksiAll > 0 ? ($produksi / $totalProduksiAll) * 100 : 0;
                        @endphp

                        <div class="group flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors duration-200">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-300 font-bold group-hover:bg-emerald-200 dark:group-hover:bg-emerald-800/50 transition-colors duration-200">
                                {{ $index + 1 }}
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                        {{ $blok->nama_blok }}
                                        @if($blok->tahunTanam)
                                        <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Tahun: {{ $blok->tahunTanam->tahun_tanam }})</span>
                                        @endif
                                    </p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($produksi, 0, ',', '.') }} kg
                                    </p>
                                </div>
                                <div class="mt-1 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-2 rounded-full"
                                        style="width: {{ $persentase }}%"></div>
                                </div>
                                <div class="mt-1 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Luas: {{ number_format($blok->luas_lahan, 0, ',', '.') }} ha</span>
                                    <span>
                                        Produktivitas:
                                        @if($blok->luas_lahan > 0)
                                        {{ number_format($produksi / $blok->luas_lahan, 0, ',', '.') }} kg/ha
                                        @else
                                        0 kg/ha
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if($topBloks->isEmpty())
                        <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2">Belum ada data produksi</p>
                        </div>
                        @endif
                    </div>

                    @if($topBloks->isNotEmpty())
                    <div class="mt-4 text-right">
                        <a href="{{ url('/') }}"
                            class="text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 hover:underline">
                            Lihat semua blok →
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Activity Log -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Aktivitas Terkini</h3>
                    <div class="p-2 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-4">
                    @if(empty($recentActivities))
                    <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2">Tidak ada aktivitas terbaru</p>
                    </div>
                    @else
                    <div class="relative h-96 overflow-y-auto pr-2" x-data="{ expanded: false }">
                        <div class="space-y-4">
                            @foreach($recentActivities as $activity)
                            <div class="flex items-start p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors duration-200">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center mr-3
                                    bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-900/30 text-{{ $activity['color'] }}-600 dark:text-{{ $activity['color'] }}-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $activity['description'] }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        Blok {{ $activity['blok'] }},
                                        {{ number_format($activity['weight'], 0) }} kg
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $activity['date']->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-filament::page>