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
use App\Models\Afdeling;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use GuzzleHttp\Client;

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
            ->with(['blok.tahunTanam.afdeling'])
            ->groupBy('blok_id')
            ->orderBy('total_produksi', 'desc')
            ->get();

        // Aktivitas terbaru
        $aktivitasTerbaru = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Data prediksi yang sudah tersedia (read-only untuk manager)
        $prediksiTerbaru = Prediction::orderBy('created_at', 'desc')->take(5)->get();
        $totalPrediksi = Prediction::count();
        $prediksiRataRata = Prediction::avg('prediction');
        
        // Data untuk chart perbandingan prediksi vs aktual
        $perbandinganPrediksiAktual = $this->getPerbandinganPrediksiAktual();
        
        // Akurasi model (jika ada data aktual)
        $akurasiModel = $this->hitungAkurasiModel();

        return view('manager.laporan', compact(
            'totalBlok',
            'totalPokok', 
            'totalProduksiBulanIni',
            'totalPemupukanBulanIni',
            'produksi12Bulan',
            'pemupukanPerJenis',
            'produksiPerBlok',
            'aktivitasTerbaru',
            'prediksiTerbaru',
            'totalPrediksi',
            'prediksiRataRata',
            'perbandinganPrediksiAktual',
            'akurasiModel'
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

    public function downloadPDF()
    {
        // Get the same data as laporan method
        $data = $this->getLaporanData();
        
        // Return the PDF view with download headers
        $filename = 'laporan-kebun-' . Carbon::now()->format('Y-m-d') . '.html';
        
        return response()
            ->view('manager.laporan-pdf', $data)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function downloadExcel()
    {
        return Excel::download(new LaporanExport, 'laporan-kebun-' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }

    public function printLaporan()
    {
        // Get the same data as laporan method
        $data = $this->getLaporanData();
        
        return view('manager.laporan-print', $data);
    }

    public function laporanAfdeling()
    {
        // Data laporan berdasarkan afdeling
        $laporanPerAfdeling = Afdeling::with(['tahunTanams.bloks'])
            ->get()
            ->map(function ($afdeling) {
                // Hitung total blok per afdeling
                $totalBlok = $afdeling->tahunTanams->sum(function ($tahunTanam) {
                    return $tahunTanam->bloks->count();
                });

                // Hitung total pokok per afdeling
                $totalPokok = $afdeling->tahunTanams->sum(function ($tahunTanam) {
                    return $tahunTanam->bloks->sum('jumlah_pokok');
                });

                // Hitung total produksi per afdeling
                $blokIds = $afdeling->tahunTanams->flatMap(function ($tahunTanam) {
                    return $tahunTanam->bloks->pluck('id');
                });

                $totalProduksi = HasilProduksi::whereIn('blok_id', $blokIds)
                    ->sum('realisasi_produksi') ?? 0;

                // Hitung total pemupukan per afdeling
                $totalPemupukan = Pemupukan::whereIn('blok_id', $blokIds)
                    ->sum('volume') ?? 0;

                // Produksi bulan ini per afdeling
                $produksiBulanIni = HasilProduksi::whereIn('blok_id', $blokIds)
                    ->whereRaw('EXTRACT(MONTH FROM tanggal) = ?', [Carbon::now()->month])
                    ->whereRaw('EXTRACT(YEAR FROM tanggal) = ?', [Carbon::now()->year])
                    ->sum('realisasi_produksi') ?? 0;

                // Pemupukan bulan ini per afdeling
                $pemupukanBulanIni = Pemupukan::whereIn('blok_id', $blokIds)
                    ->whereRaw('EXTRACT(MONTH FROM tanggal) = ?', [Carbon::now()->month])
                    ->whereRaw('EXTRACT(YEAR FROM tanggal) = ?', [Carbon::now()->year])
                    ->sum('volume') ?? 0;

                // Rata-rata produksi per pokok
                $rataRataProduksiPerPokok = $totalPokok > 0 ? $totalProduksi / $totalPokok : 0;

                // Efisiensi pemupukan (produksi per kg pupuk)
                $efisiensiPemupukan = $totalPemupukan > 0 ? $totalProduksi / $totalPemupukan : 0;

                return [
                    'afdeling' => $afdeling,
                    'total_blok' => $totalBlok,
                    'total_pokok' => $totalPokok,
                    'total_produksi' => $totalProduksi,
                    'total_pemupukan' => $totalPemupukan,
                    'produksi_bulan_ini' => $produksiBulanIni,
                    'pemupukan_bulan_ini' => $pemupukanBulanIni,
                    'rata_rata_produksi_per_pokok' => $rataRataProduksiPerPokok,
                    'efisiensi_pemupukan' => $efisiensiPemupukan,
                ];
            });

        // Data produksi per afdeling untuk chart
        $produksiPerAfdelingChart = Afdeling::with(['tahunTanams.bloks'])
            ->get()
            ->map(function ($afdeling) {
                $blokIds = $afdeling->tahunTanams->flatMap(function ($tahunTanam) {
                    return $tahunTanam->bloks->pluck('id');
                });

                $totalProduksi = HasilProduksi::whereIn('blok_id', $blokIds)
                    ->sum('realisasi_produksi') ?? 0;

                return [
                    'nama' => $afdeling->nama,
                    'total_produksi' => $totalProduksi
                ];
            });

        // Data trend produksi 6 bulan terakhir per afdeling
        $trendProduksiAfdeling = Afdeling::with(['tahunTanams.bloks'])
            ->get()
            ->map(function ($afdeling) {
                $blokIds = $afdeling->tahunTanams->flatMap(function ($tahunTanam) {
                    return $tahunTanam->bloks->pluck('id');
                });

                $produksi6Bulan = HasilProduksi::whereIn('blok_id', $blokIds)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM tanggal)::integer as year'),
                        DB::raw('EXTRACT(MONTH FROM tanggal)::integer as month'),
                        DB::raw('SUM(realisasi_produksi) as total_produksi')
                    )
                    ->where('tanggal', '>=', Carbon::now()->subMonths(6))
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM tanggal)'), DB::raw('EXTRACT(MONTH FROM tanggal)'))
                    ->orderBy(DB::raw('EXTRACT(YEAR FROM tanggal)'), 'asc')
                    ->orderBy(DB::raw('EXTRACT(MONTH FROM tanggal)'), 'asc')
                    ->get();

                return [
                    'nama' => $afdeling->nama,
                    'data' => $produksi6Bulan
                ];
            });

        // Detail blok per afdeling
        $detailBlokPerAfdeling = Afdeling::with(['tahunTanams.bloks'])
            ->get()
            ->map(function ($afdeling) {
                $bloks = $afdeling->tahunTanams->flatMap(function ($tahunTanam) {
                    return $tahunTanam->bloks->map(function ($blok) use ($tahunTanam) {
                        // Hitung produksi per blok
                        $produksiBlok = HasilProduksi::where('blok_id', $blok->id)
                            ->sum('realisasi_produksi') ?? 0;

                        // Hitung pemupukan per blok
                        $pemupukanBlok = Pemupukan::where('blok_id', $blok->id)
                            ->sum('volume') ?? 0;

                        return [
                            'blok' => $blok,
                            'tahun_tanam' => $tahunTanam,
                            'produksi' => $produksiBlok,
                            'pemupukan' => $pemupukanBlok,
                            'produktivitas' => $blok->jumlah_pokok > 0 ? $produksiBlok / $blok->jumlah_pokok : 0
                        ];
                    });
                });

                return [
                    'afdeling' => $afdeling,
                    'bloks' => $bloks
                ];
            });

        return view('manager.laporan-afdeling', compact(
            'laporanPerAfdeling',
            'produksiPerAfdelingChart',
            'trendProduksiAfdeling',
            'detailBlokPerAfdeling'
        ));
    }

    private function getLaporanData()
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
            ->with(['blok.tahunTanam.afdeling'])
            ->groupBy('blok_id')
            ->orderBy('total_produksi', 'desc')
            ->get();

        // Aktivitas terbaru
        $aktivitasTerbaru = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return compact(
            'totalBlok',
            'totalPokok', 
            'totalProduksiBulanIni',
            'totalPemupukanBulanIni',
            'produksi12Bulan',
            'pemupukanPerJenis',
            'produksiPerBlok',
            'aktivitasTerbaru'
        );
    }

    /**
     * Dapatkan data perbandingan prediksi vs aktual
     */
    private function getPerbandinganPrediksiAktual()
    {
        $perbandingan = [];
        
        // Ambil prediksi yang sudah memiliki data aktual
        $predictions = Prediction::where('year', '<=', Carbon::now()->year)
            ->where(function($query) {
                $query->where('year', '<', Carbon::now()->year)
                      ->orWhere(function($q) {
                          $q->where('year', '=', Carbon::now()->year)
                            ->where('month', '<=', Carbon::now()->month);
                      });
            })
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        foreach ($predictions as $prediction) {
            // Cari data produksi aktual untuk bulan dan tahun yang sama
            $actualProduction = HasilProduksi::whereRaw('EXTRACT(YEAR FROM tanggal) = ?', [$prediction->year])
                ->whereRaw('EXTRACT(MONTH FROM tanggal) = ?', [$prediction->month])
                ->sum('realisasi_produksi');

            if ($actualProduction > 0) {
                $perbandingan[] = [
                    'period' => $prediction->month . '/' . $prediction->year,
                    'predicted' => $prediction->prediction,
                    'actual' => $actualProduction,
                    'accuracy' => $this->hitungAkurasi($prediction->prediction, $actualProduction)
                ];
            }
        }

        return $perbandingan;
    }

    /**
     * Hitung akurasi model secara keseluruhan
     */
    private function hitungAkurasiModel()
    {
        $perbandingan = $this->getPerbandinganPrediksiAktual();
        
        if (empty($perbandingan)) {
            return null;
        }

        $totalAccuracy = array_sum(array_column($perbandingan, 'accuracy'));
        return $totalAccuracy / count($perbandingan);
    }

    /**
     * Hitung akurasi antara prediksi dan aktual
     */
    private function hitungAkurasi($predicted, $actual)
    {
        if ($actual == 0) return 0;
        
        $error = abs($predicted - $actual) / $actual;
        return max(0, (1 - $error) * 100);
    }
}
