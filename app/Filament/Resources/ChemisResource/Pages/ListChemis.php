<?php

namespace App\Filament\Resources\ChemisResource\Pages;

use App\Filament\Resources\ChemisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChemis extends ListRecords
{
    protected static string $resource = ChemisResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.rencana-realisasi') => 'Rencana Realisasi',
            url()->current() => $this->getTitle(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
