<?php

namespace App\Filament\Imports;

use App\Models\CurahHujan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CurahHujanImporter extends Importer
{
    protected static ?string $model = CurahHujan::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('tanggal')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('curah_hujan')
                ->requiredMapping()
                ->numeric(),
        ];
    }

    public function resolveRecord(): ?CurahHujan
    {
        // return CurahHujan::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new CurahHujan();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your curah hujan import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
