<?php

namespace App\Filament\Pages;

use App\Filament\Resources\TahunTanamResource\Pages\ListTahunTanams;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class RencanaRealisasi extends Page
{
    public static function getNavigationLabel(): string
    {
        return __('Rencana dan Realisasi');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Rencana dan Realisasi');
    }

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Data Aktual';

    protected static string $view = 'filament.pages.rencana-realisasi';

    public static function getPages(): array
    {
        return [
            // ...
            'index' => ListTahunTanams::route('/'),
        ];
    }
}
