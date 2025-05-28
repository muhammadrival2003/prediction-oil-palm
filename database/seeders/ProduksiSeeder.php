<?php

namespace Database\Seeders;

use App\Models\Blok;
use App\Models\Produksi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ProduksiSeeder extends Seeder
{
    public function run()
    {
        $bloks = Blok::all();

        if ($bloks->isEmpty()) {
            $this->command->info('Tidak ada data Blok!');
            return;
        }

        $startDate = Carbon::create(2022, 1, 1);
        $endDate = Carbon::create(2024, 12, 1);
        
        $totalMonths = $startDate->diffInMonths($endDate) + 1;
        $insertedRecords = 0;

        $currentDate = $startDate->copy();
        
        for ($i = 0; $i < $totalMonths; $i++) {
            $randomBlok = $bloks->random();
            
            Produksi::updateOrCreate(
                [
                    'blok_id' => $randomBlok->id,
                    'year' => $currentDate->year,
                    'month' => $currentDate->month
                ],
                [
                    'rainfall' => mt_rand(100, 300) + mt_rand(0, 99)/100,
                    'fertilizer' => mt_rand(50, 200) + mt_rand(0, 99)/100,
                    'production' => mt_rand(1000000, 2000000) + mt_rand(0, 99)/100,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
            
            $currentDate->addMonth();
            $insertedRecords++;
        }

        $this->command->info("Berhasil membuat/mengupdate $insertedRecords records produksi dari {$startDate->format('Y-m')} hingga {$endDate->format('Y-m')}");
    }
}