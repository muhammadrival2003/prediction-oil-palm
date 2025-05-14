<?php

namespace App\Filament\Pages\Menu;

use Filament\Pages\Page;

class MenuPekerjaan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.menu.menu-pekerjaan';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
