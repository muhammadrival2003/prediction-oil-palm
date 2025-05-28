<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HasilProduksi;
use App\Models\Blok;
use Carbon\Carbon;

class HasilProduksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua blok yang ada
        $bloks = Blok::all();
        
        if ($bloks->isEmpty()) {
            $this->command->info('Tidak ada blok tersedia. Silakan seed Blok terlebih dahulu.');
            return;
        }

        $startDate = Carbon::now()->subMonths(23)->startOfMonth();
        $data = [];

        for ($i = 0; $i < 24; $i++) {
            $currentDate = $startDate->copy()->addMonths($i);
            $month = $currentDate->month;
            $year = $currentDate->year;

            // Data produksi bervariasi berdasarkan musim (misal: lebih tinggi di bulan tertentu)
            $baseProduction = rand(800, 1200);
            
            // Penyesuaian musim (contoh: produksi lebih tinggi di bulan 6-9)
            if ($month >= 6 && $month <= 9) {
                $baseProduction = rand(1000, 1500);
            }

            foreach ($bloks as $blok) {
                // Variasi produksi per blok
                $productionVariance = rand(-100, 100);
                $realisasiProduksi = $baseProduction + $productionVariance;
                $rencanaProduksi = $realisasiProduksi + rand(-50, 50);

                $data[] = [
                    'blok_id' => $blok->id,
                    'tanggal' => $currentDate->copy()->endOfMonth(),
                    'rencana_produksi' => $rencanaProduksi,
                    'realisasi_produksi' => $realisasiProduksi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data secara batch
        foreach (array_chunk($data, 100) as $chunk) {
            HasilProduksi::insert($chunk);
        }

        // Update dataset sistem untuk semua bulan yang telah di-seed
        $this->updateAllDatasetSistem();
    }

    /**
     * Update semua data dataset_sistems berdasarkan data hasil produksi
     */
    protected function updateAllDatasetSistem()
    {
        $startDate = Carbon::now()->subMonths(23)->startOfMonth();

        for ($i = 0; $i < 24; $i++) {
            $currentDate = $startDate->copy()->addMonths($i);
            $bulan = $currentDate->month;
            $tahun = $currentDate->year;

            $totalProduksi = HasilProduksi::whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->sum('realisasi_produksi');

            \App\Models\DatasetSistem::updateOrCreate(
                ['bulan' => $bulan, 'tahun' => $tahun],
                ['total_hasil_produksi' => $totalProduksi]
            );
        }
    }
}