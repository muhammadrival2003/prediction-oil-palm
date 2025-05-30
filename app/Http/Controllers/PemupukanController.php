<?php

namespace App\Http\Controllers;

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

        // Update dataset sistem
        $this->updateDatasetSistem($pemupukan->tanggal);

        return redirect()->back()->with('success', 'Data pemupukan berhasil disimpan');
    }

    protected function updateDatasetSistem($tanggal)
    {
        $bulan = date('n', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $totalVolume = Pemupukan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('volume');

        \App\Models\DatasetSistem::updateOrCreate(
            ['bulan' => $bulan, 'tahun' => $tahun],
            ['total_pemupukan' => $totalVolume]
        );
    }
}
