<x-filament::page>
    <div class="space-y-6">
        <!-- Header dengan Gradient -->
        <div class="bg-gradient-to-r from-white-600 to-white-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl text-black font-bold">Dashboard Produksi</h1>
                    <p class="opacity-90 text-black mt-1">Ringkasan statistik produksi terkini</p>
                </div>
                <div class="text-sm text-black bg-gray-500/10 backdrop-blur-sm rounded-lg px-3 py-2">
                    {{ now()->format('d F Y') }}
                </div>
            </div>
        </div>

        <!-- Stats Cards dengan Hover Effect -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Total Blok -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Blok</p>
                            <p class="mt-1 text-3xl font-bold text-gray-900">
                                {{ number_format($totalBlok, 0) }}
                            </p>
                            <div class="mt-2 flex items-center text-sm text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span>+2.5% dari bulan lalu</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 text-sm text-gray-500 border-t border-gray-100">
                    <span class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                        Update terakhir: {{ now()->subHours(2)->diffForHumans() }}
                    </span>
                </div>
            </div>

            <!-- Total Produksi -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Produksi</p>
                            <p class="mt-1 text-3xl font-bold text-gray-900">
                                {{ number_format($totalProduksi, 0) }} <span class="text-xl">kg</span>
                            </p>
                            <div class="mt-2 flex items-center text-sm text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span>+15% dari bulan lalu</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-green-50 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 text-sm text-gray-500 border-t border-gray-100">
                    <span class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                        Update terakhir: {{ now()->subHours(1)->diffForHumans() }}
                    </span>
                </div>
            </div>

            <!-- Total Luas Lahan -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Luas Lahan</p>
                            <p class="mt-1 text-3xl font-bold text-gray-900">
                                {{ number_format($totalLuasLahan, 2) }} <span class="text-xl">ha</span>
                            </p>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-purple-600">
                                    Produktivitas: {{ number_format($produksiPerBlok, 2) }} kg/ha
                                </p>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 text-sm text-gray-500 border-t border-gray-100">
                    <span class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-purple-500 mr-2"></span>
                        Update terakhir: {{ now()->subHours(3)->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-1 gap-4">
            <!-- Produksi per Bulan -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Produksi per Bulan</h2>
                        <div class="relative">
                            <select class="appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-1 px-3 pr-8 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Tahun 2023</option>
                                <option selected>Tahun 2024</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="h-64">
                        <!-- Placeholder for Chart -->
                        <div class="flex flex-col items-center justify-center h-full bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="text-lg font-medium">Grafik produksi bulanan</span>
                            <span class="text-sm mt-1">Data akan ditampilkan dalam bentuk chart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Top Blok Produktif -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Top 5 Blok Produktif</h2>

                    @php
                    // Query untuk mendapatkan top 5 blok berdasarkan total produksi
                    $topBloks = \App\Models\Blok::withSum('hasilProduksis', 'realisasi_produksi')
                    ->orderByDesc('hasil_produksis_sum_realisasi_produksi')
                    ->take(5)
                    ->get();

                    // Hitung total produksi semua blok untuk persentase
                    $totalProduksiAll = $topBloks->sum('hasil_produksis_sum_realisasi_produksi');
                    @endphp

                    <div class="space-y-3">
                        @foreach($topBloks as $index => $blok)
                        @php
                        $produksi = $blok->hasil_produksis_sum_realisasi_produksi ?? 0;
                        $persentase = $totalProduksiAll > 0 ? ($produksi / $totalProduksiAll) * 100 : 0;
                        @endphp

                        <div class="group flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold group-hover:bg-blue-100 transition-colors duration-200">
                                {{ $index + 1 }}
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold text-gray-900 truncate">
                                        {{ $blok->nama_blok }}
                                        @if($blok->tahunTanam)
                                        <span class="text-xs font-normal text-gray-500">(Tahun: {{ $blok->tahunTanam->tahun_tanam }})</span>
                                        @endif
                                    </p>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ number_format($produksi, 0) }} kg
                                    </p>
                                </div>
                                <div class="mt-1 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full"
                                        style="width: {{ $persentase }}%"></div>
                                </div>
                                <div class="mt-1 flex justify-between text-xs text-gray-500">
                                    <span>Luas: {{ number_format($blok->luas_lahan, 2) }} ha</span>
                                    <span>
                                        Produktivitas:
                                        @if($blok->luas_lahan > 0)
                                        {{ number_format($produksi / $blok->luas_lahan, 2) }} kg/ha
                                        @else
                                        0 kg/ha
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if($topBloks->isEmpty())
                        <div class="text-center py-4 text-gray-500">
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
                            class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                            Lihat semua blok →
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Activity Log -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Aktivitas Terkini</h3>
                    <i class="fas fa-history text-blue-500"></i>
                </div>

                <div class="space-y-4">
                    @if(empty($recentActivities))
                    <div class="text-center py-4 text-gray-500">
                        Tidak ada aktivitas terbaru
                    </div>
                    @else
                    <!-- Container dengan tinggi tetap dan scroll -->
                    <div class="relative"> <!-- Tinggi bisa disesuaikan -->
                        <!-- Daftar Aktivitas -->
                        <div class="h-full overflow-y-auto pr-2"> <!-- Padding untuk scrollbar -->
                            <div class="space-y-4">
                                @foreach($recentActivities as $activity)
                                <div class="flex items-start p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center mr-3
                                bg-{{ $activity['color'] }}-100 text-{{ $activity['color'] }}-600">
                                        <i class="fas {{ $activity['icon'] }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">
                                            {{ $activity['description'] }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">
                                            Blok {{ $activity['blok'] }},
                                            {{ number_format($activity['weight'], 0) }} kg
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $activity['date']->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Gradient overlay untuk indikator scroll -->
                        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-white to-transparent pointer-events-none"
                            x-show="isOverflowing()"
                            x-init="checkOverflow()"
                            x-ref="gradientOverlay"></div>
                    </div>

                    @if(count($recentActivities) > 5)
                    <button x-data="{ expanded: false }"
                        @click="expanded = !expanded; toggleContainerHeight($refs.activityContainer)"
                        class="mt-2 w-full text-center text-sm text-indigo-600 hover:text-indigo-800 focus:outline-none">
                        <span x-text="expanded ? 'Tampilkan Lebih Sedikit' : 'Tampilkan Lebih Banyak'"></span>
                        <i class="fas ml-1" :class="expanded ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    @endif
                    @endif
                </div>
            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('activityContainer', () => ({
                        isOverflowing() {
                            const container = this.$el.querySelector('.overflow-y-auto');
                            return container.scrollHeight > container.clientHeight;
                        },
                        checkOverflow() {
                            // Untuk memastikan gradient overlay update saat konten berubah
                            const observer = new MutationObserver(() => {
                                this.$refs.gradientOverlay.style.display = this.isOverflowing() ? 'block' : 'none';
                            });
                            observer.observe(this.$el, {
                                childList: true,
                                subtree: true
                            });
                        },
                        toggleContainerHeight(container) {
                            const innerContent = container.querySelector('.overflow-y-auto');
                            if (container.style.height === '400px') {
                                container.style.height = 'auto';
                                innerContent.style.maxHeight = 'none';
                            } else {
                                container.style.height = '400px';
                                innerContent.style.maxHeight = '100%';
                            }
                        }
                    }));
                });
            </script>

            <style>
                /* Custom Scrollbar */
                .overflow-y-auto {
                    scrollbar-width: thin;
                    scrollbar-color: #cbd5e0 #f1f1f1;
                }

                .overflow-y-auto::-webkit-scrollbar {
                    width: 6px;
                }

                .overflow-y-auto::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 3px;
                }

                .overflow-y-auto::-webkit-scrollbar-thumb {
                    background-color: #cbd5e0;
                    border-radius: 3px;
                }

                .overflow-y-auto::-webkit-scrollbar-thumb:hover {
                    background-color: #a0aec0;
                }
            </style>
        </div>
    </div>
</x-filament::page>