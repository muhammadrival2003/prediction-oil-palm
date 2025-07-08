<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Blok;
use App\Models\DatasetSistem;
use App\Models\JenisPupuk;
use App\Models\Pemupukan;
use Illuminate\Http\Request;

class PemupukanController extends Controller
{
    // Di controller
    public function index()
    {
        $bloks = Blok::all();
        $pemupukans = Pemupukan::with('blok')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('dashboard', compact('bloks', 'pemupukans'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'blok_id' => 'required|exists:bloks,id',
                'jenis_pupuk_id' => 'required|exists:jenis_pupuks,id',
                'tanggal' => 'required|date',
                'dosis' => 'required|numeric|min:0',
                'volume' => 'required|numeric|min:0'
            ]);

            $pemupukan = Pemupukan::create($validated);

            $this->logActivity(
                auth()->id(),
                $pemupukan->blok_id,
                'created',
                'Menambahkan data pemupukan baru',
                ['weight' => $validated['volume']]
            );

            $this->updateDatasetSistem($pemupukan->tanggal);

            return redirect()->back()
                ->with('success', 'Data pemupukan berhasil disimpan!');
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

        $totalProduksi = Pemupukan::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('volume');

        // Cari record dengan bulan dan tahun yang sama
        $existingRecord = DatasetSistem::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->first();

        if ($existingRecord) {
            // Update record yang sudah ada
            $existingRecord->update(['total_pemupukan' => $totalProduksi]);
        } else {
            // Buat record baru dengan tanggal pertama bulan tersebut
            DatasetSistem::create([
                'tanggal' => date('Y-m-01', strtotime($tanggal)),
                'total_pemupukan' => $totalProduksi
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
