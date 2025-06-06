<?php

namespace App\Filament\Resources\PredictionResource\Pages;

use App\Filament\Resources\PredictionResource;
use App\Models\DatasetSistem;
use App\Models\Prediction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPredictions extends ListRecords
{
    protected static string $resource = PredictionResource::class;
    protected static string $view = 'filament.pages.hasil-prediksi.list-predictions';

    // Method untuk mendapatkan data chart
    public function getChartDataProperty(): array
    {
        $historicalData = Prediction::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get()
            ->sortBy(fn($item) => $item->year * 100 + $item->month)
            ->values();

        return [
            'labels' => $historicalData->map(fn($item) => $this->getShortMonthName($item->month).' '.$item->year),
            'prediction' => $historicalData->pluck('prediction'),
        ];
    }

    private function getShortMonthName($month): string
    {
        return [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags', 
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ][$month] ?? '';
    }

    // Jika perlu mengirim data tambahan ke view
    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), [
            'chartData' => $this->chartData,
        ]);
    }
}