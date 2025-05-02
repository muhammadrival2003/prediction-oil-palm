<?php

namespace Database\Seeders;

use App\Models\Blok;
use App\Models\TahunTanam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tahunTanamIds = TahunTanam::pluck('id')->toArray();

        if (empty($tahunTanamIds)) {
            $this->command->info('Tidak ada data Tahun Tanam yang tersedia!');
            return;
        }

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 35; $i++) {
            $tahunTanamId = $tahunTanamIds[array_rand($tahunTanamIds)];
            $tahunTanam = Blok::find($tahunTanamId);

            Blok::create([
                'nama_blok' => $faker->unique()->bothify('ST.##'), // ?? untuk huruf, ## untuk angka
                'luas_lahan' => $faker->numberBetween(20, 60), // Luas antara 5-50 hektar
                'tahun_tanam_id' => $tahunTanamId,
                'jumlah_pokok' => $faker->numberBetween(500, 2000), // Jumlah pohon per blok
            ]);
        }

        $this->command->info("Berhasil membuat 35 data Blok!");
    }
}
