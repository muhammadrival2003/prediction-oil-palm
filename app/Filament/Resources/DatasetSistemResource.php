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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('bulan')
                    ->options(function() {
                        return collect(range(1, 12))->mapWithKeys(function($month) {
                            return [$month => \DateTime::createFromFormat('!m', $month)->format('F')];
                        });
                    })
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
                    ->sortable()
                    ->searchable(['bulan', 'tahun']),
                    
                Tables\Columns\TextColumn::make('total_curah_hujan')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' mm'),
                    
                Tables\Columns\TextColumn::make('total_pemupukan')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' kg/ha'),
                    
                Tables\Columns\TextColumn::make('total_hasil_produksi')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' ton/ha'),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('bulan')
                    ->options(function() {
                        return collect(range(1, 12))->mapWithKeys(function($month) {
                            return [$month => \DateTime::createFromFormat('!m', $month)->format('F')];
                        });
                    }),
                    
                Tables\Filters\Filter::make('tahun')
                    ->form([Forms\Components\TextInput::make('tahun')->numeric()])
                    ->query(function (Builder $query, array $data) {
                        if ($data['tahun']) {
                            $query->where('tahun', $data['tahun']);
                        }
                    })
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