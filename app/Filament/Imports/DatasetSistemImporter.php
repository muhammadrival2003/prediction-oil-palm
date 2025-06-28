<?php

namespace App\Filament\Imports;

use App\Models\DatasetSistem;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class DatasetSistemImporter extends Importer
{
    protected static ?string $model = DatasetSistem::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('tanggal')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('total_curah_hujan')
                ->numeric(decimalPlaces: 2),
            ImportColumn::make('total_pemupukan')
                ->numeric(decimalPlaces: 2),
            ImportColumn::make('total_hasil_produksi')
                ->numeric(decimalPlaces: 2),
        ];
    }

    public function resolveRecord(): ?DatasetSistem
    {
        // return DatasetSistem::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new DatasetSistem();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your dataset sistem import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
