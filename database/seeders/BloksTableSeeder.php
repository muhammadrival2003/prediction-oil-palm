<?php

namespace Database\Seeders;

use App\Models\Blok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blok::factory()->count(10)->create();
    }
}
