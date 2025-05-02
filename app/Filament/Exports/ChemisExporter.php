<?php

namespace App\Filament\Exports;

use App\Models\Chemis;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;

class ChemisExporter extends Exporter
{
    protected static ?string $model = Chemis::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID')
                ->formatStateUsing(fn(string $state): string => "#" . $state),

            ExportColumn::make('blok_id')
                ->label('Blok ID'),

            ExportColumn::make('tanggal')
                ->label('Tanggal')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y')),

            ExportColumn::make('rencana_gawangan')
                ->label('Rencana Gawangan')
                ->formatStateUsing(fn($state) => number_format($state)),

            ExportColumn::make('realisasi_gawangan')
                ->label('Realisasi Gawangan')
                ->formatStateUsing(fn($state) => number_format($state)),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export data gawangan manual telah selesai dengan ' . number_format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diekspor.';
        }

        return $body;
    }
}
