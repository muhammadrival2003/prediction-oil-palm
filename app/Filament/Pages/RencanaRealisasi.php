<?php

namespace App\Filament\Pages;

use App\Filament\Resources\TahunTanamResource\Pages\ListTahunTanams;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class RencanaRealisasi extends Page
{
    protected static ?string $title = 'Rencana';
    // public function getBreadcrumbs(): array
    // {
    //     return [
    //         route('filament.admin.pages.rencana-realisasi') => 'Rencana Realisasi',
    //         url()->current() => 'Rencana',
    //     ];
    // }
    public static function getNavigationLabel(): string
    {
        return __('Rencana dan Realisasi');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Rencana dan Realisasi');
    }

    // protected static ?int $navigationSort = 3;
    // protected static ?string $navigationGroup = 'Data Aktual';

    protected static string $view = 'filament.pages.rencana-realisasi';

    protected static ?string $navigationIcon = 'heroicon-s-document-text';

    public static function getPages(): array
    {
        return [
            // ...
            'index' => ListTahunTanams::route('/'),
        ];
    }
}
