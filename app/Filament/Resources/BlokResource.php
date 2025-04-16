<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlokResource\Pages;
use App\Filament\Resources\BlokResource\RelationManagers;
use App\Models\Blok;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlokResource extends Resource
{
    protected static ?string $model = Blok::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_blok')
                    ->required(),
                TextInput::make('luas_lahan')
                    ->required(),
                DatePicker::make('tahun_tanam')
                    ->native(false)
                    ->displayFormat('Y')
                    ->Format('Y') // hanya tampil tahun
                    ->required(),
                TextInput::make('jumlah_pokok')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_blok'),
                TextColumn::make('luas_lahan'),
                TextColumn::make('tahun_tanam'),
                TextColumn::make('jumlah_pokok'),
            ])
            ->filters([
                Filter::make('is_featured')
                    ->query(fn(Builder $query): Builder => $query->where('is_featured', true))
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
            'index' => Pages\ListBloks::route('/'),
            'create' => Pages\CreateBlok::route('/create'),
            'edit' => Pages\EditBlok::route('/{record}/edit'),
        ];
    }
}
