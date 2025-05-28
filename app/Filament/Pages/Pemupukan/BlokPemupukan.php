<?php

namespace App\Filament\Pages\Pemupukan;

use App\Models\Blok;
use Filament\Pages\Page;

class BlokPemupukan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pemupukan.blok-pemupukan';

    protected static ?string $title = '';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public $bloks;

    public function mount()
    {
        $this->bloks = Blok::all();
    }
}
