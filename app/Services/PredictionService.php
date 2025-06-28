<?php

namespace App\Services;

use App\Models\DatasetSistem;
use App\Models\Prediction;
use App\Models\Produksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class PredictionService
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('FLASK_API_URL', 'http://localhost:5000');
    }

    public function addHistoricalData(array $data)
    {
        // Konversi month dan year ke tanggal (pertama bulan)
        $tanggal = Carbon::create($data['year'], $data['month'], 1);

        $response = Http::post("{$this->apiBaseUrl}/add_monthly_data", [
            'month' => $data['month'],
            'year' => $data['year'],
            'curah_hujan' => $data['rainfall'],
            'pemupukan' => $data['fertilizer'],
            'hasil_produksi' => $data['production'],
        ]);

        return $response->json();
    }

    public function getHistoricalData()
    {
        $response = Http::get("{$this->apiBaseUrl}/get_historical_data");
        return $response->json();
    }

    public function evaluateModel()
    {
        $response = Http::get("{$this->apiBaseUrl}/evaluate");
        return $response->json();
    }

    public function predictByMonthAndYear(int $month, int $year)
    {
        // 1. Ambil data historis 24 bulan terakhir (2x lipat dari TIMESTEPS)
        $historicalData = DatasetSistem::orderBy('tanggal', 'desc')
            ->take(12)
            ->get()
            ->sortBy('tanggal')
            ->values();

        if ($historicalData->count() < 12) {
            throw new \Exception('Butuh data historis minimal 12 bulan terakhir.');
        }

        // 2. Hitung selisih bulan antara data terakhir dan target prediksi
        $lastData = $historicalData->last();
        $lastDate = Carbon::parse($lastData->tanggal);
        $targetDate = Carbon::create($year, $month, 1);

        if ($targetDate->lte($lastDate)) {
            throw new \Exception('Bulan/tahun target harus lebih baru dari data historis.');
        }

        $monthsDiff = $lastDate->diffInMonths($targetDate);

        // 3. Lakukan prediksi beruntun hingga mencapai bulan target
        $tempData = $historicalData->toArray();
        $allPredictions = [];
        $prediction = null;

        for ($i = 0; $i <= $monthsDiff; $i++) {
            $historicalForApi = array_map(function ($item) {
                $tanggal = Carbon::parse($item['tanggal']);
                return [
                    'month' => (int)$tanggal->format('m'),
                    'year' => (int)$tanggal->format('Y'),
                    'curah_hujan' => (float)$item['total_curah_hujan'],
                    'pemupukan' => (float)$item['total_pemupukan'],
                    'hasil_produksi' => (float)($item['total_hasil_produksi'] ?? $item['prediction'] ?? 0)
                ];
            }, array_slice($tempData, -12));

            $response = Http::post("{$this->apiBaseUrl}/predict_by_month", [
                'historical_data' => $historicalForApi
            ]);

            $prediction = $response->json();

            // Hentikan jika sudah melebihi bulan target
            $currentPredictionDate = Carbon::create($prediction['year'], $prediction['month'], 1);
            if ($currentPredictionDate->gt($targetDate)) {
                break;
            }

            // Simpan prediksi ke database sebagai data historis
            $savedPrediction = Prediction::updateOrCreate(
                [
                    'year' => $prediction['year'],
                    'month' => $prediction['month'],
                ],
                [
                    'prediction' => $prediction['prediction'],
                    'input_data' => $historicalForApi,
                    'confidence_score' => $prediction['confidence_score'] ?? null,
                    'deleted_at' => null
                ]
            );

            // Tambahkan prediksi ke array untuk iterasi berikutnya
            $tempData[] = [
                'tanggal' => $currentPredictionDate->format('Y-m-d'),
                'total_curah_hujan' => $this->calculateAverage(array_slice($tempData, -3), 'total_curah_hujan'),
                'total_pemupukan' => $this->calculateAverage(array_slice($tempData, -3), 'total_pemupukan'),
                'total_hasil_produksi' => $prediction['prediction'],
                'is_predicted' => true
            ];

            $allPredictions[] = $prediction;
        }

        return [
            'target_prediction' => $prediction,
            'intermediate_predictions' => $allPredictions,
            'historical_data_used' => array_slice($tempData, 0, -$monthsDiff)
        ];
    }

    private function calculateAverage(array $data, string $field): float
    {
        $values = collect($data)->pluck($field)->map(function ($value) {
            if (is_array($value)) {
                return 0.0;
            }
            return is_numeric($value) ? (float)$value : 0.0;
        });

        return $values->avg() ?? 0.0;
    }
}