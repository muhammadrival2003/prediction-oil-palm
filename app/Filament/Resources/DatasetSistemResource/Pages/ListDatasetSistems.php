<?php

namespace App\Filament\Resources\DatasetSistemResource\Pages;

use App\Filament\Resources\DatasetSistemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDatasetSistems extends ListRecords
{
    protected static string $resource = DatasetSistemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
