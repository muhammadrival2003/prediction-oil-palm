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

    protected function getFormSchema(): array
    {
        return [
            Card::make('Prediksi Berdasarkan Bulan/Tahun')
                ->schema([
                    DatePicker::make('target_date')
                        ->label('Pilih Bulan dan Tahun')
                        ->required()
                        ->displayFormat('F Y') // Format tampilan bulan dan tahun
                        ->format('m/Y') // Format penyimpanan data
                        ->closeOnDateSelection()
                        ->native(false)
                ])
        ];
    }

    public $target_date;

    public function predictCustom(PredictionService $predictionService)
    {
        $this->validate(['target_date' => 'required']);

        try {
            $date = Carbon::parse($this->target_date);
            $month = $date->month;
            $year = $date->year;

            // Panggil service untuk prediksi
            $this->monthPrediction = $predictionService->predictByMonthAndYear($month, $year);

            // dd($this->monthPrediction['month']);

            // Update atau buat data prediksi
            ModelsPrediction::updateOrCreate(
                [
                    'year' => $this->monthPrediction['year'],
                    'month' => $this->monthPrediction['month'],
                ],
                [
                    'prediction' => $this->monthPrediction['prediction'],
                    'deleted_at' => null // Pastikan data di-restore jika sebelumnya di-soft delete
                ]
            );

            // Notifikasi sukses
            Notification::make()
                ->title('Prediksi Berhasil')
                ->body("Hasil prediksi {$this->getMonthName($month)} {$year}: {$this->monthPrediction['prediction']} ton")
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
        $this->historicalData = $predictionService->getHistoricalData();
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

    public function getHistoricalData(int $month, int $year)
    {
        return DatasetSistem::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get()
            ->sortBy(fn($item) => $item->year * 100 + $item->month)
            ->values();
    }
}
