<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Afdeling5 extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.afdeling5';

    protected static ?string $navigationGroup = 'Afdeling';

    public static function getNavigationLabel(): string
    {
        return __('AFD V');
    }

    protected static ?string $title = 'AFDELING V';
}
