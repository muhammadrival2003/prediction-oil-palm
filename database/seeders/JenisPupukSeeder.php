<?php

namespace Database\Seeders;

use App\Models\JenisPupuk;
use Illuminate\Database\Seeder;

class JenisPupukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisPupuk = [
            ['nama' => 'Urea'],
            ['nama' => 'Majemuk'],
            ['nama' => 'Boron'],
            ['nama' => 'MOP'],
            ['nama' => 'Dolomite'],
            ['nama' => 'NPK'],
            ['nama' => 'Bionessis'],
        ];

        foreach ($jenisPupuk as $pupuk) {
            JenisPupuk::create($pupuk);
        }

        // Atau bisa juga menggunakan insert() untuk insert massal
        // JenisPupuk::insert($jenisPupuk);
    }
}