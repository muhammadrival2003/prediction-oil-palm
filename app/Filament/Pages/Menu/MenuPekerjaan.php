<?php

namespace App\Filament\Pages\Menu;

use Filament\Pages\Page;

class MenuPekerjaan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.menu.menu-pekerjaan';
    protected static ?string $title = '';

    public $afdeling_id;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount():void
    {
        $this->afdeling_id = request('afdeling_id');
        
    }
}
