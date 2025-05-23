<x-app-layout>
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .nav-item:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize chart
            const ctx = document.getElementById('productionChart').getContext('2d');
            const productionChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Production (kg)',
                        data: [12000, 19000, 15000, 22000, 18000, 25000],
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });

            // Toggle prediction card
            document.getElementById('togglePredictions').addEventListener('click', function() {
                const card = document.getElementById('predictionsCard');
                card.classList.toggle('hidden');
            });

            // Table row hover effect
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    console.log('Row clicked:', this);
                });
            });
        });
    </script>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize date picker
            flatpickr("#datePicker", {
                dateFormat: "d/m/Y",
                defaultDate: "today"
            });

            // Initialize chart
            const ctx = document.getElementById('productionChart').getContext('2d');
            const productionChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Production (kg)',
                        data: [12000, 19000, 15000, 22000, 18000, 25000],
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });

            // Toggle prediction card
            document.getElementById('togglePredictions').addEventListener('click', function() {
                const card = document.getElementById('predictionsCard');
                card.classList.toggle('hidden');
            });

            // Table row hover effect
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    // Add your row click handler here
                    console.log('Row clicked:', this);
                });
            });
        });
    </script>
    @endpush

    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Palm Oil Production</h1>
                <h2 class="text-xl text-gray-600">Selamat Datang, <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span></h2>
                <p class="text-gray-500">Mengelola dan memasukkan data palm oil production</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-sm text-gray-500">System Active</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 transition-all duration-300 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jumlah Tahun Tanam</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalTahunTanam }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-purple-600 mt-2"><i class="fas fa-arrow-up"></i> 3% improvement</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 transition-all duration-300 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jumlah Blok</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalBlok }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-yellow-50 text-yellow-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-yellow-600 mt-2">Needs verification</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 transition-all duration-300 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jumlah Pokok</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalPokok }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                        <i class="fas fa-tree text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-blue-600 mt-2"><i class="fas fa-arrow-up"></i> 5 new this week</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 transition-all duration-300 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Produksi</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalProduksi }} kg</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-50 text-green-600">
                        <i class="fas fa-leaf text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up"></i> 12% from last month</p>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Quick Actions -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Quick Actions</h3>
                    <i class="fas fa-bolt text-yellow-500"></i>
                </div>

                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex items-center p-3 rounded-lg nav-item transition-colors duration-200">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                <i class="fas fa-plus"></i>
                            </div>
                            <span class="font-medium">Add New Entry</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-3 rounded-lg nav-item transition-colors duration-200">
                            <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-3">
                                <i class="fas fa-database"></i>
                            </div>
                            <span class="font-medium">View All Records</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-3 rounded-lg nav-item transition-colors duration-200">
                            <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-3">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <span class="font-medium">Production Analytics</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-3 rounded-lg nav-item transition-colors duration-200">
                            <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center mr-3">
                                <i class="fas fa-file-export"></i>
                            </div>
                            <span class="font-medium">Export Data</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Middle Column - Data Entry -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Masukkan Data Produksi</h3>
                    <i class="fas fa-edit text-indigo-500"></i>
                </div>

                <form action="{{ route('produksi.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <div class="relative">
                            <input id="tanggal" name="tanggal" type="date"
                                class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Select date" required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-calendar text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="blok_id" class="block text-sm font-medium text-gray-700 mb-1">No Blok</label>
                        <select id="blok_id" name="blok_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="">Select block</option>
                            @foreach($bloks as $blok)
                            <option value="{{ $blok->id }}">{{ $blok->nama_blok }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="hasil_produksi" class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                        <input id="hasil_produksi" name="hasil_produksi" type="number" step="0.1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="0.0" required>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-indigo-500 text-white py-3 px-4 rounded-lg hover:from-indigo-700 hover:to-indigo-600 transition-all duration-300 shadow-md flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i> Submit Data
                    </button>
                </form>
            </div>

            <!-- Right Column - Recent Activity -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Aktivitas Terkini</h3>
                    <i class="fas fa-history text-blue-500"></i>
                </div>

                <div class="space-y-4" x-data="{
            activities: [],
            loading: true,
            showAll: false,
            maxVisible: 5,
            
            fetchActivities() {
                fetch('{{ route('activity.get') }}')
                    .then(response => response.json())
                    .then(data => {
                        this.activities = data;
                        this.loading = false;
                    });
            },
            
            getActivityTitle(type) {
                const titles = {
                    'verified': 'Record diverifikasi',
                    'created': 'Entri baru ditambahkan',
                    'pending': 'Menunggu verifikasi',
                    'updated': 'Data diperbarui'
                };
                return titles[type] || 'Aktivitas';
            },
            
            formatNumber(num) {
                return parseFloat(num).toLocaleString('id-ID');
            },
            
            formatTime(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffInHours = Math.floor((now - date) / (1000 * 60 * 60));
                
                if (diffInHours < 1) {
                    return 'Beberapa menit yang lalu';
                } else if (diffInHours < 24) {
                    return `${diffInHours} jam yang lalu`;
                } else {
                    return date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                }
            },
            
            toggleShowAll() {
                this.showAll = !this.showAll;
            }
        }" x-init="fetchActivities">

                    <!-- Loading State -->
                    <template x-if="loading">
                        <div class="flex justify-center py-4">
                            <i class="fas fa-spinner fa-spin text-blue-500"></i>
                        </div>
                    </template>

                    <!-- Empty State -->
                    <template x-if="!loading && activities.length === 0">
                        <div class="text-center py-4 text-gray-500">
                            Tidak ada aktivitas terbaru
                        </div>
                    </template>

                    <!-- Activity Container with Scroll -->
                    <div class="relative">
                        <!-- Activity Items -->
                        <div class="space-y-4 overflow-y-auto"
                            :class="{'max-h-64': !showAll && activities.length > maxVisible, 'max-h-none': showAll}"
                            :style="`scrollbar-width: thin;`">
                            <template x-for="activity in activities" :key="activity.id">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center mr-3"
                                        :class="{
                                'bg-green-100 text-green-600': activity.activity_type === 'verified',
                                'bg-blue-100 text-blue-600': activity.activity_type === 'created',
                                'bg-yellow-100 text-yellow-600': activity.activity_type === 'pending',
                                'bg-purple-100 text-purple-600': activity.activity_type === 'updated'
                            }">
                                        <i class="fas"
                                            :class="{
                                    'fa-check': activity.activity_type === 'verified',
                                    'fa-plus': activity.activity_type === 'created',
                                    'fa-exclamation': activity.activity_type === 'pending',
                                    'fa-edit': activity.activity_type === 'updated'
                                }"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800" x-text="getActivityTitle(activity.activity_type)"></p>
                                        <p class="text-xs text-gray-500" x-text="`Blok ${activity.blok.nama_blok}, ${formatNumber(activity.data.weight)} kg`"></p>
                                        <p class="text-xs text-gray-400" x-text="formatTime(activity.created_at)"></p>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Gradient Overlay (only shown when not showing all and there's more to scroll) -->
                        <div x-show="!showAll && activities.length > maxVisible"
                            class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-white to-transparent pointer-events-none">
                        </div>
                    </div>

                    <!-- Show More/Less Button -->
                    <template x-if="activities.length > maxVisible">
                        <button @click="toggleShowAll"
                            class="mt-2 w-full text-center text-sm text-indigo-600 hover:text-indigo-800 focus:outline-none">
                            <span x-text="showAll ? 'Tampilkan Lebih Sedikit' : 'Tampilkan Lebih Banyak'"></span>
                            <i class="fas ml-1" :class="showAll ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                    </template>
                </div>

                <!-- <a href="{{ route('activity.index') }}" class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
                    Lihat semua aktivitas <i class="fas fa-chevron-right ml-1"></i>
                </a> -->
            </div>
        </div>

        <!-- Data Visualization Section -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Production Trends</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-xs bg-indigo-100 text-indigo-700 rounded-full">Monthly</button>
                        <button class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">Weekly</button>
                        <button class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">Daily</button>
                    </div>
                </div>
                <canvas id="productionChart" height="250"></canvas>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Recent Records</h3>
                    <i class="fas fa-table text-purple-500"></i>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Block</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50 cursor-pointer transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">2025-01-15</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">A-123</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">2,500 kg</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="status-badge bg-green-100 text-green-800">Verified</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 cursor-pointer transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">2025-01-14</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">B-456</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">3,200 kg</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="status-badge bg-green-100 text-green-800">Verified</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 cursor-pointer transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">2025-01-13</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">C-789</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">2,800 kg</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="status-badge bg-yellow-100 text-yellow-800">Pending</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="#" class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
                    View full records <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Predictions Section -->
        <div class="mt-8 bg-gradient-to-r from-indigo-500 to-indigo-600 p-6 rounded-xl shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold">Production Forecast</h3>
                    <p class="text-indigo-100">View predicted production for upcoming months</p>
                </div>
                <button id="togglePredictions" class="flex items-center space-x-2 bg-white/20 hover:bg-white/30 px-4 py-2 rounded-full transition-colors">
                    <span>Show Predictions</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
            </div>

            <div id="predictionsCard" class="mt-4 hidden">
                <div class="bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="p-3">
                            <p class="text-sm text-indigo-200">Next Month</p>
                            <p class="text-xl font-bold">26,400 kg</p>
                            <p class="text-xs text-green-300">+8% expected</p>
                        </div>
                        <div class="p-3">
                            <p class="text-sm text-indigo-200">Next Quarter</p>
                            <p class="text-xl font-bold">82,500 kg</p>
                            <p class="text-xs text-green-300">+12% expected</p>
                        </div>
                        <div class="p-3">
                            <p class="text-sm text-indigo-200">Next Year</p>
                            <p class="text-xl font-bold">315,000 kg</p>
                            <p class="text-xs text-green-300">+15% expected</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function getActivityTitle(type) {
            const titles = {
                'created': 'Entri baru ditambahkan',
                'updated': 'Data diperbarui',
                'verified': 'Record diverifikasi',
                'pending': 'Menunggu verifikasi'
            };
            return titles[type] || 'Aktivitas';
        }

        function formatNumber(num) {
            return parseFloat(num).toLocaleString('id-ID');
        }

        function formatTime(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInHours = Math.floor((now - date) / (1000 * 60 * 60));

            if (diffInHours < 1) {
                return 'Beberapa menit yang lalu';
            } else if (diffInHours < 24) {
                return `${diffInHours} jam yang lalu`;
            } else {
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            }
        }
    </script>
</x-app-layout>