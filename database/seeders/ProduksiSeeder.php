<?php

namespace Database\Seeders;

use App\Models\Blok;
use App\Models\Produksi;
use Illuminate\Database\Seeder;

class ProduksiSeeder extends Seeder
{
    public function run()
    {
        $blokIds = Blok::pluck('id')->toArray();

        if (empty($blokIds)) {
            $this->command->info('Tidak ada data Blok!');
            return;
        }

        $data = [];
        $startYear = 2022;
        $startMonth = 1; // Januari
        $totalMonths = 34;
        
        // Generate 34 months of data starting from January 2022
        for ($i = 0; $i < $totalMonths; $i++) {
            $currentMonth = (($startMonth - 1 + $i) % 12) + 1;
            $currentYear = $startYear + floor(($startMonth - 1 + $i) / 12);
            
            // Generate data for each blok for each month
            foreach ($blokIds as $blokId) {
                $data[] = [
                    'blok_id' => $blokId,
                    'year' => $currentYear,
                    'month' => $currentMonth,
                    'rainfall' => mt_rand(100, 300) + mt_rand(0, 99)/100,
                    'fertilizer' => mt_rand(50, 200) + mt_rand(0, 99)/100,
                    'production' => mt_rand(1000, 5000) + mt_rand(0, 99)/100,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        // Insert data in chunks to avoid memory issues
        $chunks = array_chunk($data, 1000);
        foreach ($chunks as $chunk) {
            Produksi::insert($chunk);
        }
        
        $this->command->info('Successfully seeded ' . count($data) . ' production records for 34 months!');
    }
}