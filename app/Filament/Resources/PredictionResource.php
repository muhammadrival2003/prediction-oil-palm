<?php

namespace App\Filament\Resources;

use App\Filament\Components\PredictionChart;
use App\Filament\Resources\PredictionResource\Pages;
use App\Models\Prediction;
use App\Services\PredictionService;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use GuzzleHttp\Client;

class PredictionResource extends Resource
{
    protected static ?string $model = \App\Models\Prediction::class; // Tambahkan ini

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationLabel = 'Arsip Prediksi';

    protected static ?string $navigationGroup = 'Prediksi';

    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('month')
                    ->label('Bulan')
                    ->formatStateUsing(function ($state) {
                        return [
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
                        ][$state] ?? 'Unknown';
                    }),
                TextColumn::make('year')
                    ->label('Tahun'),
                TextColumn::make('prediction')
                    ->label('Hasil Prediksi (kg)')
                    ->formatStateUsing(fn(string $state): string => number_format($state, 0, ',', '.'))
            ])
            ->actions([
                ViewAction::make('view')
            ])
            ->paginated(false);;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPredictions::route('/'),
            'create' => Pages\CreatePrediction::route('/create'),
            'edit' => Pages\EditPrediction::route('/{record}/edit'),
            'view' => Pages\ViewDetailPrediction::route('/{record}'),
        ];
    }
}
