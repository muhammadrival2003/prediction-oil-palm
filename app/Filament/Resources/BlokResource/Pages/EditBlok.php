<?php

namespace App\Filament\Resources\BlokResource\Pages;

use App\Filament\Pages\TahunTanam;
use App\Filament\Resources\BlokResource;
use App\Models\Afdeling;
use App\Models\TahunTanam as ModelsTahunTanam;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlok extends EditRecord
{
    protected static string $resource = BlokResource::class;

    public $afdeling;
    public $tahunTanam;

    public function getHeading(): string
    {
        return 'Ubah Blok'; // Judul lebih deskriptif
    }
    

    protected function getHeaderActions(): array
    {

        $routeParams = [];

        if (request()->has('tahun_tanam_id')) {
            $nameRoute = 'filament.admin.pages.tahun-tanam-blok';
            $routeParams = ['tahun_tanam_id' => request('tahun_tanam_id'), 'afdeling_id' => request('afdeling_id')];
        } else {
            $nameRoute = 'filament.admin.resources.bloks.index';
            $routeParams = [];
        }

        return [
            Actions\Action::make('kembali')
                ->label('Kembali')
                ->color('gray')
                ->url(route($nameRoute, $routeParams))
                ->icon('heroicon-o-arrow-left'),
        ];
    }

    public function getSubheading(): ?string
    {
        $tahunTanamId = request('tahun_tanam_id');

        if ($tahunTanamId) {
            $this->tahunTanam = ModelsTahunTanam::findOrFail($tahunTanamId);
            $this->afdeling = Afdeling::findOrFail($this->tahunTanam->afdeling_id);

            if ($this->tahunTanam) {
                return 'Tahun Tanam: ' . $this->tahunTanam->tahun_tanam;
            }
        }
        return null; // Jika tidak ada tahun_tanam_id atau data tidak ditemukan
    }

    protected function getRedirectUrl(): string
    {
        $tahun_tanam_id = $this->tahunTanam->id;
        $afdeling_id = $this->afdeling->id;
        return route('filament.admin.pages.tahun-tanam-blok', ['tahun_tanam_id' => $tahun_tanam_id, 'afdeling_id' => $afdeling_id]);
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Blok Baru Berhasil Diubah';
    }
}
