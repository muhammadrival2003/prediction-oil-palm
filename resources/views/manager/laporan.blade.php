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

        .gradient-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .floating-card {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <!-- Page Header -->
    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-slate-800 dark:via-slate-700 dark:to-slate-800">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center animate-fade-in">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl mb-6 shadow-lg">
                    <i class="fas fa-chart-bar text-white text-2xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-4">
                    Laporan Komprehensif
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8">
                    Analisis mendalam operasional Unit Kebun Lama dengan visualisasi data real-time dan insights yang actionable
                </p>
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
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-slide-up">
            <!-- Total Blok Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 text-white p-8 rounded-2xl card-hover shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <i class="fas fa-map text-2xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-blue-100 uppercase tracking-wider">Total</div>
                            <div class="text-xs text-blue-200">Blok Aktif</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold tracking-tight">{{ $totalBlok }}</h3>
                        <p class="text-blue-100 text-sm font-medium">Blok Perkebunan</p>
                        <div class="flex items-center space-x-2 text-xs">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-blue-200">Semua aktif</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            </div>

            <!-- Total Pokok Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 via-green-600 to-teal-600 text-white p-8 rounded-2xl card-hover shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <i class="fas fa-tree text-2xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-green-100 uppercase tracking-wider">Total</div>
                            <div class="text-xs text-green-200">Pohon Kelapa Sawit</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold tracking-tight">{{ number_format($totalPokok) }}</h3>
                        <p class="text-green-100 text-sm font-medium">Pokok Produktif</p>
                        <div class="flex items-center space-x-2 text-xs">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                            <span class="text-green-200">Dalam produksi</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            </div>

            <!-- Produksi Bulan Ini Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-purple-500 via-violet-600 to-purple-700 text-white p-8 rounded-2xl card-hover shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <i class="fas fa-weight-hanging text-2xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-purple-100 uppercase tracking-wider">Bulan Ini</div>
                            <div class="text-xs text-purple-200">{{ now()->format('M Y') }}</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold tracking-tight">{{ number_format($totalProduksiBulanIni) }}</h3>
                        <p class="text-purple-100 text-sm font-medium">Kilogram TBS</p>
                        <div class="flex items-center space-x-2 text-xs">
                            <div class="w-2 h-2 bg-orange-400 rounded-full animate-pulse"></div>
                            <span class="text-purple-200">Target tercapai</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            </div>

            <!-- Pemupukan Bulan Ini Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-orange-500 via-amber-600 to-yellow-600 text-white p-8 rounded-2xl card-hover shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <i class="fas fa-seedling text-2xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-orange-100 uppercase tracking-wider">Bulan Ini</div>
                            <div class="text-xs text-orange-200">{{ now()->format('M Y') }}</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-4xl font-bold tracking-tight">{{ number_format($totalPemupukanBulanIni) }}</h3>
                        <p class="text-orange-100 text-sm font-medium">Kilogram Pupuk</p>
                        <div class="flex items-center space-x-2 text-xs">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-orange-200">Sesuai jadwal</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-slide-up">
            <!-- Produksi 12 Bulan Terakhir -->
            <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Trend Produksi</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">12 Bulan Terakhir</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Live</span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="produksiChart"></canvas>
                </div>
            </div>

            <!-- Pemupukan Per Jenis -->
            <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg">
                            <i class="fas fa-chart-pie text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Distribusi Pemupukan</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Per Jenis Pupuk</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Active</span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="pemupukanChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-slide-up">
            <!-- Produksi Per Blok -->
            <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-purple-500 to-violet-600 rounded-lg">
                            <i class="fas fa-table text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Produksi Per Blok</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Performance Overview</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-purple-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Updated</span>
                    </div>
                </div>
                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-slate-600">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-600">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-slate-700 dark:to-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Blok</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Produksi</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-600">
                            @foreach($produksiPerBlok as $index => $produksi)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $produksi->blok->nama_blok }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Blok Aktif</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($produksi->total_produksi) }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">kilogram</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($produksi->total_produksi > 10000)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold badge-success">
                                            <i class="fas fa-arrow-up mr-1"></i>Tinggi
                                        </span>
                                    @elseif($produksi->total_produksi > 5000)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold badge-warning">
                                            <i class="fas fa-minus mr-1"></i>Sedang
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold badge-info">
                                            <i class="fas fa-arrow-down mr-1"></i>Rendah
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Recent Activities</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-indigo-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Live</span>
                    </div>
                </div>
                <div class="space-y-4 max-h-96 overflow-y-auto custom-scrollbar">
                    @foreach($aktivitasTerbaru as $aktivitas)
                    <div class="group/item flex items-start space-x-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-slate-700 dark:to-slate-600 rounded-xl hover:from-blue-50 hover:to-indigo-50 dark:hover:from-slate-600 dark:hover:to-slate-500 transition-all duration-300">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg group-hover/item:scale-110 transition-transform duration-300">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $aktivitas->user->name ?? 'System' }}
                                </p>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $aktivitas->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                {{ $aktivitas->description }}
                            </p>
                            <div class="flex items-center mt-2 space-x-2">
                                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Completed</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Export Section -->
        <!-- <div class="group bg-gradient-to-br from-white/90 to-gray-50/90 dark:from-slate-800/90 dark:to-slate-700/90 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 card-hover animate-slide-up">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-lg">
                        <i class="fas fa-download text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Export Laporan</h3>
                        <p class="text-gray-600 dark:text-gray-400">Download laporan dalam berbagai format</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"></i>
                    <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Read-Only Mode</span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <button class="group/btn relative overflow-hidden bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center space-y-3">
                        <div class="p-3 bg-white/20 rounded-lg">
                            <i class="fas fa-file-pdf text-2xl"></i>
                        </div>
                        <div class="text-center">
                            <h4 class="font-bold">Export PDF</h4>
                            <p class="text-sm text-red-100">Format dokumen</p>
                        </div>
                    </div>
                </button>
                
                <button class="group/btn relative overflow-hidden bg-gradient-to-r from-emerald-500 to-emerald-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-emerald-700 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center space-y-3">
                        <div class="p-3 bg-white/20 rounded-lg">
                            <i class="fas fa-file-excel text-2xl"></i>
                        </div>
                        <div class="text-center">
                            <h4 class="font-bold">Export Excel</h4>
                            <p class="text-sm text-emerald-100">Spreadsheet data</p>
                        </div>
                    </div>
                </button>
                
                <button class="group/btn relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center space-y-3">
                        <div class="p-3 bg-white/20 rounded-lg">
                            <i class="fas fa-print text-2xl"></i>
                        </div>
                        <div class="text-center">
                            <h4 class="font-bold">Print Laporan</h4>
                            <p class="text-sm text-blue-100">Cetak langsung</p>
                        </div>
                    </div>
                </button>
            </div>
            
            <div class="flex items-center justify-center space-x-3 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                <i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400"></i>
                <p class="text-sm text-amber-700 dark:text-amber-300 font-medium">
                    Fitur export tersedia dalam mode read-only untuk manager. Data yang ditampilkan adalah real-time.
                </p>
            </div>
        </div> -->
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Produksi Chart
            const produksiCtx = document.getElementById('produksiChart').getContext('2d');
            const produksiData = @json($produksi12Bulan);
            
            const produksiLabels = produksiData.map(item => {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return months[item.month - 1] + ' ' + item.year;
            });
            
            const produksiValues = produksiData.map(item => item.total_produksi);

            new Chart(produksiCtx, {
                type: 'line',
                data: {
                    labels: produksiLabels,
                    datasets: [{
                        label: 'Produksi (kg)',
                        data: produksiValues,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
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

            // Pemupukan Chart
            const pemupukanCtx = document.getElementById('pemupukanChart').getContext('2d');
            const pemupukanData = @json($pemupukanPerJenis);
            
            const pemupukanLabels = pemupukanData.map(item => item.jenis_pupuk.nama_pupuk);
            const pemupukanValues = pemupukanData.map(item => item.total_volume);

            new Chart(pemupukanCtx, {
                type: 'doughnut',
                data: {
                    labels: pemupukanLabels,
                    datasets: [{
                        data: pemupukanValues,
                        backgroundColor: [
                            '#ef4444',
                            '#f97316',
                            '#eab308',
                            '#22c55e',
                            '#3b82f6',
                            '#8b5cf6',
                            '#ec4899'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-manager-layout>