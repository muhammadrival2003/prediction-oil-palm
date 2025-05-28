<?php

namespace App\Filament\Resources\DatasetSistemResource\Pages;

use App\Filament\Resources\DatasetSistemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDatasetSistem extends EditRecord
{
    protected static string $resource = DatasetSistemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
