<?php

namespace App\Filament\Resources;

use App\Exports\ManyGawanganManualsExport;
use App\Filament\Resources\ManyGawanganManualResource\Pages;
use App\Models\Blok;
use App\Models\ManyGawanganManual;
use Carbon\Carbon;
use Filament\Forms\Components\Actions\Action as ActionsAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
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
use Filament\Tables\Actions\CreateAction as ActionsCreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Set;
// use Filament\Notifications\Collection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rules\Unique;

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
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $blok = Blok::with('tahunTanam')->find($state);
                        if ($blok) {
                            $set('tahun_tanam_display', optional($blok->tahunTanam)->tahun_tanam);
                            $set('luas_lahan_display', $blok->luas_lahan);
                            $set('rencana_gawangan', $blok->luas_lahan); // Update disini
                        }
                    }),

                TextInput::make('tahun_tanam_display')
                    ->label('Tahun Tanam')
                    ->disabled()
                    ->dehydrated(false)
                    ->reactive()
                    ->required()
                    ->afterStateHydrated(function (callable $set, $state, $record) {
                        $set('tahun_tanam_display', optional($record?->blok?->tahunTanam)->tahun_tanam);
                    }),
                TextInput::make('luas_lahan_display')
                    ->label('Luas Lahan')
                    ->disabled()
                    ->dehydrated(false)
                    ->reactive()
                    ->required()
                    ->afterStateHydrated(function (callable $set, $state, $record) {
                        $set('luas_lahan_display', $record?->blok?->luas_lahan);
                    }),

                DatePicker::make('tanggal')
                    ->displayFormat('M Y')
                    ->native(false)
                    ->required(),
                TextInput::make('rencana_gawangan')
                    ->required()
                    ->hintAction(
                        ActionsAction::make('Isi Otomatis')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->tooltip('Salin dari Luas Lahan')
                            ->action(function (Set $set, $get) {
                                // 1. Ambil blok_id dari form
                                $blokId = $get('blok_id');

                                // 2. Cek apakah blok sudah dipilih
                                if (!$blokId) {
                                    Notification::make()
                                        ->title('Pilih blok terlebih dahulu!')
                                        ->danger()
                                        ->send();
                                    return;
                                }

                                // 3. Ambil data luas_lahan dari blok terkait
                                $blok = Blok::find($blokId);
                                $set('rencana_gawangan', $blok->luas_lahan);
                            })
                    ),
                TextInput::make('realisasi_gawangan')
                    ->hintAction(
                        ActionsAction::make('Isi Otomatis')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->tooltip('Salin dari Rencana Gawangan')
                            ->action(function (Set $set, $get) { // Gunakan $get untuk akses nilai field lain
                                $rencanaValue = $get('rencana_gawangan');
                                $set('realisasi_gawangan', $rencanaValue);
                            })
                    )

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Admin')
            ->description('Buat Rencana dan Realisasi Many Gawangan disini.')
            ->columns([
                TextColumn::make('blok.tahunTanam.tahun_tanam')
                    ->label('Tahun Tanam'),
                TextColumn::make('blok.nama_blok'),
                TextColumn::make('blok.luas_lahan')
                    ->label('Luas Lahan')
                    ->extraCellAttributes(['class' => 'flex justify-center']),
                TextColumn::make('tanggal')
                    ->label('Bulan')
                    ->formatStateUsing(function ($state) {
                        Carbon::setLocale('id');
                        return Carbon::parse($state)->translatedFormat('F');
                    }),
                TextColumn::make('rencana_gawangan')
                    ->label('Rencana')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('realisasi_gawangan')
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

                // Filter untuk realisasi yang sudah diisi atau belum (PERBAIKAN)
                Tables\Filters\SelectFilter::make('realisasi_status')
                    ->label('Status Realisasi')
                    ->options([
                        'filled' => 'Sudah Diisi',
                        'empty' => 'Belum Diisi',
                    ])
                    ->query(function ($query, $data) {
                        if ($data['value'] === 'filled') {
                            $query->whereNotNull('realisasi_gawangan');
                        } elseif ($data['value'] === 'empty') {
                            $query->whereNull('realisasi_gawangan');
                        }
                    }),
            ])
            ->actions([
                Action::make('updateRealisasi')
                    ->label('Realisasi')
                    ->button()
                    ->outlined()
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
                ViewAction::make()
                    ->iconButton()
                    ->color('primary')
                    ->infolist([
                        Section::make('Informasi Blok')
                            ->description('Detail informasi blok gawangan')
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

                        Section::make('Data Gawangan')
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
                                        TextEntry::make('rencana_gawangan')
                                            ->label('Rencana')
                                            ->badge()
                                            ->color('gray'),
                                        TextEntry::make('realisasi_gawangan')
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
                    ->icon('heroicon-o-clipboard-document-check')
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('isi_realisasi_terpilih')
                        ->label('Isi Realisasi Terpilih')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->icon('heroicon-o-document-check')
                        ->modalHeading('Konfirmasi')
                        ->modalDescription('Apakah Anda yakin ingin mengisi realisasi untuk baris yang dipilih dengan nilai rencana?')
                        ->action(function (Collection $selectedRecords) {
                            $updatedCount = ManyGawanganManual::whereIn('id', $selectedRecords->pluck('id'))
                                ->whereNull('realisasi_gawangan')
                                ->update([
                                    'realisasi_gawangan' => DB::raw('rencana_gawangan')
                                ]);

                            Notification::make()
                                ->title("Berhasil update {$updatedCount} realisasi")
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('hapus_bulan_terpilih')
                        ->label('Hapus Bulan Terpilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Penghapusan')
                        ->modalDescription('Apakah Anda yakin ingin menghapus bulan pada baris yang dipilih?')
                        ->action(function (Collection $selectedRecords) {
                            $affected = ManyGawanganManual::whereIn('id', $selectedRecords->pluck('id'))
                                ->whereNotNull('tanggal')
                                ->update([
                                    'tanggal' => null,
                                    'rencana_gawangan' => null,
                                    'realisasi_gawangan' => null,
                                    'updated_at' => now()
                                ]);

                            Notification::make()
                                ->title("Berhasil menghapus {$affected} realisasi")
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('hapus_realisasi_terpilih')
                        ->label('Hapus Realisasi Terpilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Penghapusan')
                        ->modalDescription('Apakah Anda yakin ingin menghapus realisasi pada baris yang dipilih?')
                        ->action(function (Collection $selectedRecords) {
                            $affected = ManyGawanganManual::whereIn('id', $selectedRecords->pluck('id'))
                                ->whereNotNull('realisasi_gawangan')
                                ->update([
                                    'realisasi_gawangan' => null,
                                    'updated_at' => now()
                                ]);

                            Notification::make()
                                ->title("Berhasil menghapus {$affected} realisasi")
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->headerActions([
                // ExportAction::make()->exporter(ManyGawanganManualExporter::class)
                //     ->label('Export')
                // CreateAction::make(),
                Action::make('create_bulk')
                    ->label('Buat/Update Rencana')
                    ->icon('heroicon-o-calendar')
                    ->form([
                        DatePicker::make('tanggal')
                            ->label('Bulan Target')
                            ->displayFormat('M Y')
                            ->native(false)
                            ->required()
                            ->closeOnDateSelection()
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $month = Carbon::parse($state)->format('m');
                                    $year = Carbon::parse($state)->format('Y');

                                    $existingBlokIds = ManyGawanganManual::whereMonth('tanggal', $month)
                                        ->whereMonth('tanggal', $month)
                                        ->pluck('blok_id')
                                        ->toArray();

                                    $set('existing_blok_ids', $existingBlokIds);
                                }
                            }),

                        Select::make('blok_ids')
                            ->label('Pilih Blok')
                            ->options(function ($get) {
                                $existingBlokIds = $get('existing_blok_ids') ?? [];
                                return Blok::whereNotIn('id', $existingBlokIds)
                                    ->pluck('nama_blok', 'id');
                            })
                            ->multiple()
                            ->required()
                            ->searchable()
                            ->preload()
                            ->hidden(fn($get) => empty($get('tanggal')))
                            ->helperText(function ($get) {
                                $existingBlokIds = $get('existing_blok_ids') ?? [];
                                if (count($existingBlokIds) > 0) {
                                    $existingBlokNames = Blok::whereIn('id', $existingBlokIds)
                                        ->pluck('nama_blok')
                                        ->implode(', ');
                                    return "Blok berikut sudah memiliki data di bulan ini: $existingBlokNames";
                                }
                                return null;
                            }),

                        TextInput::make('existing_blok_ids')
                            ->hidden()
                            ->dehydrated(false),
                    ])
                    ->action(function (array $data) {
                        $targetDate = Carbon::parse($data['tanggal']);

                        DB::transaction(function () use ($data, $targetDate) {
                            foreach ($data['blok_ids'] as $blokId) {
                                $blok = Blok::findOrFail($blokId);

                                $exists = ManyGawanganManual::where('blok_id', $blokId)
                                    // ->whereMonth('tanggal', $targetDate->month)
                                    // ->whereYear('tanggal', $targetDate->year)
                                    
                                    ->exists();

                                if ($exists) {
                                    ManyGawanganManual::where('blok_id', $blokId)
                                        // ->whereMonth('tanggal', $targetDate->month)
                                        // ->whereYear('tanggal', $targetDate->year)
                                        ->update([
                                            'tanggal' => $targetDate,
                                            'rencana_gawangan' => $blok->luas_lahan,
                                            'realisasi_gawangan' => null
                                        ]);
                                } else {
                                    ManyGawanganManual::create([
                                        'blok_id' => $blokId,
                                        'tanggal' => $targetDate,
                                        'rencana_gawangan' => $blok->luas_lahan,
                                        'realisasi_gawangan' => null
                                    ]);
                                }
                            }
                        });

                        Notification::make()
                            ->title('Data Berhasil Dibuat/Diperbarui')
                            ->success()
                            ->send();
                    }),
                Action::make('export')
                    ->label('Export Excel')
                    ->action(fn() => Excel::download(new ManyGawanganManualsExport, 'Rencana Pekerjaan Many Gawangan Manual.xlsx'))
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
            'index' => Pages\ListManyGawanganManuals::route('/'),
            'create' => Pages\CreateManyGawanganManual::route('/create'),
            'edit' => Pages\EditManyGawanganManual::route('/{record}/edit'),
        ];
    }
}
