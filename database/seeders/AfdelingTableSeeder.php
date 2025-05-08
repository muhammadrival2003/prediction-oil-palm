<?php

namespace Database\Seeders;

use App\Models\Afdeling;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AfdelingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Data contoh alternatif
        $alternatifs = [
            ['nama' => 'Afdeling 1'],
            ['nama' => 'Afdeling 2'],
            ['nama' => 'Afdeling 3'],
            ['nama' => 'Afdeling 4'],
            ['nama' => 'Afdeling 5'],
        ];

        foreach ($alternatifs as $alternatif) {
            Afdeling::create($alternatif);
        }
    }
}
