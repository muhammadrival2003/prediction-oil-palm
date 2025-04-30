<?php

namespace Database\Factories;

use App\Models\Blok;
use App\Models\ManyGawanganManual;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ManyGawanganManual>
 */
class ManyGawanganManualFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ManyGawanganManual::class;
    public function definition()
    {
        return [
            'blok_id' => Blok::class,
            'tanggal' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            // Nilai sementara, akan diupdate setelah dibuat
            'rencana_gawangan' => 0,
            'realisasi_gawangan' => 0,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (ManyGawanganManual $gawangan) {
            $blok = $gawangan->blok;
            $luasPerGawangan = 0.5; // Sesuaikan dengan kebutuhan

            $rencanaGawangan = $blok->luas_lahan;

            $gawangan->update([
                'rencana_gawangan' => $rencanaGawangan,
                'realisasi_gawangan' => $this->faker->numberBetween(
                    max(1, $rencanaGawangan - 2),
                    $rencanaGawangan + 2
                ),
            ]);
        });
    }
}
