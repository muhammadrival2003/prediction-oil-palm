<?php

namespace App\Filament\Pages;

use App\Services\PredictionService;
use Filament\Pages\Page;

class ModelLstm extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static string $view = 'filament.pages.model-lstm';
    protected static ?string $title = '';
    protected static ?string $navigationLabel = 'Model Evaluation';
    protected static ?string $navigationGroup = 'Prediksi';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public $modelPerformance;

    public function mount(PredictionService $predictionService)
    {
        // Jika ada parameter dari URL
        if (request()->has('model_performance')) {
            $this->modelPerformance = request('model_performance');
        } else {
            // Jika tidak, ambil dari service
            $this->modelPerformance = $predictionService->evaluateModel();
        }
    }
}