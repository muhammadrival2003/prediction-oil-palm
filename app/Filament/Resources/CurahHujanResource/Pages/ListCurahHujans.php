<?php

namespace App\Filament\Resources\CurahHujanResource\Pages;

use App\Filament\Imports\CurahHujanImporter;
use App\Filament\Resources\CurahHujanResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListCurahHujans extends ListRecords
{
    protected static string $resource = CurahHujanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
             ->label('Buat'),
            //  ImportAction::make()
            //         ->label('Import')
            //         ->importer(CurahHujanImporter::class)
        ];
    }
}
