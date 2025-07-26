<x-manager-layout>
    @push('styles')
    <style>
        .chart-container {
            position: relative;
            height: 400px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .badge-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.39);
        }

        .badge-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(245, 158, 11, 0.39);
        }

        .badge-info {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.39);
        }

        .badge-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(239, 68, 68, 0.39);
        }

        .gradient-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        .bg-grid-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.15) 1px, transparent 0);
            background-size: 20px 20px;
        }

        .afdeling-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dark .afdeling-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(30, 41, 59, 0.7) 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .metric-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.6) 100%);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .metric-card {
            background: linear-gradient(135deg, rgba(51, 65, 85, 0.8) 0%, rgba(51, 65, 85, 0.6) 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Tab Styles */
        .tab-button {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .tab-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .tab-button:hover::before {
            left: 100%;
        }

        .tab-button.active {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-indicator {
            position: absolute;
            bottom: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            transition: all 0.3s ease;
            border-radius: 2px 2px 0 0;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <!-- Page Header -->
    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-slate-800 dark:via-slate-700 dark:to-slate-800">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center animate-fade-in">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl mb-6 shadow-lg">
                    <i class="fas fa-layer-group text-white text-2xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-4">
                    Laporan Afdeling
                </h1>
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center space-x-2 px-4 py-2 bg-white/80 dark:bg-slate-700/80 backdrop-blur-sm rounded-full shadow-lg">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Live Data</span>
                    </div>
                    <div class="flex items-center space-x-2 px-4 py-2 bg-white/80 dark:bg-slate-700/80 backdrop-blur-sm rounded-full shadow-lg">
                        <i class="fas fa-clock text-purple-500"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 space-y-8">
        <!-- Overview Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-slide-up">
            <!-- Produksi Per Afdeling Chart -->
            <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg">
                            <i class="fas fa-chart-bar text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Produksi Per Afdeling</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Produksi Keseluruhan</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Active</span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="produksiAfdelingChart"></canvas>
                </div>
            </div>

            <!-- Trend Produksi Chart -->
            <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Trend Produksi</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">6 Bulan Terakhir</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Trending</span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="trendProduksiChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 animate-slide-up">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl shadow-lg">
                        <i class="fas fa-layer-group text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Per Afdeling</h3>
                        <p class="text-gray-600 dark:text-gray-400">Pilih afdeling untuk melihat detail lengkap</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2 px-4 py-2 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                    <i class="fas fa-tabs text-purple-600 dark:text-purple-400"></i>
                    <span class="text-sm font-medium text-purple-700 dark:text-purple-300">{{ count($laporanPerAfdeling) }} Afdeling</span>
                </div>
            </div>

            <!-- Tab Headers -->
            <div class="relative mb-8">
                <div class="flex flex-wrap gap-2 border-b border-gray-200 dark:border-slate-600 relative">
                    <div class="tab-indicator" id="tabIndicator"></div>
                    @foreach($laporanPerAfdeling as $index => $laporan)
                    <button
                        class="tab-button px-6 py-4 font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-t-lg transition-all duration-300 {{ $index === 0 ? 'active' : '' }}"
                        data-tab="afdeling-{{ $index }}"
                        data-index="{{ $index }}">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-xs">
                                {{ substr($laporan['afdeling']->nama, 0, 2) }}
                            </div>
                            <span>{{ $laporan['afdeling']->nama }}</span>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Tab Contents -->
            @foreach($laporanPerAfdeling as $index => $laporan)
            <div class="tab-content {{ $index === 0 ? 'active' : '' }}" id="afdeling-{{ $index }}">
                <div class="space-y-8">
                    <!-- Afdeling Header -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            @if($laporan['total_produksi'] > 50000)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold badge-success">
                                <i class="fas fa-arrow-up mr-1"></i>Produktif Tinggi
                            </span>
                            @elseif($laporan['total_produksi'] > 25000)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold badge-warning">
                                <i class="fas fa-minus mr-1"></i>Produktif Sedang
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold badge-info">
                                <i class="fas fa-arrow-down mr-1"></i>Perlu Perhatian
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Metrics Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <!-- Total Blok -->
                        <div class="metric-card p-6 rounded-xl shadow-lg">
                            <div class="flex items-center justify-between mb-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                    <i class="fas fa-map text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Blok</span>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $laporan['total_blok'] }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Blok</p>
                            </div>
                        </div>

                        <!-- Total Pokok -->
                        <div class="metric-card p-6 rounded-xl shadow-lg">
                            <div class="flex items-center justify-between mb-3">
                                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                    <i class="fas fa-tree text-green-600 dark:text-green-400"></i>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Pokok</span>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($laporan['total_pokok']) }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Pokok</p>
                            </div>
                        </div>

                        <!-- Total Produksi -->
                        <div class="metric-card p-6 rounded-xl shadow-lg">
                            <div class="flex items-center justify-between mb-3">
                                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                    <i class="fas fa-weight-hanging text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Produksi</span>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($laporan['total_produksi']) }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">kg</p>
                            </div>
                        </div>

                        <!-- Efisiensi -->
                        <div class="metric-card p-6 rounded-xl shadow-lg">
                            <div class="flex items-center justify-between mb-3">
                                <div class="p-2 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                                    <i class="fas fa-chart-line text-orange-600 dark:text-orange-400"></i>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Efisiensi</span>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($laporan['efisiensi_pemupukan'], 2) }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">kg/kg pupuk</p>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Indicators -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Produksi Bulan Ini -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 p-6 rounded-xl border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="p-2 bg-blue-500 rounded-lg">
                                    <i class="fas fa-calendar text-white text-sm"></i>
                                </div>
                                <h5 class="font-semibold text-gray-900 dark:text-white">Produksi Bulan Ini</h5>
                            </div>
                            <div class="space-y-2">
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($laporan['produksi_bulan_ini']) }} kg</p>
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ now()->format('F Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pemupukan Bulan Ini -->
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 p-6 rounded-xl border border-emerald-200 dark:border-emerald-800">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="p-2 bg-emerald-500 rounded-lg">
                                    <i class="fas fa-seedling text-white text-sm"></i>
                                </div>
                                <h5 class="font-semibold text-gray-900 dark:text-white">Pemupukan Bulan Ini</h5>
                            </div>
                            <div class="space-y-2">
                                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($laporan['pemupukan_bulan_ini']) }} kg</p>
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ now()->format('F Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Produktivitas -->
                        <div class="bg-gradient-to-r from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 p-6 rounded-xl border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="p-2 bg-purple-500 rounded-lg">
                                    <i class="fas fa-chart-bar text-white text-sm"></i>
                                </div>
                                <h5 class="font-semibold text-gray-900 dark:text-white">Produktivitas</h5>
                            </div>
                            <div class="space-y-2">
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($laporan['rata_rata_produksi_per_pokok'], 2) }}</p>
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">kg per pokok</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Blok Table -->
                    <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm rounded-xl border border-gray-200 dark:border-slate-600 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-slate-700 dark:to-slate-600 border-b border-gray-200 dark:border-slate-600">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-table mr-2 text-gray-600 dark:text-gray-400"></i>
                                Blok - {{ $laporan['afdeling']->nama }}
                            </h4>
                        </div>
                        <div class="overflow-x-auto">
                            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-600 overflow-hidden">
                                @php
                                    $blokData = $detailBlokPerAfdeling->where('afdeling.id', $laporan['afdeling']->id)->first()['bloks'] ?? [];
                                @endphp
                                
                                @if(count($blokData) > 0)
                                    <!-- Table Container with Fixed Height -->
                                    <div class="h-96 overflow-y-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-600">
                                            <thead class="bg-gray-50 dark:bg-slate-700 sticky top-0 z-10">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Blok</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tahun Tanam</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Pokok</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produksi</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pemupukan</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produktivitas</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-600">
                                                @foreach($blokData as $blokDetail)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors duration-200">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-xs">
                                                                {{ substr($blokDetail['blok']->nama_blok, -2) }}
                                                            </div>
                                                            <div>
                                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $blokDetail['blok']->nama_blok }}</div>
                                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $blokDetail['blok']->luas_blok }} ha</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                            {{ $blokDetail['tahun_tanam']->tahun_tanam }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                                        {{ number_format($blokDetail['blok']->jumlah_pokok) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($blokDetail['produksi']) }} kg</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">Total produksi</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($blokDetail['pemupukan']) }} kg</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">Total pupuk</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center space-x-2">
                                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($blokDetail['produktivitas'], 2) }}</div>
                                                            @if($blokDetail['produktivitas'] > 20)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium badge-success">
                                                                <i class="fas fa-arrow-up mr-1"></i>Tinggi
                                                            </span>
                                                            @elseif($blokDetail['produktivitas'] > 10)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium badge-warning">
                                                                <i class="fas fa-minus mr-1"></i>Sedang
                                                            </span>
                                                            @else
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium badge-danger">
                                                                <i class="fas fa-arrow-down mr-1"></i>Rendah
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">kg/pokok</div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <!-- Empty State -->
                                    <div class="flex flex-col items-center justify-center py-16 px-6">
                                        <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-inbox text-3xl text-gray-400 dark:text-gray-500"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                            Tidak Ada Data Blok
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center max-w-sm">
                                            Belum ada data detail blok untuk afdeling <strong>{{ $laporan['afdeling']->nama }}</strong> pada periode yang dipilih.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            const tabIndicator = document.getElementById('tabIndicator');

            function updateTabIndicator(activeButton) {
                const buttonRect = activeButton.getBoundingClientRect();
                const containerRect = activeButton.parentElement.getBoundingClientRect();
                const left = buttonRect.left - containerRect.left;
                const width = buttonRect.width;

                tabIndicator.style.left = left + 'px';
                tabIndicator.style.width = width + 'px';
            }

            // Initialize tab indicator position
            const activeTab = document.querySelector('.tab-button.active');
            if (activeTab) {
                updateTabIndicator(activeTab);
            }

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    // Remove active class from all buttons and contents
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to clicked button and corresponding content
                    this.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');

                    // Update tab indicator
                    updateTabIndicator(this);
                });
            });

            // Handle window resize for tab indicator
            window.addEventListener('resize', function() {
                const activeButton = document.querySelector('.tab-button.active');
                if (activeButton) {
                    updateTabIndicator(activeButton);
                }
            });

            // Produksi Per Afdeling Chart
            const produksiAfdelingCtx = document.getElementById('produksiAfdelingChart').getContext('2d');
            const produksiAfdelingData = @json($produksiPerAfdelingChart);

            const afdelingLabels = produksiAfdelingData.map(item => item.nama);
            const afdelingValues = produksiAfdelingData.map(item => item.total_produksi);

            new Chart(produksiAfdelingCtx, {
                type: 'bar',
                data: {
                    labels: afdelingLabels,
                    datasets: [{
                        label: 'Produksi (kg)',
                        data: afdelingValues,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(139, 92, 246, 0.8)',
                            'rgba(236, 72, 153, 0.8)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(139, 92, 246, 1)',
                            'rgba(236, 72, 153, 1)'
                        ],
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Trend Produksi Chart
            const trendCtx = document.getElementById('trendProduksiChart').getContext('2d');
            const trendData = @json($trendProduksiAfdeling);

            // Prepare data for line chart
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const colors = [
                'rgba(59, 130, 246, 1)',
                'rgba(16, 185, 129, 1)',
                'rgba(245, 158, 11, 1)',
                'rgba(239, 68, 68, 1)',
                'rgba(139, 92, 246, 1)',
                'rgba(236, 72, 153, 1)'
            ];

            const datasets = trendData.map((afdeling, index) => {
                const monthlyData = new Array(6).fill(0);
                afdeling.data.forEach(item => {
                    const monthIndex = item.month - 1;
                    if (monthIndex >= 0 && monthIndex < 6) {
                        monthlyData[monthIndex] = item.total_produksi;
                    }
                });

                return {
                    label: afdeling.nama,
                    data: monthlyData,
                    borderColor: colors[index % colors.length],
                    backgroundColor: colors[index % colors.length].replace('1)', '0.1)'),
                    borderWidth: 3,
                    tension: 0.4,
                    fill: false,
                    pointBackgroundColor: colors[index % colors.length],
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                };
            });

            // Get last 6 months labels
            const last6Months = [];
            for (let i = 5; i >= 0; i--) {
                const date = new Date();
                date.setMonth(date.getMonth() - i);
                last6Months.push(months[date.getMonth()]);
            }

            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: last6Months,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
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
</x-manager-layout>