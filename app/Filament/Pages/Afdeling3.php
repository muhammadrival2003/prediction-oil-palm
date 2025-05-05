<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Afdeling3 extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.afdeling3';

    protected static ?string $navigationGroup = 'Afdeling';

    public static function getNavigationLabel(): string
    {
        return __('AFD III');
    }
}
