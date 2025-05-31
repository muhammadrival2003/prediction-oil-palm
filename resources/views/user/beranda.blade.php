<x-app-layout>
    <div x-data="{ showModalPemupukan: false,
                    showModalProduksi: false }">
        @push('styles')
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
            @include('user.header-section')

            <!-- Stats Cards -->
            @include('user.stats-cards')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Data Entry -->
                @include('user.dataentry')
            </div>

            <!-- Data Visualization Section -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-6 gap-6">
                <!-- Recent Records Section -->
                @include('user.recent-records')
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
    </div>
    </div>
</x-app-layout>