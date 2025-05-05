<?php

namespace App\Filament\Resources\TahunTanamResource\Pages;

use App\Filament\Resources\TahunTanamResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTahunTanam extends CreateRecord
{
    protected static string $resource = TahunTanamResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.pages.tahun-tanam');
    }

    protected function getHeaderActions(): array
    {

        return [
            Actions\Action::make('kembali')
                ->label('Kembali')
                ->color('gray')
                ->url(route('filament.admin.pages.tahun-tanam'))
                ->icon('heroicon-o-arrow-left'),
        ];
    }
}
