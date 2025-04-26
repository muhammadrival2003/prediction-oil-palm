<?php

namespace Database\Factories;

use App\Models\TahunTanam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TahunTanam>
 */
class TahunTanamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = TahunTanam::class;

    public function definition(): array
    {
        return [
            'tahun_tanam' => $this->faker->numberBetween(2000, date('Y'))
        ];
    }
}
