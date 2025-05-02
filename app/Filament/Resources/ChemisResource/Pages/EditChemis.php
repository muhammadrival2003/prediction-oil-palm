<?php

namespace App\Filament\Resources\ChemisResource\Pages;

use App\Filament\Resources\ChemisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChemis extends EditRecord
{
    protected static string $resource = ChemisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
