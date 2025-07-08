<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold text-gray-800">Masukkan Data Hasil Produksi</h3>
        <i class="fas fa-edit text-indigo-500"></i>
    </div>

    <form action="{{ route('hasil-produksi.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="blok_id" value="{{ request('blok_id', old('blok_id')) }}">

        <div>
            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
            <input id="tanggal" name="tanggal" type="date"
                class="w-full py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                value="{{ old('tanggal', date('Y-m-d')) }}"
                required>
        </div>

        <div>
            <label for="blok_id" class="block text-sm font-medium text-gray-700 mb-1">Blok</label>
            <select id="blok_id" name="blok_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                required>
                <option value="">Pilih Blok</option>
                @foreach($bloks as $blok)
                <option value="{{ $blok->id }}" {{ old('blok_id') == $blok->id ? 'selected' : '' }}>
                    {{ $blok->nama_blok }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="rencana_produksi" class="block text-sm font-medium text-gray-700 mb-1">Rencana Produksi (kg)</label>
            <input id="rencana_produksi" name="rencana_produksi" type="number" step="0.01"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="0.00"
                value="{{ old('rencana_produksi') }}"
                required>
        </div>

        <div>
            <label for="realisasi_produksi" class="block text-sm font-medium text-gray-700 mb-1">Realisasi Produksi (kg)</label>
            <input id="realisasi_produksi" name="realisasi_produksi" type="number" step="0.01"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="0.00"
                value="{{ old('realisasi_produksi') }}"
                required>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-indigo-500 text-white py-3 px-4 rounded-lg hover:from-indigo-700 hover:to-indigo-600 transition-all duration-300 shadow-md flex items-center justify-center">
            <i class="fas fa-save mr-2"></i> Simpan Data
        </button>
    </form>
</div>