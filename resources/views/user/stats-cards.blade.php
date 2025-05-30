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