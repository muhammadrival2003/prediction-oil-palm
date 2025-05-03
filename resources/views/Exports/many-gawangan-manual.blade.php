<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Gawangan Manual</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <!-- <link href="{{ asset('css/report.css') }}" rel="stylesheet"> -->
</head>

<body>
    <table class="header-table">
        <tr>
            <td colspan="4" class="text-center subtitle">
                <h3>KEBUN LAMA</h3>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center subtitle">
                <!-- Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }}<br>
                Oleh: {{ Auth::user()->name ?? 'System' }} -->
                TAHUN : 2025
            </td>
        </tr>
        <tr>
            <td colspan="30" class="text-center title">
                <h2>RENCANAN PEKERJAAN MANY GAWANGAN MANUAL</h2>
            </td>
        </tr>
        @if($startDate && $endDate)
        <tr>
            <td colspan="3" class="text-center period-info">
                <strong>PERIODE LAPORAN:</strong>
                {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
            </td>
        </tr>
        @endif
    </table>

    @if($startDate && $endDate)
    <div class="period-info">
        <strong>PERIODE LAPORAN:</strong>
        {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} -
        {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <!-- <th style="background:#2c7be5; color:white; padding:8px; text-align:center; border:1px solid white;" rowspan="3">NO</th> -->
                <th rowspan="3">NO</th>
                <th rowspan="3">TAHUN <br> TANAM</th>
                <th rowspan="3">TANGGAL</th>
                <th rowspan="3">BLOK</th>
                <th rowspan="3">LUAS <br> LAHAN (Ha)</th>
                <th rowspan="3">JUMLAH <br> POKOK</th>
                <th colspan="24">BULAN</th>
                <th colspan="2">JUMLAH</th>
            </tr>
            <tr>
                @foreach(['JAN', 'FEB', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPT', 'OKT', 'NOP', 'DES'] as $month)
                <th colspan="2">{{ $month }}</th>
                @endforeach
                <th rowspan="2">RENCANA</th>
                <th rowspan="2">REALISASI</th>
            </tr>
            <tr>
                @foreach(['JAN', 'FEB', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPT', 'OKT', 'NOP', 'DES'] as $month)
                <th>RENC</th>
                <th>REAL</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
            // Group data by tahun tanam
            $groupedData = $gawangans->groupBy(function($item) {
            return $item->blok->tahunTanam->tahun_tanam ?? '';
            })->sortBy(function($group, $year) {
            return $year; // Sort by tahun tanam
            });

            $counter = 1;
            $grandTotalRencana = 0;
            $grandTotalRealisasi = 0;

            @endphp

            @foreach($groupedData as $tahun_tanam => $items)
            @php
            $rowCount = count($items);
            $firstRow = true;
            $subtotalRencana = 0;
            $subtotalRealisasi = 0;

            $subtotalRencana = $items->sum('total_rencana');
            $subtotalRealisasi = $items->sum('total_realisasi');

            $grandTotalRencana += $subtotalRencana;
            $grandTotalRealisasi += $subtotalRealisasi;
            @endphp

            @foreach($items as $index => $gawangan)
            <tr @if($firstRow) class="year-group" @endif>
                @if($firstRow)
                <td rowspan="{{ $rowCount + 1 }}">{{ $counter++ }}</td>
                <td rowspan="{{ $rowCount + 1 }}">{{ $tahun_tanam }}</td>
                @php $firstRow = false; @endphp
                @endif

                <td>{{ $gawangan->tanggal }}</td>
                <td>{{ $gawangan->blok->nama_blok ?? '' }}</td>
                <td>{{ $gawangan->blok->luas_lahan ?? '' }}</td>
                <td>{{ $gawangan->blok->jumlah_pokok ?? '' }}</td>

                @foreach(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'] as $month)
                <!-- Rencana -->
                <td>{{ empty($gawangan->getRencanaForMonth($month)) ? '-' : $gawangan->getRencanaForMonth($month) }}</td>

                <!-- Realisasi -->
                <td>{{ empty($gawangan->getRealisasiForMonth($month)) ? '-' : $gawangan->getRealisasiForMonth($month) }}</td>
                @endforeach

                <td>{{ $gawangan->total_rencana ?? '-' }}</td>
                <td>{{ $gawangan->total_realisasi ?? '-' }}</td>
            </tr>
            @php
            $subtotalRencana += $gawangan->total_rencana ?? 0;
            $subtotalRealisasi += $gawangan->total_realisasi ?? 0;
            @endphp
            @endforeach

            <!-- Subtotal per tahun tanam -->
            <tr class="subtotal-row" style="background-color: #00ac69;">
                <td colspan="2">JUMLAH</td>
                <td>{{ ($luas = $items->sum(fn($item) => $item->blok->luas_lahan ?? 0)) ? $luas : '-' }}</td>
                <td>{{ ($pokok = $items->sum(fn($item) => $item->blok->jumlah_pokok ?? 0)) ? $pokok : '-' }}</td>

                @foreach(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'] as $month)
                <td>{{ ($rencana = $items->sum(fn($item) => $item->getRencanaForMonth($month) ?? 0)) ? $rencana : '-' }}</td>
                <td>{{ ($realisasi = $items->sum(fn($item) => $item->getRealisasiForMonth($month) ?? 0)) ? $realisasi : '-' }}</td>
                @endforeach

                <td>{{ $subtotalRencana ?: '-' }}</td>
                <td>{{ $subtotalRealisasi ?: '-' }}</td>
            </tr>

            @php
            $grandTotalRencana += $subtotalRencana;
            $grandTotalRealisasi += $subtotalRealisasi;
            @endphp
            @endforeach

            <!-- Grand Total -->
            <tr class="grand-total-row">
                <td colspan="4">TOTAL</td>

                <td>{{ ($luas = $gawangans->sum(fn($item) => $item->blok->luas_lahan ?? 0)) ? number_format($luas) : '-' }}</td>
                <td>{{ ($pokok = $gawangans->sum(fn($item) => $item->blok->jumlah_pokok ?? 0)) ? number_format($pokok) : '-' }}</td>

                @foreach(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'] as $month)
                <td>{{ ($rencana = $gawangans->sum(fn($item) => $item->getRencanaForMonth($month) ?? 0)) ? number_format($rencana) : '-' }}</td>
                <td>{{ ($realisasi = $gawangans->sum(fn($item) => $item->getRealisasiForMonth($month) ?? 0)) ? number_format($realisasi) : '-' }}</td>
                @endforeach

                <!-- Tambahkan perhitungan untuk kolom RENCANA dan REALISASI -->
                <td>{{ $grandTotalRencana ? number_format($grandTotalRencana) : '-' }}</td>
                <td>{{ $grandTotalRealisasi ? number_format($grandTotalRealisasi) : '-' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }}<br>
        Oleh: {{ Auth::user()->name ?? 'System' }}
    </div> -->
</body>

</html>