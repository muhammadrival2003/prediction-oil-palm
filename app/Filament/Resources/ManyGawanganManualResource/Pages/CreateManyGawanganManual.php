<?php

namespace App\Filament\Resources\ManyGawanganManualResource\Pages;

use App\Filament\Resources\ManyGawanganManualResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManyGawanganManual extends CreateRecord
{
    protected static string $resource = ManyGawanganManualResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.rencana-realisasi') => 'Rencana Realisasi',
            route('filament.admin.resources.many-gawangan-manuals.index') => 'Many Gawangan Manual',
            url()->current() => $this->getTitle(),
        ];
    }

    // Custome Redirect After Create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
