<?php

namespace Database\Seeders;

use App\Models\CurahHujan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CurahHujanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $data = [];

        // Generate data untuk 36 bulan terakhir
        for ($i = 36; $i >= 1; $i--) {
            $date = $now->copy()->subMonths($i);
            
            // Generate curah hujan random antara 100-300 mm dengan 2 desimal
            $curahHujan = mt_rand(10000, 30000) / 100;

            $data[] = [
                'tanggal' => $date->format('Y-m-d H:i:s'),
                'curah_hujan' => $curahHujan,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data secara batch
        CurahHujan::insert($data);

        $this->updateAllDatasetSistem();
    }

    protected function updateAllDatasetSistem()
    {
        $startDate = Carbon::now()->subMonths(36)->startOfMonth();

        for ($i = 0; $i < 36; $i++) {
            $currentDate = $startDate->copy()->addMonths($i);
            $month = $currentDate->month;
            $year = $currentDate->year;

            $totalCurahHujan = CurahHujan::whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->sum('curah_hujan');

            \App\Models\DatasetSistem::updateOrCreate(
                ['month' => $month, 'year' => $year],
                ['total_curah_hujan' => $totalCurahHujan]
            );
        }
    }
}