<?php

namespace App\Filament\Resources\KaryawanLapanganResource\Pages;

use App\Filament\Resources\KaryawanLapanganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKaryawanLapangans extends ListRecords
{
    protected static string $resource = KaryawanLapanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
