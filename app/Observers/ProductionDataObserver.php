<?php

namespace App\Observers;

use App\Models\ProductionData;
use App\Models\Produksi;
use App\Services\PredictionService;

class ProductionDataObserver
{
    protected $predictionService;

    public function __construct(PredictionService $predictionService)
    {
        $this->predictionService = $predictionService;
    }

    public function created(Produksi $productionData)
    {
        $this->predictionService->addHistoricalData([
            'month' => $productionData->month,
            'year' => $productionData->year,
            'rainfall' => $productionData->rainfall,
            'fertilizer' => $productionData->fertilizer,
            'production' => $productionData->production,
        ]);
    }

    public function updated(Produksi $productionData)
    {
        $this->predictionService->addHistoricalData([
            'month' => $productionData->month,
            'year' => $productionData->year,
            'rainfall' => $productionData->rainfall,
            'fertilizer' => $productionData->fertilizer,
            'production' => $productionData->production,
        ]);
    }
}