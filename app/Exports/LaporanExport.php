<?php

namespace App\Exports;

use App\Models\Blok;
use App\Models\HasilProduksi;
use App\Models\Pemupukan;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Ringkasan' => new RingkasanSheet(),
            'Produksi Per Blok' => new ProduksiPerBlokSheet(),
            'Pemupukan' => new PemupukanSheet(),
            'Produksi 12 Bulan' => new Produksi12BulanSheet(),
        ];
    }
}

class RingkasanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        $totalBlok = Blok::count();
        $totalPokok = Blok::sum('jumlah_pokok');
        $totalProduksiBulanIni = HasilProduksi::whereRaw('EXTRACT(MONTH FROM tanggal) = ?', [Carbon::now()->month])
            ->whereRaw('EXTRACT(YEAR FROM tanggal) = ?', [Carbon::now()->year])
            ->sum('realisasi_produksi') ?? 0;
        $totalPemupukanBulanIni = Pemupukan::whereRaw('EXTRACT(MONTH FROM tanggal) = ?', [Carbon::now()->month])
            ->whereRaw('EXTRACT(YEAR FROM tanggal) = ?', [Carbon::now()->year])
            ->sum('volume') ?? 0;

        return collect([
            (object)[
                'metric' => 'Total Blok',
                'value' => $totalBlok,
                'unit' => 'blok'
            ],
            (object)[
                'metric' => 'Total Pokok',
                'value' => $totalPokok,
                'unit' => 'pokok'
            ],
            (object)[
                'metric' => 'Produksi Bulan Ini',
                'value' => $totalProduksiBulanIni,
                'unit' => 'kg'
            ],
            (object)[
                'metric' => 'Pemupukan Bulan Ini',
                'value' => $totalPemupukanBulanIni,
                'unit' => 'kg'
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Metrik',
            'Nilai',
            'Satuan'
        ];
    }

    public function map($row): array
    {
        return [
            $row->metric,
            number_format($row->value),
            $row->unit
        ];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }
}

class ProduksiPerBlokSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return HasilProduksi::select('blok_id', DB::raw('SUM(realisasi_produksi) as total_produksi'))
            ->with('blok')
            ->groupBy('blok_id')
            ->orderBy('total_produksi', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Blok',
            'Total Produksi (kg)',
            'Status'
        ];
    }

    public function map($row): array
    {
        $status = 'Rendah';
        if ($row->total_produksi > 10000) {
            $status = 'Tinggi';
        } elseif ($row->total_produksi > 5000) {
            $status = 'Sedang';
        }

        return [
            $row->blok->nama_blok ?? 'N/A',
            number_format($row->total_produksi),
            $status
        ];
    }

    public function title(): string
    {
        return 'Produksi Per Blok';
    }
}

class PemupukanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return Pemupukan::select('jenis_pupuk_id', DB::raw('SUM(volume) as total_volume'))
            ->with('jenisPupuk')
            ->groupBy('jenis_pupuk_id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Jenis Pupuk',
            'Total Volume (kg)'
        ];
    }

    public function map($row): array
    {
        return [
            $row->jenisPupuk->nama ?? 'N/A',
            number_format($row->total_volume)
        ];
    }

    public function title(): string
    {
        return 'Pemupukan';
    }
}

class Produksi12BulanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return HasilProduksi::select(
                DB::raw('EXTRACT(YEAR FROM tanggal)::integer as year'),
                DB::raw('EXTRACT(MONTH FROM tanggal)::integer as month'),
                DB::raw('SUM(realisasi_produksi) as total_produksi')
            )
            ->where('tanggal', '>=', Carbon::now()->subMonths(12))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM tanggal)'), DB::raw('EXTRACT(MONTH FROM tanggal)'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM tanggal)'), 'asc')
            ->orderBy(DB::raw('EXTRACT(MONTH FROM tanggal)'), 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Bulan',
            'Tahun',
            'Total Produksi (kg)'
        ];
    }

    public function map($row): array
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return [
            $months[$row->month] ?? $row->month,
            $row->year,
            number_format($row->total_produksi)
        ];
    }

    public function title(): string
    {
        return 'Produksi 12 Bulan';
    }
}