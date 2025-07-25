<?php

namespace Database\Seeders;

use App\Models\Blok;
use App\Models\ManyGawanganManual;
use App\Models\TahunTanam;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        

        $this->call([
            AfdelingTableSeeder::class,
            TahunTanamsTableSeeder::class,
            BloksTableSeeder::class,
            JenisPupukSeeder::class,
            // ProduksiSeeder::class,
            // HasilProduksiSeeder::class,
            // CurahHujanSeeder::class,
            // PemupukanSeeder::class,
            KaryawanLapanganSeeder::class,
            // Seeder lainnya...
        ]);

        // TahunTanam::factory(10)->create();
        // Blok::factory(10)->create();
        // ManyGawanganManual::factory(35)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);
        User::factory()->create([
            'name' => 'Harianto',
            'email' => 'harianto@gmail.com',
            'role' => 'manager',
        ]);
        User::factory()->create([
            'name' => 'Supriyatno',
            'email' => 'yatno@gmail.com',
            'role' => 'user',
            'afdeling_id' => 5,
        ]);
    }
}
