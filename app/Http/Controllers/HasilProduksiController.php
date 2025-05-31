<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Blok;
use App\Models\HasilProduksi;
use Illuminate\Http\Request;

class HasilProduksiController extends Controller
{
    public function index()
    {
        $bloks = Blok::all();
        $hasilProduksi = HasilProduksi::with('blok')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('dashboard', compact('bloks', 'hasilProduksi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blok_id' => 'required|exists:bloks,id',
            'tanggal' => 'required|date',
            'rencana_produksi' => 'required|numeric|min:0',
            'realisasi_produksi' => 'required|numeric|min:0'
        ]);

        $hasilProduksi = HasilProduksi::create($validated);

        $this->logActivity(
            auth()->id(),
            $hasilProduksi->blok_id,
            'updated',
            'Memperbarui data produksi',
            ['weight' => $validated['rencana_produksi']]
        );

        // Update dataset sistem
        $this->updateDatasetSistem($hasilProduksi->tanggal);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    protected function updateDatasetSistem($tanggal)
    {
        $bulan = date('n', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $totalProduksi = HasilProduksi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('realisasi_produksi');

        \App\Models\DatasetSistem::updateOrCreate(
            ['bulan' => $bulan, 'tahun' => $tahun],
            ['total_hasil_produksi' => $totalProduksi]
        );
    }

    // Method baru untuk log aktivitas
    private function logActivity($userId, $blokId, $type, $description, $data = [])
    {
        ActivityLog::create([
            'user_id' => $userId,
            'blok_id' => $blokId,
            'activity_type' => $type,
            'description' => $description,
            'data' => $data
        ]);
    }
}
