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
    public $afdeling_id;

    public function mount()
    {
        $afdeling_id = request('afdeling_id'); 
        $this->afdeling_id = request('afdeling_id');

        $this->bloks = Blok::whereHas('tahunTanam', function ($query) use ($afdeling_id) {
            $query->where('afdeling_id', $afdeling_id);
        })
            ->with(['tahunTanam', 'hasilProduksis' => fn($q) => $q->orderBy('tanggal', 'desc')])
            ->withCount('hasilProduksis') // Tetap tambahkan counter terpisah
            ->get();
    }
}
