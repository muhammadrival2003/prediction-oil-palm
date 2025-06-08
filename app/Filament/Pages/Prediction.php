<?php

namespace App\Filament\Pages;

use App\Models\DatasetSistem;
use App\Models\Prediction as ModelsPrediction;
use App\Services\PredictionService;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;

class Prediction extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.prediction';
    protected static ?string $navigationLabel = 'Prediksi Produksi';
    protected static ?string $title = 'Prediksi';

    protected static ?string $navigationGroup = 'Prediksi';

    protected static ?int $navigationSort = 2;

    public $nextMonthPrediction;
    public $multipleMonthsPredictions = [];
    public $evaluationMetrics;
    public $historicalData;

    public $rainfall;
    public $fertilizer;

    public $monthsToPredict = 3;
    public $predictionMonths = [];

    public $usedHistoricalData = [];

    public $monthPrediction;
    public $selected_month;
    public $selected_year;

    protected function getFormSchema(): array
    {
        // Generate tahun options (5 tahun ke depan dari tahun sekarang)
        $yearOptions = [];
        $currentYear = date('Y');
        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear + $i;
            $yearOptions[$year] = $year;
        }

        return [
            Card::make('Prediksi Untuk Bulan')
                ->schema([
                    Select::make('selected_month')
                        ->label('Bulan')
                        ->required()
                        ->options([
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember'
                        ])
                        ->native(false),

                    Select::make('selected_year')
                        ->label('Tahun')
                        ->required()
                        ->options($yearOptions)
                        ->native(false)
                ])
        ];
    }

    // public $target_date;
    public $intermediatePredictions = [];

    public function predictCustom(PredictionService $predictionService)
    {
        $this->validate([
            'selected_month' => 'required|numeric|between:1,12',
            'selected_year' => 'required|numeric|min:' . date('Y')
        ]);

        try {
            $result = $predictionService->predictByMonthAndYear(
                $this->selected_month,
                $this->selected_year
            );

            $this->monthPrediction = $result['target_prediction'];
            $this->intermediatePredictions = $result['intermediate_predictions'];
            $this->usedHistoricalData = $result['historical_data_used'];

            // dd($this->intermediatePredictions);

            Notification::make()
                ->title('Prediksi Berhasil')
                ->body("Hasil prediksi {$this->getMonthName($this->selected_month)} {$this->selected_year}: {$this->monthPrediction['prediction']} kg")
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function mount(PredictionService $predictionService)
    {
        $this->evaluationMetrics = $predictionService->evaluateModel();
        $this->historicalData = $this->getHistoricalData($this->selected_month, $this->selected_year);

        // Set default value ke bulan dan tahun sekarang
        $this->selected_month = date('n');
        $this->selected_year = date('Y');
    }

    // Tambahkan method untuk mendapatkan data bulan
    public function getMonthName($month)
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $months[$month] ?? 'Unknown';
    }

    public function getHistoricalData($month, $year)
    {
        return DatasetSistem::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get()
            ->sortBy(fn($item) => $year * 100 + $month)
            ->values();
    }
}
