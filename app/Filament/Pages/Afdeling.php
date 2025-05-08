<?php

namespace App\Filament\Pages;

use App\Models\Afdeling as ModelsAfdeling;
use Filament\Pages\Page;

class Afdeling extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.afdeling';

    public $afdelings;

    public function mount()
    {
        $this->afdelings = ModelsAfdeling::orderBy('nama')->get();
    }
}
