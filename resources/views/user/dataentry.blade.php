<!-- Left Column - Data Entry Pemupukan -->
<div class="bg-white p-7 rounded-xl shadow-sm border border-gray-100">
    <h3 class="text-xl mb-4 font-semibold">Tambah Data</h3>
    <!-- Button Group -->
    <div class="flex flex-wrap gap-4">
        <!-- Pemupukan Button -->
        <button
            @click="showModalPemupukan = true"
            class="w-full bg-gradient-to-r from-indigo-600 to-indigo-500 text-white py-3 px-6 rounded-lg hover:from-indigo-700 hover:to-indigo-600 transition-all duration-300 shadow-md flex items-center justify-center focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:outline-none;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Data Pemupukan
        </button>

        <!-- Produksi Button -->
        <button
            @click="showModalProduksi = true"
            class="w-full bg-gradient-to-r from-emerald-600 to-emerald-500 text-white py-3 px-6 rounded-lg hover:from-emerald-700 hover:to-emerald-600 transition-all duration-300 shadow-md flex items-center justify-center focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:outline-none;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
            </svg>
            Tambah Data Produksi
        </button>
        <!-- Modals -->
        @include('user.modals.modal-input-pemupukan')
        @include('user.modals.modal-input-produksi')
    </div>
</div>

<!-- Tambahkan ini di bagian Middle Column - Data Entry (gantikan form yang ada) -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <fieldset>
        <legend>Published status</legend>

        <input id="draft" class="peer/draft" type="radio" name="status" checked />
        <label for="draft" class="peer-checked/draft:text-sky-500">Draft</label>

        <input id="published" class="peer/published" type="radio" name="status" />
        <label for="published" class="peer-checked/published:text-sky-500">Published</label>

        <div class="hidden peer-checked/draft:block">Drafts are only visible to administrators.</div>
        <div class="hidden peer-checked/published:block">Your post will be publicly visible on your site.</div>
    </fieldset>
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