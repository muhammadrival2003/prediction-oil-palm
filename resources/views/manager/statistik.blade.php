<x-manager-layout>
    @push('styles')
    <style>
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .chart-container {
            position: relative;
            height: 400px;
        }

        .stat-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .progress-bar {
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        }

        .efficiency-high {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.39);
        }

        .efficiency-medium {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 4px 14px 0 rgba(245, 158, 11, 0.39);
        }

        .efficiency-low {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 4px 14px 0 rgba(239, 68, 68, 0.39);
        }

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.5);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.8);
        }

        .bg-grid-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0);
            background-size: 20px 20px;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <!-- Page Header -->
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-slate-800 dark:via-slate-700 dark:to-slate-800">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center animate-fade-in">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl mb-6 shadow-lg">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-4">
                    Analisis Statistik
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8">
                    Analisis mendalam data produksi dan efisiensi dengan insights berbasis data untuk optimasi operasional
                </p>
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center space-x-2 px-4 py-2 bg-white/80 dark:bg-slate-700/80 backdrop-blur-sm rounded-full shadow-lg">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Real-time Analytics</span>
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
        <!-- Key Performance Indicators -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-slide-up">
            <!-- Rata-rata Produksi Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600 text-white p-8 rounded-2xl card-hover shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl mb-6 backdrop-blur-sm">
                        <i class="fas fa-chart-line text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Rata-rata Produksi</h3>
                    <div class="space-y-2">
                        <p class="text-4xl font-bold tracking-tight">
                            {{ number_format($rataRataProduksiPerBlok->avg('rata_rata'), 0) }}
                        </p>
                        <p class="text-indigo-100 font-medium">kg per blok</p>
                        <div class="flex items-center justify-center space-x-2 text-sm">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-indigo-200">Performance optimal</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            </div>

            <!-- Efisiensi Rata-rata Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 via-teal-600 to-cyan-600 text-white p-8 rounded-2xl card-hover shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl mb-6 backdrop-blur-sm">
                        <i class="fas fa-percentage text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Efisiensi Rata-rata</h3>
                    <div class="space-y-2">
                        <p class="text-4xl font-bold tracking-tight">
                            {{ number_format($efisiensiPemupukan->avg('efisiensi'), 1) }}
                        </p>
                        <p class="text-emerald-100 font-medium">kg produksi/kg pupuk</p>
                        <div class="flex items-center justify-center space-x-2 text-sm">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                            <span class="text-emerald-200">Efisiensi tinggi</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            </div>

            <!-- Pencapaian Target Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 text-white p-8 rounded-2xl card-hover shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl mb-6 backdrop-blur-sm">
                        <i class="fas fa-target text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Pencapaian Target</h3>
                    <div class="space-y-2">
                        <p class="text-4xl font-bold tracking-tight">
                            {{ number_format($perbandinganRencanaRealisasi->avg('persentase_pencapaian'), 1) }}%
                        </p>
                        <p class="text-orange-100 font-medium">rata-rata realisasi</p>
                        <div class="flex items-center justify-center space-x-2 text-sm">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-orange-200">Target tercapai</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-slide-up">
            <!-- Trend Produksi Tahunan -->
            <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg">
                            <i class="fas fa-chart-area text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Trend Produksi Tahunan</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Historical Performance</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Trending</span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Rata-rata Produksi Per Blok -->
            <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg">
                            <i class="fas fa-chart-bar text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Produksi Per Blok</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Average Performance</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Active</span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="produksiBlokChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Efisiensi Analysis -->
        <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover animate-slide-up">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl shadow-lg">
                        <i class="fas fa-cogs text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Analisis Efisiensi Pemupukan</h3>
                        <p class="text-gray-600 dark:text-gray-400">Performance metrics per blok</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2 px-4 py-2 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                    <i class="fas fa-chart-pie text-purple-600 dark:text-purple-400"></i>
                    <span class="text-sm font-medium text-purple-700 dark:text-purple-300">Efficiency Analysis</span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($efisiensiPemupukan as $index => $efisiensi)
                <div class="group/card relative overflow-hidden bg-gradient-to-br from-gray-50 to-white dark:from-slate-700 dark:to-slate-600 border border-gray-200 dark:border-slate-600 rounded-xl p-6 hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">{{ $efisiensi->nama_blok }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Blok Perkebunan</p>
                            </div>
                        </div>
                        @if($efisiensi->efisiensi > 15)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white efficiency-high">
                                <i class="fas fa-arrow-up mr-1"></i>Tinggi
                            </span>
                        @elseif($efisiensi->efisiensi > 10)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white efficiency-medium">
                                <i class="fas fa-minus mr-1"></i>Sedang
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white efficiency-low">
                                <i class="fas fa-arrow-down mr-1"></i>Rendah
                            </span>
                        @endif
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Produksi:</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ number_format($efisiensi->total_produksi) }} kg</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Pemupukan:</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ number_format($efisiensi->total_pemupukan) }} kg</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-slate-600 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Efisiensi:</span>
                                <span class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($efisiensi->efisiensi, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Performance Comparison -->
        <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover animate-slide-up">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                        <i class="fas fa-balance-scale text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Perbandingan Rencana vs Realisasi</h3>
                        <p class="text-gray-600 dark:text-gray-400">Target achievement analysis</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2 px-4 py-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-full">
                    <i class="fas fa-chart-line text-indigo-600 dark:text-indigo-400"></i>
                    <span class="text-sm font-medium text-indigo-700 dark:text-indigo-300">Performance Tracking</span>
                </div>
            </div>
            
            <div class="space-y-6">
                @foreach($perbandinganRencanaRealisasi as $index => $perbandingan)
                <div class="group/item relative overflow-hidden bg-gradient-to-br from-gray-50 to-white dark:from-slate-700 dark:to-slate-600 border border-gray-200 dark:border-slate-600 rounded-xl p-6 hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">{{ $perbandingan->blok->nama_blok }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Blok Perkebunan</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold {{ $perbandingan->persentase_pencapaian >= 100 ? 'text-green-600' : ($perbandingan->persentase_pencapaian >= 80 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ number_format($perbandingan->persentase_pencapaian, 1) }}%
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Achievement</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-target text-white"></i>
                            </div>
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400 mb-1">Rencana</p>
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ number_format($perbandingan->total_rencana) }}</p>
                            <p class="text-xs text-blue-500 dark:text-blue-400">kilogram</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-check-circle text-white"></i>
                            </div>
                            <p class="text-sm font-medium text-green-600 dark:text-green-400 mb-1">Realisasi</p>
                            <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ number_format($perbandingan->total_realisasi) }}</p>
                            <p class="text-xs text-green-500 dark:text-green-400">kilogram</p>
                        </div>
                        <div class="text-center p-4 {{ ($perbandingan->total_realisasi - $perbandingan->total_rencana) >= 0 ? 'bg-emerald-50 dark:bg-emerald-900/20' : 'bg-red-50 dark:bg-red-900/20' }} rounded-lg">
                            <div class="w-12 h-12 {{ ($perbandingan->total_realisasi - $perbandingan->total_rencana) >= 0 ? 'bg-emerald-500' : 'bg-red-500' }} rounded-lg flex items-center justify-center mx-auto mb-3">
                                <i class="fas {{ ($perbandingan->total_realisasi - $perbandingan->total_rencana) >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-white"></i>
                            </div>
                            <p class="text-sm font-medium {{ ($perbandingan->total_realisasi - $perbandingan->total_rencana) >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} mb-1">Selisih</p>
                            <p class="text-2xl font-bold {{ ($perbandingan->total_realisasi - $perbandingan->total_rencana) >= 0 ? 'text-emerald-700 dark:text-emerald-300' : 'text-red-700 dark:text-red-300' }}">
                                {{ number_format($perbandingan->total_realisasi - $perbandingan->total_rencana) }}
                            </p>
                            <p class="text-xs {{ ($perbandingan->total_realisasi - $perbandingan->total_rencana) >= 0 ? 'text-emerald-500 dark:text-emerald-400' : 'text-red-500 dark:text-red-400' }}">kilogram</p>
                        </div>
                    </div>

                    <!-- Enhanced Progress Bar -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm font-medium text-gray-600 dark:text-gray-400">
                            <span>Progress</span>
                            <span>{{ number_format($perbandingan->persentase_pencapaian, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-slate-600 rounded-full h-4 overflow-hidden">
                            <div class="progress-bar h-4 rounded-full transition-all duration-500 ease-out relative" 
                                 style="width: {{ min($perbandingan->persentase_pencapaian, 100) }}%">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Statistical Summary -->
        <div class="group bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 dark:from-slate-800 dark:via-slate-700 dark:to-slate-800 rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover animate-slide-up">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-gray-600 to-slate-700 rounded-xl shadow-lg">
                        <i class="fas fa-calculator text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Ringkasan Statistik</h3>
                        <p class="text-gray-600 dark:text-gray-400">Statistical overview and insights</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2 px-4 py-2 bg-gray-100 dark:bg-gray-800/50 rounded-full">
                    <i class="fas fa-chart-area text-gray-600 dark:text-gray-400"></i>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Data Summary</span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="group/stat text-center p-6 bg-white/80 dark:bg-slate-700/80 rounded-xl border border-gray-200 dark:border-slate-600 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover/stat:scale-110 transition-transform duration-300">
                        <i class="fas fa-layer-group text-white"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Total Blok Aktif</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $rataRataProduksiPerBlok->count() }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">unit</p>
                </div>
                
                <div class="group/stat text-center p-6 bg-white/80 dark:bg-slate-700/80 rounded-xl border border-gray-200 dark:border-slate-600 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover/stat:scale-110 transition-transform duration-300">
                        <i class="fas fa-arrow-up text-white"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Produksi Tertinggi</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($rataRataProduksiPerBlok->max('rata_rata')) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">kilogram</p>
                </div>
                
                <div class="group/stat text-center p-6 bg-white/80 dark:bg-slate-700/80 rounded-xl border border-gray-200 dark:border-slate-600 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover/stat:scale-110 transition-transform duration-300">
                        <i class="fas fa-arrow-down text-white"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Produksi Terendah</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($rataRataProduksiPerBlok->min('rata_rata')) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">kilogram</p>
                </div>
                
                <div class="group/stat text-center p-6 bg-white/80 dark:bg-slate-700/80 rounded-xl border border-gray-200 dark:border-slate-600 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-violet-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover/stat:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Standar Deviasi</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format(sqrt($rataRataProduksiPerBlok->map(function($item) use ($rataRataProduksiPerBlok) { 
                            $mean = $rataRataProduksiPerBlok->avg('rata_rata'); 
                            return pow($item->rata_rata - $mean, 2); 
                        })->avg())) }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">kilogram</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trend Produksi Tahunan Chart
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            const trendData = @json($trendProduksiTahunan);
            
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: trendData.map(item => item.year),
                    datasets: [{
                        label: 'Total Produksi (kg)',
                        data: trendData.map(item => item.total_produksi),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true
                    }, {
                        label: 'Rata-rata Produksi (kg)',
                        data: trendData.map(item => item.rata_rata_produksi),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: false
                    }]
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
                            beginAtZero: true
                        }
                    }
                }
            });

            // Rata-rata Produksi Per Blok Chart
            const produksiBlokCtx = document.getElementById('produksiBlokChart').getContext('2d');
            const produksiBlokData = @json($rataRataProduksiPerBlok);
            
            new Chart(produksiBlokCtx, {
                type: 'bar',
                data: {
                    labels: produksiBlokData.map(item => item.blok.nama_blok),
                    datasets: [{
                        label: 'Rata-rata Produksi (kg)',
                        data: produksiBlokData.map(item => item.rata_rata),
                        backgroundColor: [
                            '#ef4444', '#f97316', '#eab308', '#22c55e', 
                            '#3b82f6', '#8b5cf6', '#ec4899', '#06b6d4'
                        ],
                        borderColor: [
                            '#dc2626', '#ea580c', '#ca8a04', '#16a34a',
                            '#2563eb', '#7c3aed', '#db2777', '#0891b2'
                        ],
                        borderWidth: 1
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
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                maxRotation: 45
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-manager-layout>