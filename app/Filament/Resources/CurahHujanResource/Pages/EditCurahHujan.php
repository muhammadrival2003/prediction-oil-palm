<?php

namespace App\Filament\Resources\CurahHujanResource\Pages;

use App\Filament\Resources\CurahHujanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurahHujan extends EditRecord
{
    protected static string $resource = CurahHujanResource::class;
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['bulan'] = date('n', strtotime($data['tanggal']));
        $data['tahun'] = date('Y', strtotime($data['tanggal']));
        return $data;
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['tanggal'] = sprintf('%s-%s-01', $data['tahun'], str_pad($data['bulan'], 2, '0', STR_PAD_LEFT));
        return $data;
    }
}
