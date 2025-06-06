<?php

namespace App\Filament\Resources\PredictionResource\Pages;

use App\Filament\Resources\PredictionResource;
use Filament\Resources\Pages\ViewRecord;

class ViewDetailPrediction extends ViewRecord
{
    protected static string $resource = PredictionResource::class;
    protected static string $view = 'filament.pages.hasil-prediksi.detail-hasil-prediksi';
    public function getTitle(): string
    {
        return '';
    }
    public $predictionRecord;

    // Method untuk mengakses data prediksi
    public function getPredictionRecord()
    {
        return $this->record;
    }

    // Kirim data ke view
    public function getViewData(): array
    {
        // dd(request()->all());
        return [
            $this->predictionRecord = $this->getPredictionRecord()
        ];
    }
}
