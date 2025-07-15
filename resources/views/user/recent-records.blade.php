<!-- Data Blok Section -->
<div class="lg:col-span-4 group">
    <div class="bg-gradient-to-br from-white to-gray-50/50 backdrop-blur-sm border border-gray-200/60 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                        <i class="fas fa-table text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Data Blok</h3>
                        <p class="text-purple-100 text-sm">Informasi lahan perkebunan</p>
                    </div>
                </div>
                <div class="text-white/80 text-sm font-medium">
                    {{ count($bloks) }} Blok
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="p-6">
            <div class="overflow-hidden rounded-xl border border-gray-200/60">
                <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100" style="max-height: 400px;">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>No Blok</span>
                                        <i class="fas fa-sort text-gray-400 text-xs"></i>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>Tahun Tanam</span>
                                        <i class="fas fa-sort text-gray-400 text-xs"></i>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>Luas Lahan</span>
                                        <i class="fas fa-sort text-gray-400 text-xs"></i>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>Jumlah Pokok</span>
                                        <i class="fas fa-sort text-gray-400 text-xs"></i>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($bloks as $index => $blok)
                            <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-blue-50 cursor-pointer transition-all duration-200 group/row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center group-hover/row:from-purple-200 group-hover/row:to-purple-300 transition-colors">
                                            <span class="text-xs font-bold text-purple-600">{{ $index + 1 }}</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $blok->nama_blok }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-calendar-alt text-green-500 text-xs"></i>
                                        <span class="text-sm text-gray-700 font-medium">{{ $blok->tahunTanam->tahun_tanam }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-expand-arrows-alt text-blue-500 text-xs"></i>
                                        <span class="text-sm font-semibold text-gray-900">{{ number_format($blok->luas_lahan, 2) }}</span>
                                        <span class="text-xs text-gray-500 font-medium">ha</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-seedling text-emerald-500 text-xs"></i>
                                        <span class="text-sm font-semibold text-gray-900">{{ number_format($blok->jumlah_pokok) }}</span>
                                        <span class="text-xs text-gray-500 font-medium">pokok</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Aktivitas Terkini Section -->
<div class="lg:col-span-2 group">
    <div class="bg-gradient-to-br from-white to-blue-50/30 backdrop-blur-sm border border-gray-200/60 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden h-full">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                        <i class="fas fa-history text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Aktivitas Terkini</h3>
                        <p class="text-blue-100 text-sm">Riwayat kegiatan terbaru</p>
                    </div>
                </div>
                <div class="text-white/80 text-sm font-medium">
                    {{ count($recentActivities ?? []) }} Item
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 flex-1">
            @if(empty($recentActivities))
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-inbox text-gray-400 text-xl"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-600 mb-2">Belum Ada Aktivitas</h4>
                <p class="text-sm text-gray-500">Aktivitas terbaru akan muncul di sini</p>
            </div>
            @else
            <div x-data="{ expanded: false }" class="space-y-4">
                <!-- Activity Container -->
                <div class="relative" :class="expanded ? 'h-auto' : 'h-80'">
                    <div class="h-full overflow-y-auto scrollbar-thin scrollbar-thumb-blue-300 scrollbar-track-blue-100 pr-2 space-y-3">
                        @foreach($recentActivities as $activity)
                        <div class="group/activity bg-white/60 backdrop-blur-sm border border-gray-200/60 rounded-xl p-4 hover:bg-white hover:shadow-md transition-all duration-200">
                            <div class="flex items-start space-x-4">
                                <!-- Icon -->
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-gradient-to-br from-{{ $activity['color'] }}-100 to-{{ $activity['color'] }}-200 group-hover/activity:from-{{ $activity['color'] }}-200 group-hover/activity:to-{{ $activity['color'] }}-300 transition-all duration-200">
                                        <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}-600 text-lg"></i>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-gray-800 mb-1 group-hover/activity:text-gray-900 transition-colors">
                                        {{ $activity['description'] }}
                                    </h4>
                                    <div class="flex items-center space-x-4 text-xs text-gray-600 mb-2">
                                        <div class="flex items-center space-x-1">
                                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                                            <span class="font-medium">Blok {{ $activity['blok'] }}</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <i class="fas fa-weight-hanging text-gray-400"></i>
                                            <span class="font-semibold">{{ number_format($activity['weight'], 0) }} kg</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1 text-xs text-gray-500">
                                        <i class="fas fa-clock text-gray-400"></i>
                                        <span>{{ $activity['date']->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <!-- Status Indicator -->
                                <div class="flex-shrink-0">
                                    <div class="w-3 h-3 rounded-full bg-{{ $activity['color'] }}-400 animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Gradient Overlay -->
                    <div x-show="!expanded && {{ count($recentActivities) }} > 3" 
                         class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-white via-white/80 to-transparent pointer-events-none rounded-b-xl"></div>
                </div>

                <!-- Expand/Collapse Button -->
                @if(count($recentActivities) > 3)
                <div class="pt-4 border-t border-gray-200/60">
                    <button @click="expanded = !expanded" 
                            class="w-full flex items-center justify-center space-x-2 py-3 px-4 bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 text-blue-600 hover:text-blue-700 rounded-xl border border-blue-200/60 hover:border-blue-300/60 transition-all duration-200 font-medium text-sm">
                        <span x-text="expanded ? 'Tampilkan Lebih Sedikit' : 'Tampilkan Semua ({{ count($recentActivities) }})'"></span>
                        <i class="fas transition-transform duration-200" :class="expanded ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Enhanced Scrollbar Styling */
    .scrollbar-thin {
        scrollbar-width: thin;
    }
    
    .scrollbar-thumb-gray-300::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 6px;
    }
    
    .scrollbar-thumb-blue-300::-webkit-scrollbar-thumb {
        background-color: #93c5fd;
        border-radius: 6px;
    }
    
    .scrollbar-track-gray-100::-webkit-scrollbar-track,
    .scrollbar-track-blue-100::-webkit-scrollbar-track {
        background-color: #f3f4f6;
        border-radius: 6px;
    }
    
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    .scrollbar-thumb-gray-300::-webkit-scrollbar-thumb:hover {
        background-color: #9ca3af;
    }
    
    .scrollbar-thumb-blue-300::-webkit-scrollbar-thumb:hover {
        background-color: #60a5fa;
    }

    /* Smooth animations */
    .group:hover .group-hover\:shadow-xl {
        transform: translateY(-2px);
    }

    /* Custom gradient animations */
    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .animate-gradient {
        background-size: 200% 200%;
        animation: gradient-shift 3s ease infinite;
    }
</style>