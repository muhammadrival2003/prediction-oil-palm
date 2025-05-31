<?php

namespace App\Filament\Resources\KaryawanLapanganResource\Pages;

use App\Filament\Resources\KaryawanLapanganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKaryawanLapangan extends EditRecord
{
    protected static string $resource = KaryawanLapanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
