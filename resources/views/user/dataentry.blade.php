<!-- Left Column - Data Entry Pemupukan -->
<div class="bg-white p-7 rounded-xl shadow-sm border border-gray-100">
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">Terjadi kesalahan:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    
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

<!-- Data Karyawan Lapangan -->
<div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold text-gray-800">Karyawan Lapangan</h3>
        <i class="fas fa-table text-purple-500"></i>
    </div>

    <!-- Container dengan tinggi tetap dan scroll -->
    <div class="overflow-x-auto flex-grow" style="max-height: 400px;">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 sticky top-0 z-10">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi Kerja</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal masuk</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($karyawanLapangans as $karyawanLapangan)
                <tr class="hover:bg-gray-50 cursor-pointer transition-colors">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $karyawanLapangan['nama'] }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                        {{ $karyawanLapangan['jabatan'] }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                        {{ $karyawanLapangan['lokasi_kerja'] }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                        {{ $karyawanLapangan['lama_kerja'] }}
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