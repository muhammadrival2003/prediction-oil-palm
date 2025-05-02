<?php

namespace Database\Seeders;

use App\Models\Blok;
use App\Models\Chemis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChemisTableSeeder extends Seeder
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

            Chemis::create([
                'blok_id' => $blokId,
                'tanggal' => now()->subDays(rand(1, 365))->format('Y-m-d'),
                'rencana_chemis' => $blok->luas_lahan,
                'realisasi_chemis' => $blok->luas_lahan,
            ]);
        }

        $this->command->info("Berhasil membuat 35 data Chemis!");
    }
}
