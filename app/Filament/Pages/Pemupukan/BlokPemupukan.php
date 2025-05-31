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
    public $afdeling_id;

    public function mount()
    {
        $afdeling_id = request('afdeling_id'); 
        $this->afdeling_id = request('afdeling_id');

        $this->bloks = Blok::whereHas('tahunTanam', function ($query) use ($afdeling_id) {
            $query->where('afdeling_id', $afdeling_id);
        })
            ->with(['tahunTanam', 'pemupukans' => function ($query) {
                $query->orderBy('tanggal', 'desc');
            }])
            ->get();
    }
}
