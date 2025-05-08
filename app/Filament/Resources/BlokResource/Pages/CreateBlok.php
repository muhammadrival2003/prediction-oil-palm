<?php

namespace App\Filament\Resources\BlokResource\Pages;

use App\Filament\Resources\BlokResource;
use App\Models\TahunTanam;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlok extends CreateRecord
{
    protected static string $resource = BlokResource::class;

    // protected static ?string $title = 'Tambah Blok Baru';


    public function getHeading(): string
    {
        return 'Tambah Blok Baru'; // Judul lebih deskriptif
    }

    public function getSubheading(): ?string
    {
        $tahunTanamId = request('tahun_tanam_id');

        if ($tahunTanamId) {
            $tahunTanam = TahunTanam::find($tahunTanamId);

            if ($tahunTanam) {
                return 'Tahun Tanam: ' . $tahunTanam->tahun_tanam;
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
        return route('filament.admin.resources.bloks.index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Blok Baru Berhasil Dibuat';
    }
}
