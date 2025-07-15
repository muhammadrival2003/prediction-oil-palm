<!-- Left Column - Data Entry Actions -->
<div class="lg:col-span-1">
    <div class="bg-white/80 backdrop-blur-sm p-8 rounded-3xl shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tambah Data</h3>
            <p class="text-gray-600">Pilih jenis data yang ingin ditambahkan</p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <!-- Pemupukan Button -->
            <button
                @click="showModalPemupukan = true"
                class="group w-full relative overflow-hidden bg-gradient-to-r from-indigo-600 via-indigo-600 to-purple-600 text-white py-4 px-6 rounded-2xl hover:from-indigo-700 hover:via-indigo-700 hover:to-purple-700 transition-all duration-500 shadow-lg hover:shadow-xl transform hover:-translate-y-1 focus:ring-4 focus:ring-indigo-300 focus:ring-offset-2 focus:outline-none">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                <div class="relative flex items-center justify-center">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-lg">Data Pemupukan</span>
                </div>
            </button>

            <!-- Produksi Button -->
            <button
                @click="showModalProduksi = true"
                class="group w-full relative overflow-hidden bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-600 text-white py-4 px-6 rounded-2xl hover:from-emerald-700 hover:via-emerald-700 hover:to-teal-700 transition-all duration-500 shadow-lg hover:shadow-xl transform hover:-translate-y-1 focus:ring-4 focus:ring-emerald-300 focus:ring-offset-2 focus:outline-none">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                <div class="relative flex items-center justify-center">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-lg">Data Produksi</span>
                </div>
            </button>
        </div>

        <!-- Decorative Elements -->
        <div class="mt-8 flex justify-center space-x-2">
            <div class="w-2 h-2 bg-indigo-300 rounded-full animate-pulse"></div>
            <div class="w-2 h-2 bg-purple-300 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
            <div class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
        </div>
    </div>
</div>

<!-- Right Column - Karyawan Lapangan Table -->
<div class="lg:col-span-2">
    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 overflow-hidden hover:shadow-2xl transition-all duration-500">
        <!-- Table Header -->
        <div class="bg-gradient-to-r from-slate-800 to-slate-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Karyawan Lapangan</h3>
                        <p class="text-slate-300 mt-1">Daftar karyawan yang bekerja di lapangan</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-white">{{ count($karyawanLapangans) }}</div>
                    <div class="text-slate-300 text-sm">Total Karyawan</div>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="p-6">
            <div class="overflow-hidden rounded-2xl border border-gray-200">
                <div class="overflow-x-auto max-h-96 custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                        Nama
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Jabatan
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        Lokasi Kerja
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        Tanggal Masuk
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($karyawanLapangans as $index => $karyawanLapangan)
                            <tr class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 cursor-pointer">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-4">
                                            {{ strtoupper(substr($karyawanLapangan['nama'], 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                {{ $karyawanLapangan['nama'] }}
                                            </div>
                                            <div class="text-xs text-gray-500">ID: {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                                        {{ $karyawanLapangan['jabatan'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-900">
                                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $karyawanLapangan['lokasi_kerja'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-900">
                                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $karyawanLapangan['lama_kerja'] }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if(count($karyawanLapangans) === 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada karyawan</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada data karyawan lapangan yang tersedia.</p>
            </div>
            @endif
        </div>
    </div>
</div>


<!-- Modals -->
@include('user.modals.modal-input-pemupukan')
@include('user.modals.modal-input-produksi')


<style>
    /* Enhanced Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: linear-gradient(to bottom, #f8fafc, #e2e8f0);
        border-radius: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #cbd5e0, #94a3b8);
        border-radius: 8px;
        border: 2px solid #f8fafc;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #94a3b8, #64748b);
    }

    /* Smooth animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Glass morphism effect */
    .glass-effect {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    /* Hover effects for cards */
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>