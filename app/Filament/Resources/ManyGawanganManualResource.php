<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManyGawanganManualResource\Pages;
use App\Filament\Resources\ManyGawanganManualResource\RelationManagers;
use App\Models\Blok;
use App\Models\ManyGawanganManual;
use Carbon\Carbon;
// use Filament\Actions\CreateAction;
// use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
// use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Hidden;
// use Filament\Forms\Components\Section;
use Filament\Tables\Actions\ViewAction;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Notifications\Collection;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class ManyGawanganManualResource extends Resource
{
    protected static ?string $model = ManyGawanganManual::class;

    // Hidden Resource Navigation
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('blok_id')
                    ->relationship('blok', 'nama_blok')
                    ->label('Blok')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $blok = Blok::with('tahunTanam')->find($state);
                        $set('tahun_tanam_display', optional($blok->tahunTanam)->tahun_tanam);
                    }),

                TextInput::make('tahun_tanam_display')
                    ->label('Tahun Tanam')
                    ->disabled()
                    ->dehydrated(false) // supaya field ini tidak disimpan ke database
                    ->reactive()
                    ->afterStateHydrated(function (callable $set, $state, $record) {
                        $set('tahun_tanam_display', optional($record?->blok?->tahunTanam)->tahun_tanam);
                    }),

                DatePicker::make('tanggal')
                    ->required(),
                TextInput::make('rencana_gawangan')
                    ->numeric()
                    ->required(),
                TextInput::make('realisasi_gawangan')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('blok.tahunTanam.tahun_tanam')
                    ->label('Tahun Tanam'),
                TextColumn::make('blok.nama_blok'),
                TextColumn::make('tanggal')
                    ->label('Bulan')
                    ->formatStateUsing(function ($state) {
                        Carbon::setLocale('id');
                        return Carbon::parse($state)->translatedFormat('F');
                    }),
                TextColumn::make('rencana_gawangan'),
                TextColumn::make('realisasi_gawangan'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->infolist([
                        Section::make('Informasi Blok')
                            ->description('Detail informasi blok gawangan')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('blok.nama_blok')
                                            ->label('Nama Blok')
                                            ->columnSpan(1),
                                        TextEntry::make('blok.tahunTanam.tahun_tanam')
                                            ->label('Tahun Tanam')
                                            ->columnSpan(1),
                                    ]),
                            ]),

                        Section::make('Data Gawangan')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('tanggal')
                                            ->label('Tanggal Input')
                                            ->date(),
                                        TextEntry::make('rencana_gawangan')
                                            ->label('Rencana')
                                            ->badge()
                                            ->color('primary'),
                                        TextEntry::make('realisasi_gawangan')
                                            ->label('Realisasi')
                                            ->badge()
                                            ->color(fn($state) => $state ? 'success' : 'danger'),
                                    ]),
                            ]),
                    ]),
                Action::make('updateRealisasi')
                    ->label('Realisasi')
                    ->form([
                        TextInput::make('realisasi_gawangan')
                            ->label('Realisasi Gawangan')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->fillForm(fn(ManyGawanganManual $record): array => [
                        'realisasi_gawangan' => $record->rencana_gawangan,
                    ])
                    ->action(function (ManyGawanganManual $record, array $data): void {
                        $record->update([
                            'realisasi_gawangan' => $data['realisasi_gawangan']
                        ]);
                    })
                    ->modalWidth('xs'),
                EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('isi_semua_realisasi')
                    ->label('Isi Semua Realisasi Kosong')
                    ->icon('heroicon-o-check')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi')
                    ->modalDescription('Apakah Anda yakin ingin mengisi semua realisasi yang kosong dengan nilai rencana?')
                    ->action(function () {
                        $updatedCount = ManyGawanganManual::whereNull('realisasi_gawangan')
                            ->update([
                                'realisasi_gawangan' => DB::raw('rencana_gawangan')
                            ]);

                        Notification::make()
                            ->title("{$updatedCount} data realisasi berhasil diisi")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('reset_all_realisasi')
                        ->label('Reset Semua Realisasi')
                        ->icon('heroicon-o-arrow-path')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Reset Massal')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua data realisasi gawangan?')
                        ->action(function () {
                            $affected = DB::table('many_gawangan_manuals')
                                ->whereNotNull('realisasi_gawangan')
                                ->update([
                                    'realisasi_gawangan' => null,
                                    'updated_at' => now(),
                                ]);

                            Notification::make()
                                ->title("{$affected} data realisasi direset")
                                ->success()
                                ->send();
                        }),
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
            'index' => Pages\ListManyGawanganManuals::route('/'),
            'create' => Pages\CreateManyGawanganManual::route('/create'),
            'edit' => Pages\EditManyGawanganManual::route('/{record}/edit'),
        ];
    }
}
