<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pemupukan;
use App\Models\Blok;
use Carbon\Carbon;

class PemupukanSeeder extends Seeder
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

        // Frekuensi pemupukan berbeda per musim
        $frekuensiPemupukan = [
            1 => 1,  // Januari - 1x
            2 => 1,  // Februari - 1x
            3 => 2,  // Maret - 2x (awal musim tanam)
            4 => 2,  // April - 2x
            5 => 3,  // Mei - 3x (puncak musim tanam)
            6 => 3,  // Juni - 3x
            7 => 2,  // Juli - 2x
            8 => 2,  // Agustus - 2x
            9 => 1,  // September - 1x
            10 => 1, // Oktober - 1x
            11 => 1, // November - 1x
            12 => 1  // Desember - 1x
        ];

        for ($i = 0; $i < 24; $i++) {
            $currentMonth = $startDate->copy()->addMonths($i);
            $monthNumber = $currentMonth->month;
            $year = $currentMonth->year;

            // Tentukan berapa kali pemupukan di bulan ini
            $jumlahPemupukan = $frekuensiPemupukan[$monthNumber];

            for ($j = 0; $j < $jumlahPemupukan; $j++) {
                foreach ($bloks as $blok) {
                    // Dosis bervariasi antara 0.2 - 0.5 kg/pokok
                    $dosis = rand(20, 50) / 100; // Convert to 0.2 - 0.5
                    
                    // Volume dihitung berdasarkan dosis dan luas blok (contoh: 100 pokok per blok)
                    $volume = $dosis * 100; // Asumsi 100 pokok per blok
                    
                    // Tanggal pemupukan diacak dalam bulan tersebut
                    $tanggal = $currentMonth->copy()
                                ->addDays(rand(1, $currentMonth->daysInMonth - 1))
                                ->setTime(rand(8, 16), 0, 0);

                    $data[] = [
                        'blok_id' => $blok->id,
                        'tanggal' => $tanggal,
                        'dosis' => $dosis,
                        'volume' => $volume,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Insert data secara batch
        foreach (array_chunk($data, 100) as $chunk) {
            Pemupukan::insert($chunk);
        }

        // Update dataset sistem untuk semua bulan yang telah di-seed
        $this->updateAllDatasetSistem();
    }

    /**
     * Update semua data dataset_sistems berdasarkan data pemupukan
     */
    protected function updateAllDatasetSistem()
    {
        $startDate = Carbon::now()->subMonths(23)->startOfMonth();

        for ($i = 0; $i < 24; $i++) {
            $currentDate = $startDate->copy()->addMonths($i);
            $month = $currentDate->month;
            $year = $currentDate->year;

            $totalPemupukan = Pemupukan::whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->sum('volume');

            \App\Models\DatasetSistem::updateOrCreate(
                ['month' => $month, 'year' => $year],
                ['total_pemupukan' => $totalPemupukan]
            );
        }
    }
}