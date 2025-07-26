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
        $afdeling_id = request('afdeling_id');
        return [
            Actions\CreateAction::make()
                ->label('Tambah'),
            Actions\Action::make('kembali')
                ->label('Kembali')
                ->color('gray')
                ->url(route('filament.admin.pages.afdeling.menu', ['afdeling_id' => $afdeling_id]))
                ->icon('heroicon-o-arrow-left'),
        ];
    }
}
