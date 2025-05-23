<?php

namespace App\Filament\Pages;

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
    protected static ?string $title = 'Prediksi Produksi';

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

    // protected function getFormSchema(): array
    // {
    //     return [
    //         Card::make('Prediksi Bulan Berikutnya')
    //             ->schema([
    //                 TextInput::make('rainfall')
    //                     ->label('Curah Hujan (mm)')
    //                     ->required()
    //                     ->numeric(),
    //                 TextInput::make('fertilizer')
    //                     ->label('Pemupukan (kg)')
    //                     ->required()
    //                     ->numeric(),
    //             ]),

    //         Card::make('Prediksi Beberapa Bulan')
    //             ->schema([
    //                 Select::make('monthsToPredict')
    //                     ->label('Jumlah Bulan yang Diprediksi')
    //                     ->options([
    //                         1 => '1 Bulan',
    //                         2 => '2 Bulan',
    //                         3 => '3 Bulan',
    //                         6 => '6 Bulan',
    //                         12 => '12 Bulan'
    //                     ])
    //                     ->reactive()
    //                     ->afterStateUpdated(fn($state, $set) => $set(
    //                         'predictionMonths',
    //                         array_fill(0, $state, ['rainfall' => null, 'fertilizer' => null])
    //                     )),

    //                 Repeater::make('predictionMonths')
    //                     ->label('Input untuk Setiap Bulan')
    //                     ->schema([
    //                         TextInput::make('rainfall')
    //                             ->label('Curah Hujan (mm)')
    //                             ->required()
    //                             ->numeric(),
    //                         TextInput::make('fertilizer')
    //                             ->label('Pemupukan (kg)')
    //                             ->required()
    //                             ->numeric(),
    //                     ])
    //                     ->columns(2)
    //             ])
    //     ];
    // }

    public function mount(PredictionService $predictionService)
    {
        $this->evaluationMetrics = $predictionService->evaluateModel();
        $this->historicalData = $predictionService->getHistoricalData();
    }

    public function predictNextMonth(PredictionService $predictionService)
    {
        $data = $this->form->getState();

        $this->nextMonthPrediction = $predictionService->predictNextMonth([
            'rainfall' => $data['rainfall'],
            'fertilizer' => $data['fertilizer'],
        ]);
    }

    public function predictMultipleMonths(PredictionService $predictionService)
    {
        $data = $this->form->getState();

        $this->multipleMonthsPredictions = $predictionService->predictMultipleMonths(
            $data['predictionMonths']
        );
    }

    public function predictWithDatabase(PredictionService $predictionService)
    {
        $this->reset(['nextMonthPrediction', 'usedHistoricalData']);

        try {
            $result = $predictionService->predictWithDatabaseData([
                'rainfall' => $this->rainfall,
                'fertilizer' => $this->fertilizer,
            ]);

            $this->nextMonthPrediction = $result;
            $this->usedHistoricalData = $result['used_historical_data'] ?? [];

            Notification::make()
                ->title('Prediksi Berhasil')
                ->body('Prediksi berhasil dibuat')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Prediksi Gagal')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
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

    public $monthPrediction;

    public function predictByMonth(PredictionService $predictionService)
    {
        $this->reset(['monthPrediction']);

        try {
            $this->monthPrediction = $predictionService->predictByMonth();

            Notification::make()
                ->title('Prediksi Berhasil')
                ->body('Prediksi berhasil dibuat menggunakan data historis')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Prediksi Gagal')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
