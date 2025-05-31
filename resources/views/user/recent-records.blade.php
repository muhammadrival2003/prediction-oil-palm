<div class="lg:col-span-4 bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold text-gray-800">Data Blok</h3>
        <i class="fas fa-table text-purple-500"></i>
    </div>

    <!-- Container dengan tinggi tetap dan scroll -->
    <div class="overflow-x-auto flex-grow" style="max-height: 400px;">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 sticky top-0 z-10">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Blok</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Tanam</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Luas Lahan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Pokok</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($bloks as $blok)
                <tr class="hover:bg-gray-50 cursor-pointer transition-colors">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $blok->nama_blok }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                        {{ $blok->tahunTanam->tahun_tanam }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                        {{ number_format($blok->luas_lahan, 2) }} ha
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                        {{ number_format($blok->jumlah_pokok) }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="status-badge bg-green-100 text-green-800">Tercukupi</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Custom scrollbar styling */
    .overflow-x-auto::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
    
    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
</style>





<div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
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
        <div class="relative" style="height: 300px;"> <!-- Tinggi bisa disesuaikan -->
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