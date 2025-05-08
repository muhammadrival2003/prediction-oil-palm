<?php

namespace App\Filament\Resources\BlokResource\Pages;

use App\Filament\Pages\TahunTanam;
use App\Filament\Resources\BlokResource;
use App\Models\TahunTanam as ModelsTahunTanam;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlok extends EditRecord
{
    protected static string $resource = BlokResource::class;

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
            $tahunTanam = ModelsTahunTanam::find($tahunTanamId);

            if ($tahunTanam) {
                return 'Tahun Tanam: ' . $tahunTanam->tahun_tanam;
            }
        }

        return null; // Jika tidak ada tahun_tanam_id atau data tidak ditemukan
    }

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.bloks.index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Blok Baru Berhasil Diubah';
    }
}
