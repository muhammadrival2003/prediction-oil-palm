<?php

namespace Database\Seeders;

use App\Models\Blok;
use App\Models\ManyGawanganManual;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManyGawanganManualsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Kosongkan tabel terlebih dahulu
        ManyGawanganManual::truncate();

        // Ambil semua blok yang tersedia
        $bloks = Blok::all();

        if ($bloks->isEmpty()) {
            $this->command->info('Tidak ada data blok yang tersedia!');
            return;
        }

        $createdCount = 0;

        foreach ($bloks as $blok) {
            ManyGawanganManual::create([
                'blok_id' => $blok->id,
                'tanggal' => null,
                'rencana_gawangan' => null,
                'realisasi_gawangan' => null,
            ]);
            $createdCount++;
        }

        $this->command->info("Berhasil membuat {$createdCount} data ManyGawanganManual (hanya blok_id)!");
    }
}