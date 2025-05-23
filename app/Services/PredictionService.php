<?php

namespace App\Services;

use App\Models\Produksi;
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

    public function predictNextMonth(array $input)
    {
        $response = Http::post("{$this->apiBaseUrl}/predict_next_month", [
            'curah_hujan' => $input['rainfall'],
            'pemupukan' => $input['fertilizer'],
        ]);

        return $response->json();
    }

    public function predictMultipleMonths(array $months)
    {
        $formattedMonths = array_map(function ($month) {
            return [
                'curah_hujan' => $month['rainfall'],
                'pemupukan' => $month['fertilizer'],
            ];
        }, $months);

        $response = Http::post("{$this->apiBaseUrl}/predict_multiple_months", [
            'months' => $formattedMonths,
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
    public function predictWithDatabaseData(array $input)
    {
        // Ambil 12 bulan terakhir dari database
        $historicalData = Produksi::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get()
            ->sortBy(function ($item) {
                return $item->year * 100 + $item->month;
            })
            ->values();

        if ($historicalData->count() < 12) {
            throw new \Exception('Need at least 12 months of historical data');
        }

        // Format data untuk Flask API
        $formattedData = [
            'months' => [
                [
                    'curah_hujan' => $input['rainfall'],
                    'pemupukan' => $input['fertilizer']
                ]
            ],
            'historical_data' => $historicalData->map(function ($item) {
                return [
                    'month' => $item->month,
                    'year' => $item->year,
                    'curah_hujan' => $item->rainfall,
                    'pemupukan' => $item->fertilizer,
                    'hasil_produksi' => $item->production
                ];
            })->toArray()
        ];

        $response = Http::post("{$this->apiBaseUrl}/predict_with_database", $formattedData);

        // Tambahkan data historis ke response
        $responseData = $response->json();
        $responseData['used_historical_data'] = $historicalData;

        return $responseData;
    }

    public function predictByMonth()
    {
        // Ambil 12 bulan terakhir dari database
        $historicalData = Produksi::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get()
            ->sortBy(function ($item) {
                return $item->year * 100 + $item->month;
            })
            ->values();

        if ($historicalData->count() < 12) {
            throw new \Exception('Need at least 12 months of historical data');
        }

        // Format data untuk Flask API
        $formattedData = [
            'historical_data' => $historicalData->map(function ($item) {
                return [
                    'month' => $item->month,
                    'year' => $item->year,
                    'curah_hujan' => $item->rainfall,
                    'pemupukan' => $item->fertilizer,
                    'hasil_produksi' => $item->production
                ];
            })->toArray()
        ];

        $response = Http::post("{$this->apiBaseUrl}/predict_by_month", $formattedData);

        // Tambahkan data historis ke response
        $responseData = $response->json();
        $responseData['used_historical_data'] = $historicalData;

        return $responseData;
    }
}
