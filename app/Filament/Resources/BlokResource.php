<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlokResource\Pages;
use App\Filament\Resources\BlokResource\RelationManagers;
use App\Models\Blok;
use Carbon\Carbon;
// use Filament\Actions\ViewAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
// use Filament\Forms\Components\Grid;
// use Filament\Forms\Components\Section;
// use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlokResource extends Resource
{
    protected static ?string $model = Blok::class;

    public static function getNavigationLabel(): string
    {
        return __('Blok');
    }

    protected static ?string $navigationGroup = 'Data Aktual';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah Data Blok';
    }

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_blok')
                    ->required(),
                TextInput::make('luas_lahan')
                    ->required(),
                Select::make('tahun_tanam_id')
                    ->relationship('tahunTanam', 'tahun_tanam'),
                TextInput::make('jumlah_pokok')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_blok'),
                TextColumn::make('tahunTanam.tahun_tanam'),
                TextColumn::make('luas_lahan'),
                TextColumn::make('jumlah_pokok'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton()
                    ->color('primary')
                    ->infolist([
                        Section::make('Informasi Blok')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('nama_blok')
                                            ->label('Nama Blok')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color('gray'),
                                        TextEntry::make('tahunTanam.tahun_tanam')
                                            ->label('Tahun Tanam')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color('gray'),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('luas_lahan')
                                            ->label('Luas Lahan')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color('gray'),
                                        TextEntry::make('jumlah_pokok')
                                            ->label('Jumlah Pokok')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color('gray'),
                                    ]),
                            ]),
                    ])
                    ->modalWidth('xl'),
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
