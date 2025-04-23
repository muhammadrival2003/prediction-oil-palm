<?php

namespace App\Filament\Resources\ManyGawanganManualResource\Pages;

use App\Filament\Resources\ManyGawanganManualResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManyGawanganManual extends CreateRecord
{
    protected static string $resource = ManyGawanganManualResource::class;

    // Custome Redirect After Create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
