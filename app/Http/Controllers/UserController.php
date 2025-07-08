<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Blok;
use App\Models\JenisPupuk;
use App\Models\KaryawanLapangan;
use App\Models\Produksi;
use App\Models\TahunTanam;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function beranda()
    {
        $data = [
            'totalTahunTanam' => TahunTanam::count('tahun_tanam'),
            'totalBlok' => Blok::count('nama_blok'),
            'totalPokok' => Blok::sum('jumlah_pokok'),
            'totalProduksi' => Produksi::sum('production'),
            'bloks' => Blok::all(),
            'recentActivities' => $this->getRecentActivities(),
            'karyawanLapangans' => $this->getKaryawanLapangans(1),
            'jenisPupuks' => JenisPupuk::all()
        ];

        return view('user.beranda')->with($data);
    }

    // Method baru untuk mengambil aktivitas terkini
    private function getRecentActivities()
    {
        return ActivityLog::with(['user', 'blok'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'type' => $activity->activity_type,
                    'description' => $activity->description,
                    'blok' => $activity->blok->nama_blok,
                    'weight' => $activity->data['weight'] ?? 0,
                    'date' => $activity->created_at,
                    'icon' => $this->getActivityIcon($activity->activity_type),
                    'color' => $this->getActivityColor($activity->activity_type)
                ];
            });
    }

    private function getKaryawanLapangans($afdeling_id = null)
    {
        // Query dasar untuk karyawan lapangan (exclude posisi non-lapangan jika diperlukan)
        $query = KaryawanLapangan::whereIn('jabatan', [
            'MDR Panen',
            'MDR Pemeliharaan',
            'Petugas Timbang BRD',
            'Mandor'
        ])->with('afdeling');

        // Filter berdasarkan afdeling_id jika diberikan
        if ($afdeling_id) {
            $query->where('afdeling_id', $afdeling_id);
        }

        // Ambil data dan format sesuai kebutuhan
        return $query->get()->map(function ($karyawan) {
            return [
                'id' => $karyawan->id,
                'nama' => $karyawan->nama,
                'jabatan' => $karyawan->jabatan,
                'afdeling' => $karyawan->afdeling->nama, // asumsi model Afdeling memiliki kolom 'nama'
                'lokasi_kerja' => $karyawan->lokasi_kerja,
                'lama_kerja' => $karyawan->tanggal_masuk->diffForHumans(),
            ];
        });
    }

    // Helper untuk icon aktivitas
    private function getActivityIcon($type)
    {
        return match ($type) {
            'verified' => 'fa-check',
            'created' => 'fa-plus',
            'pending' => 'fa-exclamation',
            'updated' => 'fa-edit',
            default => 'fa-circle'
        };
    }

    // Helper untuk warna aktivitas
    private function getActivityColor($type)
    {
        return match ($type) {
            'verified' => 'green',
            'created' => 'blue',
            'pending' => 'yellow',
            'updated' => 'purple',
            default => 'gray'
        };
    }

    // public function storeProduksi(Request $request)
    // {
    //     $validated = $request->validate([
    //         'tanggal' => 'required|date',
    //         'blok_id' => 'required|exists:bloks,id',
    //         'hasil_produksi' => 'required|numeric|min:0'
    //     ]);

    //     $produksi = Produksi::create($validated);

    //     $blok = Blok::find($validated['blok_id']);

    //     if ($request->wantsJson()) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => "Data produksi blok {$blok->nama_blok} berhasil disimpan",
    //             'data' => $produksi
    //         ]);
    //     }

    //     return redirect()->back()->with('success', "Data produksi blok {$blok->nama_blok} berhasil disimpan");
    // }


}
