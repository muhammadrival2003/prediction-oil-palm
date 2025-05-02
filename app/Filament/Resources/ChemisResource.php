<?php

namespace App\Filament\Resources;

use App\Exports\CehListChemisExport;
use App\Exports\ChemisExport;
use App\Filament\Resources\ChemisResource\Pages;
use App\Models\Blok;
use App\Models\Chemis;
use Carbon\Carbon;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ChemisResource extends Resource
{
    protected static ?string $model = Chemis::class;

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
                TextInput::make('rencana_chemis')
                    ->numeric()
                    ->required(),
                TextInput::make('realisasi_chemis')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Admin')
            ->description('Buat Rencana dan Realisasi Chemis Piringan Pokok disini.')
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
                TextColumn::make('rencana_chemis')
                    ->label('Rencana')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('realisasi_chemis')
                    ->label('Realisasi')
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                // Filter berdasarkan Tahun Tanam
                Tables\Filters\SelectFilter::make('tahun_tanam')
                    ->relationship('blok.tahunTanam', 'tahun_tanam')
                    ->label('Tahun Tanam')
                    ->searchable()
                    ->preload(),

                // Filter berdasarkan Blok
                Tables\Filters\SelectFilter::make('blok')
                    ->relationship('blok', 'nama_blok')
                    ->label('Blok')
                    ->searchable()
                    ->preload(),

                // Filter berdasarkan Bulan (PERBAIKAN)
                Tables\Filters\SelectFilter::make('bulan')
                    ->label('Bulan')
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
                    ->query(function ($query, $data) {
                        if (!empty($data['value'])) {
                            $query->whereMonth('tanggal', $data['value']);
                        }
                    }),

                // Filter berdasarkan Tahun (PERBAIKAN)
                Tables\Filters\SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(function () {
                        $connection = config('database.default');
                        $years = Chemis::query();

                        if ($connection === 'pgsql') {
                            $years->selectRaw('EXTRACT(YEAR FROM tanggal)::integer as year');
                        } else {
                            $years->selectRaw('YEAR(tanggal) as year');
                        }

                        return $years->groupBy('year')
                            ->pluck('year', 'year')
                            ->mapWithKeys(fn($year) => [strval($year) => strval($year)])
                            ->toArray();
                    })
                    ->query(function ($query, $data) {
                        if (!empty($data['value'])) {
                            $connection = config('database.default');
                            if ($connection === 'pgsql') {
                                $query->whereRaw('EXTRACT(YEAR FROM tanggal) = ?', [$data['value']]);
                            } else {
                                $query->whereYear('tanggal', $data['value']);
                            }
                        }
                    }),

                // Filter untuk realisasi yang sudah diisi atau belum (PERBAIKAN)
                Tables\Filters\SelectFilter::make('realisasi_status')
                    ->label('Status Realisasi')
                    ->options([
                        'filled' => 'Sudah Diisi',
                        'empty' => 'Belum Diisi',
                    ])
                    ->query(function ($query, $data) {
                        if ($data['value'] === 'filled') {
                            $query->whereNotNull('realisasi_chemis');
                        } elseif ($data['value'] === 'empty') {
                            $query->whereNull('realisasi_chemis');
                        }
                    }),
            ])
            ->actions([
                Action::make('updateRealisasi')
                    ->label('Realisasi')
                    ->button()
                    ->outlined()
                    ->form([
                        TextInput::make('realisasi_chemis')
                            ->label('Realisasi Chemis')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->fillForm(fn(Chemis $record): array => [
                        'realisasi_chemis' => $record->rencana_chemis,
                    ])
                    ->action(function (Chemis $record, array $data): void {
                        $record->update([
                            'realisasi_chemis' => $data['realisasi_chemis']
                        ]);
                    })
                    ->modalWidth('xs'),
                ViewAction::make()
                    ->iconButton()
                    ->color('primary')
                    ->infolist([
                        Section::make('Informasi Blok')
                            ->description('Detail informasi blok Chemis')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('blok.tahunTanam.tahun_tanam')
                                            ->label('Tahun Tanam')
                                            ->columnSpan(1),
                                        TextEntry::make('blok.nama_blok')
                                            ->label('Nama Blok')
                                            ->columnSpan(1),
                                        TextEntry::make('blok.luas_lahan')
                                            ->label('Luas Lahan')
                                            ->columnSpan(1),
                                    ]),
                            ]),

                        Section::make('Data Chemis')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('tanggal')
                                            ->label('Bulan')
                                            ->formatStateUsing(function ($state) {
                                                Carbon::setLocale('id');
                                                return Carbon::parse($state)->translatedFormat('F');
                                            }),
                                        TextEntry::make('rencana_chemis')
                                            ->label('Rencana')
                                            ->badge()
                                            ->color('gray'),
                                        TextEntry::make('realisasi_chemis')
                                            ->label('Realisasi')
                                            ->badge()
                                            ->color(fn($state) => $state ? 'success' : 'danger'),
                                    ]),
                            ]),
                    ])
                    ->modalWidth('xl'),
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                BulkAction::make('isi_semua_realisasi')
                    ->label('Isi Semua Realisasi')
                    // ->icon('heroicon-o-check')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi')
                    ->modalDescription('Apakah Anda yakin ingin mengisi semua realisasi yang kosong dengan nilai rencana?')
                    ->action(function () {
                        $updatedCount = Chemis::whereNull('realisasi_chemis')
                            ->update([
                                'realisasi_chemis' => DB::raw('rencana_chemis')
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
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua data realisasi Chemis?')
                        ->action(function () {
                            $affected = DB::table('chemis')
                                ->whereNotNull('realisasi_chemis')
                                ->update([
                                    'realisasi_chemis' => null,
                                    'updated_at' => now(),
                                ]);

                            Notification::make()
                                ->title("{$affected} data realisasi direset")
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->headerActions([
                // ExportAction::make()->exporter(ChemisExporter::class)
                //     ->label('Export')
                Action::make('export')
                    ->label('Export Excel')
                    ->action(fn() => Excel::download(new ChemisExport, 'Rencana Pekerjaan Chemis Piringan Pokok.xlsx'))
                    ->color('success'),
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
            'index' => Pages\ListChemis::route('/'),
            'create' => Pages\CreateChemis::route('/create'),
            'edit' => Pages\EditChemis::route('/{record}/edit'),
        ];
    }
}
