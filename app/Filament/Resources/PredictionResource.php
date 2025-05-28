<?php

namespace App\Filament\Resources;

use App\Filament\Components\PredictionChart;
use App\Filament\Resources\PredictionResource\Pages;
use App\Services\PredictionService;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use GuzzleHttp\Client;

class PredictionResource extends Resource
{
    protected static ?string $model = null; // Tidak menggunakan model

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        $service = new PredictionService();

        return $form
            ->schema([
                Section::make('Parameter Prediksi')
                    ->schema([
                        Select::make('year')
                            ->label('Tahun')
                            ->options(array_combine(
                                $years = range(2015, date('Y')),
                                $years
                            ))
                            ->rules(['integer']) // Tambahkan validasi integer
                            ->live()
                            ->required()
                            ->afterStateUpdated(function ($state, Set $set) {
                                // Reset bulan ketika tahun berubah
                                $set('month', null);
                            }),

                        Select::make('month')
                            ->label('Bulan')
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
                            ->live()
                            ->required(),
                    ])
                    ->columns(2),

                // Section::make('Visualisasi Data')
                //     ->schema([
                //         PredictionChart::make('performance_chart')
                //             ->predictionData(function (Get $get) use ($service) {
                //                 $year = 2024;
                //                 $month = 10;

                //                 if (!$year || !$month) return [];

                //                 $data = $service->getHistoricalData($year, $month);

                //                 // Format untuk chart: ['Bulan' => nilai]
                //                 return $data['predictions'];
                //             })
                //             ->actualData(function (Get $get) use ($service) {
                //                 $year = 2024;
                //                 $month = 10;

                //                 if (!$year || !$month) return [];

                //                 $data = $service->getHistoricalData($year, $month);

                //                 // Format untuk chart: ['Bulan' => nilai]
                //                 return $data['actual'];
                //             })
                //     ]),

                Section::make('Hasil Prediksi')
                    ->schema([
                        \Filament\Forms\Components\Placeholder::make('prediction_result')
                            ->content(function (Get $get) use ($service) {
                                $year = $get('year');
                                $month = $get('month');

                                if (!$year || !$month) return 'Pilih tahun dan bulan';

                                $result = $service->predict($year, $month);
                                // dd($result);

                                if ($result['status'] === 'error') {
                                    return "Error: " . $result['message'];
                                }

                                return number_format($result['prediction'], 0, ',', '.') . ' ton';
                            })
                    ])
                    ->hidden(function (Get $get) use ($service) {
                        $year = $get('year');
                        $month = $get('month');

                        // Sembunyikan section jika tahun/bulan tidak dipilih
                        if (!$year || !$month) return true;

                        $result = $service->predict($year, $month);

                        // Sembunyikan section jika prediksi error atau tidak ada
                        return $result['status'] !== 'success' || !isset($result['prediction']);
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')
                    ->label('Tahun'),
                TextColumn::make('month')
                    ->label('Bulan'),
                TextColumn::make('prediction')
                    ->label('Hasil Prediksi')
                    ->formatStateUsing(fn(string $state): string => number_format($state, 0, ',', '.') . ' ton')
            ])
            ->actions([
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPredictions::route('/'),
            'create' => Pages\CreatePrediction::route('/create'),
            'edit' => Pages\EditPrediction::route('/{record}/edit'),
        ];
    }
}
