<?php

namespace App\Filament\Resources;

use App\Filament\Imports\CurahHujanImporter;
use App\Filament\Resources\CurahHujanResource\Pages;
use App\Filament\Resources\CurahHujanResource\RelationManagers;
use App\Models\CurahHujan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurahHujanResource extends Resource
{
    protected static ?string $model = CurahHujan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Prediksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('bulan')
                    ->options([
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->required()
                    ->native(false),
                    
                Forms\Components\Select::make('tahun')
                    ->options(function () {
                        $years = range(now()->year, now()->year - 10);
                        return array_combine($years, $years);
                    })
                    ->required()
                    ->native(false),
                    
                Forms\Components\TextInput::make('curah_hujan')
                    ->numeric()
                    ->required()
                    ->suffix('mm')
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->date('d F Y')
                    ->sortable(),
                TextColumn::make('curah_hujan')
                    ->suffix(' mm')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tahun')
                    ->form([
                        Forms\Components\Select::make('tahun')
                            ->options(function () {
                                $years = range(now()->year, now()->year - 10);
                                return array_combine($years, $years);
                            })
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['tahun'])) {
                            $query->whereYear('tanggal', $data['tahun']);
                        }
                    }),
                    
                Tables\Filters\SelectFilter::make('bulan')
                    ->options([
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereMonth('tanggal', $data['value']);
                        }
                    }),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(CurahHujanImporter::class)
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
            'index' => Pages\ListCurahHujans::route('/'),
            'create' => Pages\CreateCurahHujan::route('/create'),
            'edit' => Pages\EditCurahHujan::route('/{record}/edit'),
        ];
    }
}