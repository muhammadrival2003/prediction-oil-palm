<?php

namespace App\Filament\Resources\ManyGawanganManualResource\Pages;

use App\Filament\Resources\ManyGawanganManualResource;
use App\Models\ManyGawanganManual;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

class ListManyGawanganManuals extends ListRecords
{
    protected static string $resource = ManyGawanganManualResource::class;
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.rencana-realisasi') => 'Rencana Realisasi',
            url()->current() => $this->getTitle(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make()
            //         ->model(ManyGawanganManual::class)
            //         ->label('Create')
            //         ->button()
            //         ->form([
            //             TextInput::make('blok.tahunTanam.tahun_tanam')
            //                 ->label('Tahun Tanam')
            //                 ->required()
            //                 ->numeric()
            //                 ->minValue(0),
            //         ]),
            // ->fillForm(fn(ManyGawanganManual $record): array => [
            //     'realisasi_gawangan' => $record->rencana_gawangan,
            // ])
        ];
    }
}
