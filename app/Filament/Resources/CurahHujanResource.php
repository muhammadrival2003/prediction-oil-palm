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
use Illuminate\Support\Facades\DB;

class CurahHujanResource extends Resource
{
    protected static ?string $model = CurahHujan::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud';

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

                // Filter Rentang Bulan
                Tables\Filters\Filter::make('rentang_bulan')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('bulan_awal')
                                    ->label('Bulan Awal')
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
                                    ->placeholder('Pilih bulan awal'),
                                
                                Forms\Components\Select::make('bulan_akhir')
                                    ->label('Bulan Akhir')
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
                                    ->placeholder('Pilih bulan akhir'),
                            ]),
                        
                        Forms\Components\Select::make('tahun_rentang')
                            ->label('Tahun')
                            ->options(function () {
                                $years = range(now()->year, now()->year - 10);
                                return array_combine($years, $years);
                            })
                            ->placeholder('Pilih tahun (opsional)'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['bulan_awal'] && $data['bulan_akhir'],
                                function (Builder $query) use ($data) {
                                    $bulanAwal = (int) $data['bulan_awal'];
                                    $bulanAkhir = (int) $data['bulan_akhir'];
                                    
                                    if ($bulanAwal <= $bulanAkhir) {
                                        // Rentang dalam satu tahun
                                        $query->whereBetween(
                                            DB::raw('MONTH(tanggal)'),
                                            [$bulanAwal, $bulanAkhir]
                                        );
                                    } else {
                                        // Rentang lintas tahun (misal: Oktober - Februari)
                                        $query->where(function ($q) use ($bulanAwal, $bulanAkhir) {
                                            $q->where(DB::raw('MONTH(tanggal)'), '>=', $bulanAwal)
                                              ->orWhere(DB::raw('MONTH(tanggal)'), '<=', $bulanAkhir);
                                        });
                                    }
                                }
                            )
                            ->when(
                                $data['tahun_rentang'],
                                fn (Builder $query): Builder => $query->whereYear('tanggal', $data['tahun_rentang'])
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        
                        if ($data['bulan_awal'] && $data['bulan_akhir']) {
                            $bulanOptions = [
                                '1' => 'Januari', '2' => 'Februari', '3' => 'Maret',
                                '4' => 'April', '5' => 'Mei', '6' => 'Juni',
                                '7' => 'Juli', '8' => 'Agustus', '9' => 'September',
                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
                            ];
                            
                            $indicators['rentang_bulan'] = 'Rentang: ' . 
                                $bulanOptions[$data['bulan_awal']] . ' - ' . 
                                $bulanOptions[$data['bulan_akhir']];
                        }
                        
                        if ($data['tahun_rentang']) {
                            $indicators['tahun_rentang'] = 'Tahun: ' . $data['tahun_rentang'];
                        }
                        
                        return $indicators;
                    }),
            ])
            ->headerActions([
                ImportAction::make()
                    ->label('Impor')
                    ->importer(CurahHujanImporter::class),
                
                // Action untuk mengambil data dalam rentang bulan
                Tables\Actions\Action::make('fetch_rainfall_range')
                    ->label('Ambil Banyak Data CHIRPS')
                    ->icon('heroicon-o-calendar-days')
                    ->form([
                        Forms\Components\Select::make('tahun')
                            ->options(function () {
                                $years = range(now()->year, now()->year - 10);
                                return array_combine($years, $years);
                            })
                            ->required()
                            ->default(now()->year),
                        
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('bulan_awal')
                                    ->label('Bulan Awal')
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
                                    ->default(1),
                                
                                Forms\Components\Select::make('bulan_akhir')
                                    ->label('Bulan Akhir')
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
                                    ->default(6),
                            ]),
                        
                        Forms\Components\TextInput::make('scale')
                            ->label('Skala (meter)')
                            ->numeric()
                            ->default(5000),
                    ])
                    ->action(function (array $data) {
                        $service = new \App\Services\PredictionService();
                        
                        // Koordinat default
                        $coordinates = [
                            [97.34459802411389, 4.122294740126089],
                            [98.26744958661389, 4.122294740126089],
                            [98.26744958661389, 4.823273940269145],
                            [97.34459802411389, 4.823273940269145],
                            [97.34459802411389, 4.122294740126089]
                        ];
                        
                        $bulanAwal = (int) $data['bulan_awal'];
                        $bulanAkhir = (int) $data['bulan_akhir'];
                        $tahun = $data['tahun'];
                        
                        try {
                            $totalData = 0;
                            
                            // Loop untuk setiap bulan dalam rentang
                            for ($bulan = $bulanAwal; $bulan <= $bulanAkhir; $bulan++) {
                                $startDate = "{$tahun}-{$bulan}-01";
                                $endDate = date('Y-m-t', strtotime($startDate));
                                
                                $result = $service->getPrecipitationData(
                                    $coordinates,
                                    $startDate,
                                    $endDate,
                                    $data['scale']
                                );
                                
                                // Simpan data ke database
                                foreach ($result['data'] as $item) {
                                    \App\Models\CurahHujan::updateOrCreate(
                                        ['tanggal' => $item['date']],
                                        ['curah_hujan' => $item['precipitation_mm']]
                                    );
                                    $totalData++;
                                }
                            }
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Data Curah Hujan Berhasil Diambil')
                                ->body("Total {$totalData} data berhasil diambil untuk rentang bulan yang dipilih")
                                ->success()
                                ->send();
                                
                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Gagal Mengambil Data')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                
                Tables\Actions\Action::make('fetch_rainfall')
                    ->label('Ambil Data CHIRPS')
                    ->icon('heroicon-o-cloud-arrow-down')
                    ->form([
                        Forms\Components\Select::make('tahun')
                            ->options(function () {
                                $years = range(now()->year, now()->year - 10);
                                return array_combine($years, $years);
                            })
                            ->required()
                            ->default(now()->year),
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
                            ->default(now()->month),
                        Forms\Components\TextInput::make('scale')
                            ->label('Skala (meter)')
                            ->numeric()
                            ->default(5000),
                    ])
                    ->action(function (array $data) {
                        // Panggil service untuk mengambil data
                        $service = new \App\Services\PredictionService();

                        // Koordinat default (sesuaikan dengan kebutuhan)
                        $coordinates = [
                            [97.34459802411389, 4.122294740126089],
                            [98.26744958661389, 4.122294740126089],
                            [98.26744958661389, 4.823273940269145],
                            [97.34459802411389, 4.823273940269145],
                            [97.34459802411389, 4.122294740126089]
                        ];

                        // Hitung tanggal awal dan akhir bulan
                        $startDate = "{$data['tahun']}-{$data['bulan']}-01";
                        $endDate = date('Y-m-t', strtotime($startDate));

                        try {
                            $result = $service->getPrecipitationData(
                                $coordinates,
                                $startDate,
                                $endDate,
                                $data['scale']
                            );

                            // Simpan data ke database
                            foreach ($result['data'] as $item) {
                                \App\Models\CurahHujan::updateOrCreate(
                                    ['tanggal' => $item['date']],
                                    ['curah_hujan' => $item['precipitation_mm']]
                                );
                            }

                            \Filament\Notifications\Notification::make()
                                ->title('Data Curah Hujan Berhasil Diambil')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Gagal Mengambil Data')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
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
            'index' => Pages\ListCurahHujans::route('/'),
            'create' => Pages\CreateCurahHujan::route('/create'),
            'edit' => Pages\EditCurahHujan::route('/{record}/edit'),
        ];
    }
}