<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold text-gray-800">Masukkan Data Pemupukan</h3>
        <i class="fas fa-edit text-indigo-500"></i>
    </div>

    <form action="{{ route('pemupukan.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="blok_id" value="{{ request('blok_id', old('blok_id')) }}">

        <div>
            <label for="tanggal_pemupukan" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pemupukan</label>
            <div class="relative">
                <input id="tanggal_pemupukan" name="tanggal" type="date"
                    class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('tanggal', date('Y-m-d')) }}"
                    required>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-calendar text-gray-400"></i>
                </div>
            </div>
        </div>

        <div>
            <label for="blok_pemupukan" class="block text-sm font-medium text-gray-700 mb-1">Blok</label>
            <select id="blok_pemupukan" name="blok_id"
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
            <label for="dosis" class="block text-sm font-medium text-gray-700 mb-1">Dosis (kg/pokok)</label>
            <input id="dosis" name="dosis" type="number" step="0.01"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="0.00"
                value="{{ old('dosis') }}"
                required>
        </div>

        <div>
            <label for="volume" class="block text-sm font-medium text-gray-700 mb-1">Volume (kg)</label>
            <input id="volume" name="volume" type="number" step="0.01"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="0.00"
                value="{{ old('volume') }}"
                required>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-indigo-500 text-white py-3 px-4 rounded-lg hover:from-indigo-700 hover:to-indigo-600 transition-all duration-300 shadow-md flex items-center justify-center">
            <i class="fas fa-save mr-2"></i> Simpan Data
        </button>
    </form>
</div>