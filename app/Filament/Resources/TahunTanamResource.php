<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TahunTanamResource\Pages;
use App\Filament\Resources\TahunTanamResource\RelationManagers;
use App\Models\TahunTanam;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;

class TahunTanamResource extends Resource
{
    protected static ?string $model = TahunTanam::class;

    public static function getNavigationLabel(): string
    {
        return __('TahunTanam');
    }
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    // Hidden Resource Navigation
    // public static function shouldRegisterNavigation(): bool
    // {
    //     return false;
    // }

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Data Aktual';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah Data Blok';
    }

    // protected static ?string $navigationIcon = 'heroicon-s-academic-cap';

    public static function form(Form $form): Form
    {
        // Ambil parameter dari URL atau request
        $afdelingId = request('afdeling_id');

        // Schema dasar
        $schema = [
            TextInput::make('tahun_tanam')
                ->label('Tahun Tanam')
                ->required()
                ->numeric()
                ->minValue(2000)
                ->maxValue(now()->year + 1),
        ];

        // Kondisi untuk field afdeling_id
        if ($afdelingId) {
            // Jika ada parameter, buat hidden field dengan nilai default
            $schema[] = Forms\Components\Hidden::make('afdeling_id')
                ->default($afdelingId);
        } else {
            // Jika tidak ada parameter, tampilkan select field
            $schema[] = Select::make('afdeling_id')
                ->label('Afdeling')
                ->relationship('afdeling', 'nama')
                ->required()
                ->searchable()
                ->preload();
        }

        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tahun_tanam'),
                TextColumn::make('umur')
                    ->label('Umur Tanaman')
                    ->getStateUsing(function ($record) {
                        return now()->year - $record->tahun_tanam . ' tahun';
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTahunTanams::route('/'),
            'create' => Pages\CreateTahunTanam::route('/create'),
            'edit' => Pages\EditTahunTanam::route('/{record}/edit'),
        ];
    }
}
