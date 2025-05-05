<?php

namespace App\Filament\Resources\BlokResource\Pages;

use App\Filament\Resources\BlokResource;
use App\Models\Blok;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
// use Filament\Actions\Action;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListBloks extends ListRecords
{
    protected $listeners = ['undoDeleteBlok' => 'undoDeleteBlok'];
    protected static string $resource = BlokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // dd(request()->all()),
            Actions\Action::make('kembali')
                ->label('Kembali')
                ->color('gray')
                ->url(route('filament.admin.pages.tahun-tanam'))
                ->icon('heroicon-o-arrow-left'),
            CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $tahunTanamId = request('tahun_tanam_id');

        if (!$tahunTanamId) {
            return null;
        }

        return view('filament.pages.filter-info', [
            'tahunTanam' => \App\Models\TahunTanam::find($tahunTanamId),
            'tahunTanamId' => $tahunTanamId // Kirim juga ID ke view
        ]);
    }

    public function undoDeleteBlok($recordId)
    {
        $record = Blok::withTrashed()->find($recordId);

        if ($record) {
            $record->restore();

            Notification::make()
                ->success()
                ->title('Blok Dikembalikan')
                ->body("Blok {$record->nama_blok} berhasil dikembalikan.")
                ->send();
        }
    }
}
