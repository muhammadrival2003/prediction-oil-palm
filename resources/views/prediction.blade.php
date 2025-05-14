<div class="container">
    <h2>Prediksi Hasil Produksi</h2>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    
    <form method="POST" action="{{ route('predict') }}">
        @csrf
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="year" class="form-label">Tahun</label>
                <select class="form-select" id="year" name="year" required>
                    <option value="">Pilih Tahun</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="month" class="form-label">Bulan</label>
                <select class="form-select" id="month" name="month" required>
                    <option value="">Pilih Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('month') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-calculator"></i> Prediksi
        </button>
    </form>
    
    @if(session('prediction'))
    <div class="card mt-4">
        <div class="card-header">
            Hasil Prediksi untuk {{ session('input.tahun') }}-{{ str_pad(session('input.bulan'), 2, '0', STR_PAD_LEFT) }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Data Historis Terakhir:</h5>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Curah Hujan:</strong> 
                            {{ number_format(session('input.last_values.curah_hujan'), 1) }} mm
                        </li>
                        <li class="list-group-item">
                            <strong>Pemupukan:</strong> 
                            {{ number_format(session('input.last_values.pemupukan'), 1) }} kg
                        </li>
                        <li class="list-group-item">
                            <strong>Hasil Produksi:</strong> 
                            {{ number_format(session('input.last_values.hasil_produksi'), 0, ',', '.') }} ton
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-info">
                        <h4>Hasil Prediksi Bulan Berikutnya:</h4>
                        <p class="display-6">{{ number_format(session('prediction'), 0, ',', '.') }} ton</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>