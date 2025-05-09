<?php

namespace App\Filament\Resources\BlokResource\Pages;

use App\Filament\Resources\BlokResource;
use App\Models\Afdeling;
use App\Models\TahunTanam;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlok extends CreateRecord
{
    protected static string $resource = BlokResource::class;

    // protected static ?string $title = 'Tambah Blok Baru';
    public $tahun_tanam_id;
    public $afdeling;
    public $tahunTanam;


    public function getHeading(): string
    {
        return 'Tambah Blok Baru'; // Judul lebih deskriptif
    }

    public function getSubheading(): ?string
    {
        $tahunTanamId = request('tahun_tanam_id');

        if ($tahunTanamId) {
            $this->tahunTanam = TahunTanam::findOrFail($tahunTanamId);
            $this->afdeling = Afdeling::findOrFail($this->tahunTanam->afdeling_id);

            if ($this->tahunTanam) {
                return 'Tahun Tanam: ' . $this->tahunTanam->tahun_tanam;
            }
        }
        return null; // Jika tidak ada tahun_tanam_id atau data tidak ditemukan
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
            // dd(request()->all()),
            Actions\Action::make('kembali')
                ->label('Kembali')
                ->color('gray')
                ->url(route($nameRoute, $routeParams))
                ->icon('heroicon-o-arrow-left'),
        ];;
    }

    protected function getRedirectUrl(): string
    {
        $tahun_tanam_id = $this->tahunTanam->id;
        $afdeling_id = $this->afdeling->id;
        return route('filament.admin.pages.tahun-tanam-blok', ['tahun_tanam_id' => $tahun_tanam_id, 'afdeling_id' => $afdeling_id]);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Blok Baru Berhasil Dibuat';
    }
}
