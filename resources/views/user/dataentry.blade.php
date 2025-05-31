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
            observer.observe(this.$el, { childList: true, subtree: true });
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