<?php

namespace Database\Factories;

use App\Models\Blok;
use App\Models\TahunTanam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blok>
 */
class BlokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Blok::class;
    public function definition(): array
    {
        return [
            'nama_blok' => $this->faker->unique()->bothify('ST.##'), // ?? untuk huruf, ## untuk angka
            'luas_lahan' => $this->faker->numberBetween(20, 60), // Luas antara 5-50 hektar
            'tahun_tanam_id' => TahunTanam::factory(),
            'jumlah_pokok' => $this->faker->numberBetween(500, 2000), // Jumlah pohon per blok
        ];
    }
}
