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
        // Dapatkan afdeling_id dari user yang login
        $afdeling_id = auth()->user()->afdeling_id;

        $data = [
            'totalTahunTanam' => TahunTanam::count('tahun_tanam'),
            'totalBlok' => Blok::count('nama_blok'),
            'totalPokok' => Blok::sum('jumlah_pokok'),
            'totalProduksi' => Produksi::sum('production'),
            'bloks' => Blok::all(),
            'recentActivities' => $this->getRecentActivities(),
            'karyawanLapangans' => $this->getKaryawanLapangans($afdeling_id),
            'jenisPupuks' => JenisPupuk::all(),
            'afdeling_id' => $afdeling_id
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
        $query = KaryawanLapangan::whereIn('jabatan', [
            'MDR Panen',
            'MDR Pemeliharaan',
            'Petugas Timbang BRD',
            'Mandor'
        ])->with('afdeling');

        // Filter berdasarkan afdeling_id jika tersedia
        if ($afdeling_id) {
            $query->where('afdeling_id', $afdeling_id);
        }

        return $query->get()->map(function ($karyawan) {
            return [
                'id' => $karyawan->id,
                'nama' => $karyawan->nama,
                'jabatan' => $karyawan->jabatan,
                'afdeling' => $karyawan->afdeling->nama,
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
