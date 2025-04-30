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
        $blokIds = Blok::pluck('id')->toArray();

        if (empty($blokIds)) {
            $this->command->info('Tidak ada data blok yang tersedia!');
            return;
        }

        for ($i = 0; $i < 35; $i++) {
            $blokId = $blokIds[array_rand($blokIds)];
            $blok = Blok::find($blokId);

            ManyGawanganManual::create([
                'blok_id' => $blokId,
                'tanggal' => now()->subDays(rand(1, 365))->format('Y-m-d'),
                'rencana_gawangan' => $blok->luas_lahan,
                'realisasi_gawangan' => $blok->luas_lahan,
            ]);
        }

        $this->command->info("Berhasil membuat 35 data ManyGawanganManual!");
    }

    // protected function calculateRealisasi($rencana)
    // {
    //     // Realisasi sekitar rencana dengan variasi ±20% (minimal 1)
    //     $variasi = $rencana * 0.2;
    //     return rand(
    //         max(1, $rencana - $variasi),
    //         $rencana + $variasi
    //     );
    // }
}
