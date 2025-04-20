<?php

namespace App\Filament\Resources\TahunTanamResource\Pages;

use App\Filament\Resources\TahunTanamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTahunTanam extends EditRecord
{
    protected static string $resource = TahunTanamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
