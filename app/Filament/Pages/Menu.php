<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\View\View;

class Menu extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.menu';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public $afdeling_id;

    public function mount()
    {
        $this->afdeling_id = request('afdeling_id');
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('kembali')
                ->label('Kembali')
                ->color('gray')
                ->url(route('filament.admin.pages.afdeling'))
                ->icon('heroicon-o-arrow-left'),
        ];
    }
}
