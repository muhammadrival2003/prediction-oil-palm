<?php

namespace App\Filament\Resources\TahunTanamResource\Pages;

use App\Filament\Resources\TahunTanamResource;
use App\Models\Afdeling;
use App\Models\TahunTanam;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTahunTanam extends CreateRecord
{
    protected static string $resource = TahunTanamResource::class;

    public $afdeling_id;
    public $tahun_tanam_id;
    public $afdeling;
    public $tahunTanam;

    protected function getHeaderActions(): array
    {
        $afdeling_id = request('afdeling_id');

        return [
            Actions\Action::make('kembali')
                ->label('Kembali')
                ->color('gray')
                ->url(route('filament.admin.pages.tahun-tanam', ['afdeling_id' => $afdeling_id]))
                ->icon('heroicon-o-arrow-left'),
        ];
    }

    public function getSubheading(): ?string
    {
        $afdelingId = request('afdeling_id');

        if ($afdelingId) {
            $this->afdeling = Afdeling::findOrFail($afdelingId);

            if ($this->afdeling) {
                return 'Afdeling: ' . $this->afdeling->nama;
            }
        }
        return null; 
    }

    protected function getRedirectUrl(): string
    {
        $afdeling_id = $this->afdeling->id;
        
        return route('filament.admin.pages.tahun-tanam', ['afdeling_id' => $afdeling_id]);
    }
}
