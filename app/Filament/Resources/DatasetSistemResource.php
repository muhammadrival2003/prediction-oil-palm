<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DatasetSistemResource\Pages;
use App\Filament\Resources\DatasetSistemResource\RelationManagers;
use App\Models\DatasetSistem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DatasetSistemResource extends Resource
{
    protected static ?string $model = DatasetSistem::class;
    protected static ?string $navigationIcon = 'heroicon-o-cloud';
    protected static ?string $navigationGroup = 'Prediksi';

    protected static ?int $navigationSort = 1;

    // Tambahkan array untuk mapping bulan
    protected static array $bulanIndo = [
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('bulan')
                    ->options(self::$bulanIndo) // Gunakan array bulan Indo
                    ->required()
                    ->native(false),
                    
                Forms\Components\TextInput::make('tahun')
                    ->numeric()
                    ->required()
                    ->minValue(2000)
                    ->maxValue(2100),
                    
                Forms\Components\TextInput::make('total_curah_hujan')
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->suffix('mm'),
                    
                Forms\Components\TextInput::make('total_pemupukan')
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->suffix('kg/ha'),
                    
                Forms\Components\TextInput::make('total_hasil_produksi')
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->suffix('ton/ha'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('periode')
                    ->formatStateUsing(function ($state) {
                        // Asumsi $state dalam format "Bulan Tahun" (contoh: "January 2023")
                        $parts = explode(' ', $state);
                        if (count($parts) === 2) {
                            $monthName = $parts[0];
                            $year = $parts[1];
                            
                            // Cari bulan yang cocok dalam array
                            foreach (self::$bulanIndo as $num => $bulan) {
                                if (\DateTime::createFromFormat('!m', $num)->format('F') === $monthName) {
                                    return $bulan . ' ' . $year;
                                }
                            }
                        }
                        return $state;
                    }),
                    
                Tables\Columns\TextColumn::make('total_curah_hujan')
                    ->label('Total Curah Hujan (mm)')
                    ->numeric(decimalPlaces: 2),
                    
                Tables\Columns\TextColumn::make('total_pemupukan')
                    ->label('Total Pemupukan (kg)')
                    ->numeric(decimalPlaces: 2),
                    
                Tables\Columns\TextColumn::make('total_hasil_produksi')
                    ->label('Total Hasil Produksi (kg)')
                    ->numeric(decimalPlaces: 0),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDatasetSistems::route('/'),
            'create' => Pages\CreateDatasetSistem::route('/create'),
            'edit' => Pages\EditDatasetSistem::route('/{record}/edit'),
        ];
    }
}