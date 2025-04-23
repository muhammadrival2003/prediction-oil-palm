<?php

namespace App\Filament\Resources\ManyGawanganManualResource\Pages;

use App\Filament\Resources\ManyGawanganManualResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManyGawanganManuals extends ListRecords
{
    protected static string $resource = ManyGawanganManualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
