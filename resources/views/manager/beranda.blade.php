<x-manager-layout>
    @push('styles')
    <style>
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .stat-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card-2 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card-3 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-card-4 {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
    </style>
    @endpush

    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Manager</h1>
                    <p class="text-gray-600 mt-2">Sistem Monitoring Produksi Kelapa Sawit</p>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-eye"></i>
                    <span>Mode Read-Only</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card text-white p-6 rounded-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-opacity-80">Total Blok</p>
                        <p class="text-3xl font-bold">{{ $totalBlok }}</p>
                    </div>
                    <div class="text-4xl opacity-80">
                        <i class="fas fa-map"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-2 text-white p-6 rounded-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-opacity-80">Total Pokok</p>
                        <p class="text-3xl font-bold">{{ number_format($totalPokok) }}</p>
                    </div>
                    <div class="text-4xl opacity-80">
                        <i class="fas fa-tree"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-3 text-white p-6 rounded-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-opacity-80">Total Produksi</p>
                        <p class="text-3xl font-bold">{{ number_format($totalProduksi) }}</p>
                        <p class="text-sm text-white text-opacity-80">kg</p>
                    </div>
                    <div class="text-4xl opacity-80">
                        <i class="fas fa-weight-hanging"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-4 text-white p-6 rounded-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-opacity-80">Tahun Tanam</p>
                        <p class="text-3xl font-bold">{{ $totalTahunTanam }}</p>
                        <p class="text-sm text-white text-opacity-80">variasi</p>
                    </div>
                    <div class="text-4xl opacity-80">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Laporan Produksi</h3>
                        <p class="text-gray-600 text-sm">Lihat laporan lengkap produksi</p>
                    </div>
                </div>
                <a href="{{ route('manager.laporan') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Laporan <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-chart-line text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Analisis Statistik</h3>
                        <p class="text-gray-600 text-sm">Analisis mendalam data produksi</p>
                    </div>
                </div>
                <a href="{{ route('manager.statistik') }}" 
                   class="inline-flex items-center text-green-600 hover:text-green-800 font-medium">
                    Lihat Statistik <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-eye text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Mode Read-Only</h3>
                        <p class="text-gray-600 text-sm">Akses khusus untuk manajer</p>
                    </div>
                </div>
                <div class="text-purple-600 font-medium">
                    <i class="fas fa-shield-alt mr-2"></i>Hanya Lihat Data
                </div>
            </div>
        </div>

        <!-- Data Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Blok Overview -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">
                    <i class="fas fa-map-marked-alt text-blue-600 mr-2"></i>Overview Blok
                </h3>
                <div class="space-y-3">
                    @foreach($bloks->take(5) as $blok)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">{{ $blok->nama_blok }}</p>
                            <p class="text-sm text-gray-600">{{ number_format($blok->jumlah_pokok) }} pokok</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Luas</p>
                            <p class="font-medium text-gray-800">{{ $blok->luas_blok ?? 'N/A' }} ha</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($bloks->count() > 5)
                <p class="text-center text-gray-500 mt-4">
                    Dan {{ $bloks->count() - 5 }} blok lainnya...
                </p>
                @endif
            </div>

            <!-- Jenis Pupuk Overview -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">
                    <i class="fas fa-seedling text-green-600 mr-2"></i>Jenis Pupuk Tersedia
                </h3>
                <div class="space-y-3">
                    @foreach($jenisPupuks as $pupuk)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">{{ $pupuk->nama_pupuk }}</p>
                            <p class="text-sm text-gray-600">{{ $pupuk->jenis_pupuk }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                Aktif
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Akses Manager</h3>
                    <p class="text-gray-600 mt-1">
                        Sebagai manager, Anda memiliki akses read-only untuk melihat semua laporan dan statistik produksi. 
                        Anda dapat menganalisis data namun tidak dapat mengubah atau menghapus data yang ada.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>