<?php

namespace App\Filament\Resources\TahunTanamResource\Pages;

use App\Filament\Resources\TahunTanamResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTahunTanam extends CreateRecord
{
    protected static string $resource = TahunTanamResource::class;

    public $afdeling_id;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.pages.tahun-tanam');
    }

    protected function getHeaderActions(): array
    {
        $this->afdeling_id = request('afdeling_id');

        return [
            Actions\Action::make('kembali')
                ->label('Kembali')
                ->color('gray')
                ->url(route('filament.admin.pages.tahun-tanam', ['afdeling_id' => $this->afdeling_id]))
                ->icon('heroicon-o-arrow-left'),
        ];
    }
}
