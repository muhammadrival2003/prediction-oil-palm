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
        $existingYears = TahunTanam::pluck('tahun_tanam')->toArray();

        do {
            $year = $this->faker->numberBetween(2000, date('Y'));
        } while (in_array($year, $existingYears));

        return [
            'tahun_tanam' => $year
        ];
    }
}
