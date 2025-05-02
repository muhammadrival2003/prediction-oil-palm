<?php

namespace App\Filament\Resources\ChemisResource\Pages;

use App\Filament\Resources\ChemisResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateChemis extends CreateRecord
{
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.rencana-realisasi') => 'Rencana Realisasi',
            route('filament.admin.resources.chemis.index') => 'Chemis',
            url()->current() => $this->getTitle(),
        ];
    }
    protected static string $resource = ChemisResource::class;
}
