<?php

namespace App\Filament\Pages\Produksi;

use App\Models\Blok;
use Filament\Pages\Page;

class BlokProduksi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.produksi.blok-produksi';
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
