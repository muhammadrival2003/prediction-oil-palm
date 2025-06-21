<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HasilProduksi;
use App\Models\Blok;
use App\Models\DatasetSistem;
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

        $this->command->info('Memulai seeding data hasil produksi harian untuk 36 bulan...');

        // Mulai dari 36 bulan yang lalu
        $startDate = Carbon::now()->subMonths(36)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $data = [];
        $batchSize = 500; // Ukuran batch untuk insert
        $currentBatch = 0;

        // Hitung jumlah blok untuk distribusi produksi
        $jumlahBlok = $bloks->count();

        // Loop untuk setiap hari dalam periode 36 bulan
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $month = $currentDate->month;
            $year = $currentDate->year;
            $dayOfWeek = $currentDate->dayOfWeek; // 0 = Sunday, 6 = Saturday

            // Hitung target produksi bulanan (dalam kg)
            // Range bulanan: 5.000.000 - 20.000.000 kg
            $targetProduksiBulanan = rand(5000000, 20000000);
            
            // Hitung jumlah hari dalam bulan ini
            $daysInMonth = $currentDate->daysInMonth;
            
            // Hitung target produksi harian rata-rata
            $avgDailyTarget = $targetProduksiBulanan / $daysInMonth;
            
            // Base produksi harian dengan variasi
            $baseProduction = $avgDailyTarget * (rand(80, 120) / 100); // Variasi 80-120% dari rata-rata

            // Penyesuaian berdasarkan musim
            if ($month >= 6 && $month <= 9) {
                // Musim panen utama - produksi lebih tinggi (100-120% dari normal)
                $baseProduction *= (rand(100, 120) / 100);
            } elseif ($month >= 12 || $month <= 2) {
                // Musim hujan - produksi sedang (90-110% dari normal)
                $baseProduction *= (rand(90, 110) / 100);
            } else {
                // Musim lainnya - produksi normal (85-105% dari normal)
                $baseProduction *= (rand(85, 105) / 100);
            }

            // Penyesuaian berdasarkan hari dalam seminggu
            if ($dayOfWeek == 0) { // Minggu - produksi lebih rendah (70-90% dari normal)
                $baseProduction *= (rand(70, 90) / 100);
            } elseif ($dayOfWeek == 6) { // Sabtu - produksi sedang (80-95% dari normal)
                $baseProduction *= (rand(80, 95) / 100);
            }

            // Variasi cuaca acak (simulasi hari hujan, cerah, dll)
            $weatherFactor = rand(85, 115) / 100; // 0.85 - 1.15
            $baseProduction = (int)($baseProduction * $weatherFactor);

            foreach ($bloks as $blok) {
                // Variasi produksi per blok berdasarkan karakteristik blok
                $blokFactor = rand(90, 110) / 100; // 0.9 - 1.1
                $productionVariance = rand(-5000, 5000); // Variasi ±5 kg
                
                $realisasiProduksi = (int)(($baseProduction * $blokFactor / $jumlahBlok) + $productionVariance);
                
                // Pastikan produksi tidak negatif
                $realisasiProduksi = max(0, $realisasiProduksi);
                
                // Rencana produksi biasanya sedikit berbeda dari realisasi
                $planVariance = rand(-3000, 3000); // Variasi ±3 kg
                $rencanaProduksi = max(0, $realisasiProduksi + $planVariance);

                $data[] = [
                    'blok_id' => $blok->id,
                    'tanggal' => $currentDate->format('Y-m-d'),
                    'rencana_produksi' => $rencanaProduksi,
                    'realisasi_produksi' => $realisasiProduksi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insert batch ketika mencapai batas
                if (count($data) >= $batchSize) {
                    HasilProduksi::insert($data);
                    $data = [];
                    $currentBatch++;
                    
                    if ($currentBatch % 10 == 0) {
                        $this->command->info("Telah memproses {$currentBatch} batch data...");
                    }
                }
            }

            $currentDate->addDay();
        }

        // Insert sisa data
        if (!empty($data)) {
            HasilProduksi::insert($data);
            $currentBatch++;
        }

        $this->command->info("Selesai! Total {$currentBatch} batch data telah diinsert.");
        $this->command->info('Memperbarui dataset sistem...');

        // Update dataset sistem untuk semua bulan yang telah di-seed
        $this->updateAllDatasetSistem();
        
        $this->command->info('Seeding hasil produksi harian selesai!');
    }

    /**
     * Update semua data dataset_sistems berdasarkan data hasil produksi
     */
    protected function updateAllDatasetSistem()
    {
        $startDate = Carbon::now()->subMonths(36)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            $month = $currentDate->month;
            $year = $currentDate->year;

            // Hitung total produksi untuk bulan dan tahun tertentu
            $totalProduksi = HasilProduksi::whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->sum('realisasi_produksi');

            // Update atau create record di dataset sistem
            DatasetSistem::updateOrCreate(
                ['month' => $month, 'year' => $year],
                ['total_hasil_produksi' => $totalProduksi]
            );

            $this->command->info("Dataset sistem diperbarui untuk {$currentDate->format('F Y')}: {$totalProduksi} kg");
            
            $currentDate->addMonth();
        }
    }
}