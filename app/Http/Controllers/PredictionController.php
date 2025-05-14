<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PredictionController extends Controller
{
    public function index()
    {
        $years = range(2015, 2024);
        return view('prediction', compact('years'));
    }

    public function predict(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2015|max:2024',
            'month' => 'required|integer|between:1,12'
        ]);

        $client = new Client(['timeout' => 30]);

        try {
            $response = $client->post('http://localhost:5000/predict', [
                'json' => [
                    'year' => $request->year,
                    'month' => $request->month
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            return back()
                ->with('prediction', $result['prediction'])
                ->with('input', [
                    'tahun' => $request->year,
                    'bulan' => $request->month,
                    'last_values' => $result['last_values']
                ])
                ->with('success', 'Prediksi berhasil dilakukan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal melakukan prediksi: ' . $e->getMessage());
        }
    }
    public function getChartData(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12'
        ]);

        $client = new Client();

        try {
            $response = $client->post('http://localhost:5000/get-historical-data', [
                'json' => [
                    'year' => $request->year,
                    'month' => $request->month
                ],
                'timeout' => 30
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
