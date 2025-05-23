<?php

namespace App\Http\Controllers;


use App\Models\ActivityLog;
use App\Models\Blok;
use App\Models\Produksi;
use App\Models\TahunTanam;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        $data = [
            'totalTahunTanam' => TahunTanam::count('tahun_tanam'),
            'totalBlok' => Blok::count('nama_blok'),
            'totalPokok' => Blok::sum('jumlah_pokok'),
            'totalProduksi' => Produksi::sum('production'),
            'bloks' => Blok::all()
        ];

        return view('user.dashboard')->with($data);
    }

    public function storeProduksi(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'blok_id' => 'required|exists:bloks,id',
            'hasil_produksi' => 'required|numeric|min:0'
        ]);

        $produksi = Produksi::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'created',
            'description' => 'Menambahkan data produksi baru',
            'blok_id' => $validated['blok_id'],
            'data' => [
                'weight' => $validated['hasil_produksi'],
                'tanggal' => $validated['tanggal']
            ]
        ]);

        // Get the block name for the success message
        $blok = Blok::find($validated['blok_id']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Data produksi blok {$blok->nama_blok} berhasil disimpan",
                'data' => $produksi
            ]);
        }

        return redirect()->back()->with('success', "Data produksi blok {$blok->nama_blok} berhasil disimpan");
    }
}
