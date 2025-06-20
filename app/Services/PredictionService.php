<?php

namespace App\Services;

use App\Models\DatasetSistem;
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
        // 1. Ambil data historis 12 bulan terakhir
        $historicalData = DatasetSistem::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(24)
            ->get()
            ->sortBy(fn($item) => $item->year * 100 + $item->month)
            ->values();

        // dd($historicalData);
        if ($historicalData->count() < 12) {
            throw new \Exception('Butuh data historis 12 bulan terakhir.');
        }

        // 2. Hitung selisih bulan antara data terakhir dan target prediksi
        $lastData = $historicalData->last();
        $lastDate = Carbon::create($lastData->year, $lastData->month, 1);
        $targetDate = Carbon::create($year, $month, 1);

        if ($targetDate->lte($lastDate)) {
            throw new \Exception('Bulan/tahun target harus lebih baru dari data historis.');
        }

        $monthsDiff = $lastDate->diffInMonths($targetDate);

        // 3. Lakukan prediksi beruntun hingga mencapai bulan target
        $tempData = $historicalData->toArray();
        $prediction = null;

        for ($i = 0; $i < $monthsDiff; $i++) {
            $historicalForApi = array_map(function ($item) {
                // Pastikan semua nilai numerik adalah float
                return [
                    'month' => (int)$item['month'],
                    'year' => (int)$item['year'],
                    'curah_hujan' => (float)$item['total_curah_hujan'],
                    'pemupukan' => (float)$item['total_pemupukan'],
                    'hasil_produksi' => (float)$item['total_hasil_produksi']
                ];
            }, array_slice($tempData, -12));


            $response = Http::post("{$this->apiBaseUrl}/predict_by_month", [
                'historical_data' => $historicalForApi
            ]);

            $prediction = $response->json();

            // Simpan prediksi sebagai data baru untuk iterasi berikutnya
            $tempData[] = [
                'month' => $prediction['month'],
                'year' => $prediction['year'],
                'total_curah_hujan' => $this->calculateAverage(array_slice($tempData, -3), 'total_curah_hujan'),
                'total_pemupukan' => $this->calculateAverage(array_slice($tempData, -3), 'total_pemupukan'),
                'total_hasil_produksi' => $prediction['prediction']
            ];
        }

        return $prediction;
    }

    private function calculateAverage(array $data, string $field): float
    {
        $values = collect($data)->pluck($field)->map(function ($value) {
            // Pastikan nilai yang diolah adalah numerik
            if (is_array($value)) {
                return 0.0;
            }
            return is_numeric($value) ? (float)$value : 0.0;
        });

        return $values->avg() ?? 0.0;
    }
}
