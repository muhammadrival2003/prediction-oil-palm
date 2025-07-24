<?php

namespace App\Http\Controllers;

use App\Models\Blok;
use App\Models\JenisPupuk;
use App\Models\Produksi;
use App\Models\TahunTanam;
use App\Models\HasilProduksi;
use App\Models\Pemupukan;
use App\Models\ActivityLog;
use App\Models\DatasetSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManagerController extends Controller
{
    public function beranda()
    {
        $data = [
            'totalTahunTanam' => TahunTanam::count('tahun_tanam'),
            'totalBlok' => Blok::count('nama_blok'),
            'totalPokok' => Blok::sum('jumlah_pokok'),
            'totalProduksi' => Produksi::sum('production'),
            'bloks' => Blok::all(),
            'jenisPupuks' => JenisPupuk::all(),
        ];

        return view('manager.beranda')->with($data);
    }

    public function laporan()
    {
        // Statistik umum
        $totalBlok = Blok::count();
        $totalPokok = Blok::sum('jumlah_pokok');
        $totalProduksiBulanIni = HasilProduksi::whereRaw('EXTRACT(MONTH FROM tanggal) = ?', [Carbon::now()->month])
            ->whereRaw('EXTRACT(YEAR FROM tanggal) = ?', [Carbon::now()->year])
            ->sum('realisasi_produksi') ?? 0;
        $totalPemupukanBulanIni = Pemupukan::whereRaw('EXTRACT(MONTH FROM tanggal) = ?', [Carbon::now()->month])
            ->whereRaw('EXTRACT(YEAR FROM tanggal) = ?', [Carbon::now()->year])
            ->sum('volume') ?? 0;

        // Data produksi 12 bulan terakhir
        $produksi12Bulan = HasilProduksi::select(
                DB::raw('EXTRACT(YEAR FROM tanggal)::integer as year'),
                DB::raw('EXTRACT(MONTH FROM tanggal)::integer as month'),
                DB::raw('SUM(realisasi_produksi) as total_produksi')
            )
            ->where('tanggal', '>=', Carbon::now()->subMonths(12))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM tanggal)'), DB::raw('EXTRACT(MONTH FROM tanggal)'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM tanggal)'), 'asc')
            ->orderBy(DB::raw('EXTRACT(MONTH FROM tanggal)'), 'asc')
            ->get();

        // Data pemupukan per jenis
        $pemupukanPerJenis = Pemupukan::select('jenis_pupuk_id', DB::raw('SUM(volume) as total_volume'))
            ->with('jenisPupuk')
            ->groupBy('jenis_pupuk_id')
            ->get();

        // Produksi per blok
        $produksiPerBlok = HasilProduksi::select('blok_id', DB::raw('SUM(realisasi_produksi) as total_produksi'))
            ->with('blok')
            ->groupBy('blok_id')
            ->orderBy('total_produksi', 'desc')
            ->get();

        // Aktivitas terbaru
        $aktivitasTerbaru = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('manager.laporan', compact(
            'totalBlok',
            'totalPokok', 
            'totalProduksiBulanIni',
            'totalPemupukanBulanIni',
            'produksi12Bulan',
            'pemupukanPerJenis',
            'produksiPerBlok',
            'aktivitasTerbaru'
        ));
    }

    public function statistik()
    {
        // Rata-rata produksi per blok
        $rataRataProduksiPerBlok = HasilProduksi::select('blok_id', DB::raw('AVG(realisasi_produksi) as rata_rata'))
            ->with('blok')
            ->groupBy('blok_id')
            ->get();

        // Trend produksi tahunan
        $trendProduksiTahunan = HasilProduksi::select(
                DB::raw('EXTRACT(YEAR FROM tanggal)::integer as year'),
                DB::raw('SUM(realisasi_produksi) as total_produksi'),
                DB::raw('AVG(realisasi_produksi) as rata_rata_produksi')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM tanggal)'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM tanggal)'), 'asc')
            ->get();

        // Efisiensi pemupukan (produksi vs pemupukan)
        $efisiensiPemupukan = DB::table('hasil_produksis as hp')
            ->join('pemupukans as p', function($join) {
                $join->on('hp.blok_id', '=', 'p.blok_id')
                     ->on(DB::raw('EXTRACT(YEAR FROM hp.tanggal)'), '=', DB::raw('EXTRACT(YEAR FROM p.tanggal)'))
                     ->on(DB::raw('EXTRACT(MONTH FROM hp.tanggal)'), '=', DB::raw('EXTRACT(MONTH FROM p.tanggal)'));
            })
            ->join('bloks as b', 'hp.blok_id', '=', 'b.id')
            ->select(
                'b.nama_blok',
                DB::raw('SUM(hp.realisasi_produksi) as total_produksi'),
                DB::raw('SUM(p.volume) as total_pemupukan'),
                DB::raw('SUM(hp.realisasi_produksi) / SUM(p.volume) as efisiensi')
            )
            ->groupBy('b.id', 'b.nama_blok')
            ->get();

        // Perbandingan rencana vs realisasi
        $perbandinganRencanaRealisasi = HasilProduksi::select(
                'blok_id',
                DB::raw('SUM(rencana_produksi) as total_rencana'),
                DB::raw('SUM(realisasi_produksi) as total_realisasi'),
                DB::raw('(SUM(realisasi_produksi) / SUM(rencana_produksi)) * 100 as persentase_pencapaian')
            )
            ->with('blok')
            ->groupBy('blok_id')
            ->get();

        return view('manager.statistik', compact(
            'rataRataProduksiPerBlok',
            'trendProduksiTahunan',
            'efisiensiPemupukan',
            'perbandinganRencanaRealisasi'
        ));
    }
}
