<?php

namespace App\Filament\Resources\TahunTanamResource\Pages;

use App\Filament\Resources\TahunTanamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTahunTanams extends ListRecords
{
    protected static string $resource = TahunTanamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
