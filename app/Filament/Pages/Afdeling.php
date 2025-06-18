<?php

namespace App\Filament\Pages;

use App\Models\Afdeling as ModelsAfdeling;
use Filament\Pages\Page;

class Afdeling extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map';
    
    protected static string $view = 'filament.pages.afdeling';

    public function getHeading(): string
    {
        return '';
    }
    protected static ?int $navigationSort = 3;

    public $afdelings;

    public function mount()
    {
        $this->afdelings = ModelsAfdeling::orderBy('nama')->get();
    }
}
