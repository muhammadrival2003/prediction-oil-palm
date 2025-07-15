<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <!-- Jumlah Tahun Tanam Card -->
    <div class="group relative bg-gradient-to-br from-purple-50 via-white to-purple-50/30 p-6 rounded-2xl shadow-lg border border-purple-100/50 transition-all duration-500 hover:shadow-2xl hover:shadow-purple-500/10 hover:-translate-y-1 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-600 mb-1 tracking-wide">Jumlah Tahun Tanam</p>
                    <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ $totalTahunTanam }}</p>
                </div>
                <div class="p-3 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <div class="flex items-center px-2 py-1 bg-purple-100 rounded-full">
                    <i class="fas fa-arrow-up text-xs text-purple-600 mr-1"></i>
                    <span class="text-xs font-semibold text-purple-700">3% improvement</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Blok Card -->
    <div class="group relative bg-gradient-to-br from-amber-50 via-white to-amber-50/30 p-6 rounded-2xl shadow-lg border border-amber-100/50 transition-all duration-500 hover:shadow-2xl hover:shadow-amber-500/10 hover:-translate-y-1 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-600 mb-1 tracking-wide">Jumlah Blok</p>
                    <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ $totalBlok }}</p>
                </div>
                <div class="p-3 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <div class="flex items-center px-2 py-1 bg-amber-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-xs text-amber-600 mr-1"></i>
                    <span class="text-xs font-semibold text-amber-700">Needs verification</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Pokok Card -->
    <div class="group relative bg-gradient-to-br from-blue-50 via-white to-blue-50/30 p-6 rounded-2xl shadow-lg border border-blue-100/50 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/10 hover:-translate-y-1 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-600 mb-1 tracking-wide">Jumlah Pokok</p>
                    <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ $totalPokok }}</p>
                </div>
                <div class="p-3 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-tree text-xl"></i>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <div class="flex items-center px-2 py-1 bg-blue-100 rounded-full">
                    <i class="fas fa-arrow-up text-xs text-blue-600 mr-1"></i>
                    <span class="text-xs font-semibold text-blue-700">5 new this week</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Produksi Card -->
    <div class="group relative bg-gradient-to-br from-emerald-50 via-white to-emerald-50/30 p-6 rounded-2xl shadow-lg border border-emerald-100/50 transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-600 mb-1 tracking-wide">Total Produksi</p>
                    <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ $totalProduksi }} <span class="text-lg font-medium text-gray-500">kg</span></p>
                </div>
                <div class="p-3 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-leaf text-xl"></i>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <div class="flex items-center px-2 py-1 bg-emerald-100 rounded-full">
                    <i class="fas fa-arrow-up text-xs text-emerald-600 mr-1"></i>
                    <span class="text-xs font-semibold text-emerald-700">12% from last month</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add custom CSS for additional animations -->
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
    }
    
    .card-hover:hover {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Custom gradient animation */
    .group:hover .bg-gradient-to-br {
        background-size: 200% 200%;
        animation: gradient-shift 3s ease infinite;
    }
    
    @keyframes gradient-shift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>
