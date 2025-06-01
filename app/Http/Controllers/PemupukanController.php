<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Blok;
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
        $validated = $request->validate([
            'blok_id' => 'required|exists:bloks,id',
            'tanggal' => 'required|date',
            'dosis' => 'required|numeric|min:0',
            'volume' => 'required|numeric|min:0'
        ]);

        $pemupukan = Pemupukan::create($validated);

        $this->logActivity(
            auth()->id(),
            $pemupukan->blok_id,
            'updated',
            'Memperbarui data pemupukan',
            ['weight' => $validated['volume']]
        );

        // Update dataset sistem
        $this->updateDatasetSistem($pemupukan->tanggal);

        return redirect()->back()->with('success', 'Data pemupukan berhasil disimpan');
    }

    protected function updateDatasetSistem($tanggal)
    {
        $month = date('n', strtotime($tanggal));
        $year = date('Y', strtotime($tanggal));

        $totalVolume = Pemupukan::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('volume');

        \App\Models\DatasetSistem::updateOrCreate(
            ['month' => $month, 'year' => $year],
            ['total_pemupukan' => $totalVolume]
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
