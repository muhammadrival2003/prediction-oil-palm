<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Blok;
use App\Models\DatasetSistem;
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
        try {
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
                'created',
                'Menambahkan data hasil produksi baru',
                ['weight' => $validated['realisasi_produksi']]
            );

            $this->updateDatasetSistem($hasilProduksi->tanggal);

            return redirect()->back()
                ->with('success', 'Data hasil produksi berhasil disimpan!')
                ->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->with('error', 'Terjadi kesalahan validasi!')
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    protected static function updateDatasetSistem($tanggal)
    {
        $month = date('n', strtotime($tanggal));
        $year = date('Y', strtotime($tanggal));

        $totalProduksi = HasilProduksi::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('realisasi_produksi');

        // Cari record dengan bulan dan tahun yang sama
        $existingRecord = DatasetSistem::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->first();

        if ($existingRecord) {
            // Update record yang sudah ada
            $existingRecord->update(['total_hasil_produksi' => $totalProduksi]);
        } else {
            // Buat record baru dengan tanggal pertama bulan tersebut
            DatasetSistem::create([
                'tanggal' => date('Y-m-01', strtotime($tanggal)),
                'total_hasil_produksi' => $totalProduksi
            ]);
        }
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
