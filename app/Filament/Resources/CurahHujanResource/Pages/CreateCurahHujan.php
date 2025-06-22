<?php

namespace App\Filament\Resources\CurahHujanResource\Pages;

use App\Filament\Resources\CurahHujanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCurahHujan extends CreateRecord
{
    protected static string $resource = CurahHujanResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tanggal'] = sprintf('%s-%s-01', $data['tahun'], str_pad($data['bulan'], 2, '0', STR_PAD_LEFT));
        return $data;
    }
}