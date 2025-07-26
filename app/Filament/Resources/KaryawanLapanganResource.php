<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaryawanLapanganResource\Pages;
use App\Models\Afdeling;
use App\Models\KaryawanLapangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class KaryawanLapanganResource extends Resource
{
    protected static ?string $model = KaryawanLapangan::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('afdeling_id')
                    ->relationship('afdeling', 'nama')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('jabatan')
                    ->options(KaryawanLapangan::JABATAN)
                    ->required()
                    ->native(false),

                Forms\Components\DatePicker::make('tanggal_masuk')
                    ->required()
                    ->displayFormat('d/m/Y'),

                Forms\Components\TextInput::make('lokasi_kerja')
                    ->required()
                    ->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('afdeling.nama')
                    ->sortable()
                    ->searchable(),
                    // ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('jabatan')
                    // ->colors([
                    //     'emerald' => 'MDR Panen',
                    //     'success' => 'MDR Pemeliharaan',
                    //     'warning' => 'Petugas Timbang BRD',
                    //     'danger' => 'Mandor',
                    //     'gray' => 'Asisten Kebun',
                    // ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('lokasi_kerja')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lama_kerja')
                    ->label('Lama Kerja (Tahun)')
                    ->formatStateUsing(fn($state) => (int)$state . ' Tahun')
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jabatan')
                    ->options(KaryawanLapangan::JABATAN),

                // Tables\Filters\Filter::make('mdr_pemeliharaan')
                //     ->label('MDR Pemeliharaan')
                //     ->query(fn(Builder $query): Builder => $query->mdrPemeliharaan()),

                Tables\Filters\Filter::make('tanggal_masuk')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal_masuk_dari'),
                        Forms\Components\DatePicker::make('tanggal_masuk_sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_masuk_dari'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_masuk', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_masuk_sampai'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_masuk', '<=', $date),
                            );
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
            'index' => Pages\ListKaryawanLapangans::route('/'),
            'create' => Pages\CreateKaryawanLapangan::route('/create'),
            'edit' => Pages\EditKaryawanLapangan::route('/{record}/edit'),
        ];
    }
}
