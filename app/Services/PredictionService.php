<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PredictionService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:5000/',
            'timeout'  => 30,
        ]);
    }

    public function predict(int $year, int $month): array
    {
        $cacheKey = "prediction_{$year}_{$month}";

        return Cache::remember($cacheKey, now()->addHours(1), function () use ($year, $month) {
            try {
                $response = $this->client->post('/predict', [
                    'json' => [
                        'year' => $year,
                        'month' => $month
                    ]
                ]);

                $data = json_decode($response->getBody(), true);

                return [
                    'status' => 'success',
                    'prediction' => $data['prediction'] ?? null,
                    'last_values' => $data['last_values'] ?? []
                ];
            } catch (\Exception $e) {
                Log::error('Prediction error: ' . $e->getMessage());
                return [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        });
    }

    public function getHistoricalData(int $year, int $month): array
    {
        try {
            $response = $this->client->post('/get-historical', [
                'json' => [
                    'year' => $year,
                    'month' => $month
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'http_errors' => false
            ]);
            
            $data = json_decode($response->getBody(), true);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception($data['message'] ?? 'API Error');
            }

            // Validasi struktur data
            if (!isset($data['data']['actual']) || !isset($data['data']['predictions'])) {
                throw new \Exception('Invalid data structure from API');
            }

            // Format data untuk chart
            return [
                'status' => 'success',
                'actual' => $data['data']['actual'],
                'predictions' => $data['data']['predictions'],
                'months' => $data['data']['months'] ?? array_keys($data['data']['actual'])
            ];
        } catch (\Exception $e) {
            Log::error('Historical data error: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'actual' => [],
                'predictions' => [],
                'months' => []
            ];
        }
    }
}
