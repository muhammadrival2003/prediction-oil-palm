<?php

namespace Database\Seeders;

use App\Models\TahunTanam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunTanamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data contoh tahunTanam
        $tahunTanams = [
            ['tahun_tanam' => '2001', 'afdeling_id' => 5],
            ['tahun_tanam' => '2003', 'afdeling_id' => 5],
            ['tahun_tanam' => '2005', 'afdeling_id' => 5],
            ['tahun_tanam' => '2011', 'afdeling_id' => 5],
            ['tahun_tanam' => '2012', 'afdeling_id' => 5],
            ['tahun_tanam' => '2017', 'afdeling_id' => 5],
        ];

        foreach ($tahunTanams as $tahunTanam) {
            TahunTanam::create($tahunTanam);
        }
    }
}
