<?php

namespace App\Filament\Resources\ManyGawanganManualResource\Pages;

use App\Filament\Resources\ManyGawanganManualResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManyGawanganManual extends EditRecord
{
    protected static string $resource = ManyGawanganManualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
