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
        TahunTanam::factory()->count(10)->create();
    }
}
