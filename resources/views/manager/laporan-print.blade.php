<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kebun Kelapa Sawit - Print</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
            .page-break { page-break-before: always; }
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .btn-print {
            background-color: #3b82f6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-print:hover {
            background-color: #2563eb;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        
        .card h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 14px;
        }
        
        .card .value {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .card .unit {
            color: #666;
            font-size: 11px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section h2 {
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        
        .status-tinggi {
            background-color: #10b981;
        }
        
        .status-sedang {
            background-color: #f59e0b;
        }
        
        .status-rendah {
            background-color: #3b82f6;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        @media (max-width: 768px) {
            .two-column {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="print-button no-print">
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
        <button class="btn-print" onclick="window.close()" style="background-color: #6b7280; margin-left: 10px;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>Laporan Komprehensif</h1>
        <p>Unit Kebun Lama - Kelapa Sawit</p>
        <p>Tanggal: {{ Carbon\Carbon::now()->format('d F Y') }}</p>
        <p>Periode: {{ Carbon\Carbon::now()->subMonths(12)->format('F Y') }} - {{ Carbon\Carbon::now()->format('F Y') }}</p>
    </div>

    <!-- Summary Cards -->
    <div class="summary-grid">
        <div class="card">
            <h3>Total Blok</h3>
            <div class="value">{{ number_format($totalBlok) }}</div>
            <div class="unit">Blok Aktif</div>
        </div>
        <div class="card">
            <h3>Total Pokok</h3>
            <div class="value">{{ number_format($totalPokok) }}</div>
            <div class="unit">Pohon Kelapa Sawit</div>
        </div>
        <div class="card">
            <h3>Produksi Bulan Ini</h3>
            <div class="value">{{ number_format($totalProduksiBulanIni) }}</div>
            <div class="unit">Kilogram TBS</div>
        </div>
        <div class="card">
            <h3>Pemupukan Bulan Ini</h3>
            <div class="value">{{ number_format($totalPemupukanBulanIni) }}</div>
            <div class="unit">Kilogram Pupuk</div>
        </div>
    </div>

    <!-- Produksi Per Blok -->
    <div class="section">
        <h2>Produksi Per Blok</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Blok</th>
                    <th>Total Produksi (kg)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produksiPerBlok as $index => $produksi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $produksi->blok->nama_blok ?? 'N/A' }}</td>
                    <td>{{ number_format($produksi->total_produksi) }}</td>
                    <td>
                        @if($produksi->total_produksi > 10000)
                            <span class="status-badge status-tinggi">Tinggi</span>
                        @elseif($produksi->total_produksi > 5000)
                            <span class="status-badge status-sedang">Sedang</span>
                        @else
                            <span class="status-badge status-rendah">Rendah</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Two Column Layout -->
    <div class="two-column">
        <!-- Pemupukan Per Jenis -->
        <div>
            <div class="section">
                <h2>Pemupukan Per Jenis</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Jenis Pupuk</th>
                            <th>Total Volume (kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemupukanPerJenis as $pemupukan)
                        <tr>
                            <td>{{ $pemupukan->jenisPupuk->nama ?? 'N/A' }}</td>
                            <td>{{ number_format($pemupukan->total_volume) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Produksi 12 Bulan Terakhir -->
        <div>
            <div class="section">
                <h2>Produksi 12 Bulan Terakhir</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Bulan/Tahun</th>
                            <th>Produksi (kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produksi12Bulan as $produksi)
                        @php
                            $months = [
                                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                                5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                                9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                            ];
                        @endphp
                        <tr>
                            <td>{{ $months[$produksi->month] ?? $produksi->month }} {{ $produksi->year }}</td>
                            <td>{{ number_format($produksi->total_produksi) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="section page-break">
        <h2>Aktivitas Terbaru</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aktivitasTerbaru as $aktivitas)
                <tr>
                    <td>{{ $aktivitas->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $aktivitas->user->name ?? 'System' }}</td>
                    <td>{{ $aktivitas->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem Manajemen Kebun Kelapa Sawit</p>
        <p>Dicetak pada: {{ Carbon\Carbon::now()->format('d F Y, H:i:s') }} WIB</p>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>