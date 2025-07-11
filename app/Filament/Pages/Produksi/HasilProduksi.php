<?php

namespace App\Filament\Pages\Produksi;

use App\Models\DatasetSistem;
use App\Models\HasilProduksi as ModelsHasilProduksi;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class HasilProduksi extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.produksi.hasil-produksi';

    protected static ?string $title = '';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public $blokId;
    public $data = [];
    public $editMode = false;
    public $selectedId;
    public $hasilProduksis;
    public $isDeleteModalOpen = false;
    public $deleteId;
    public $afdeling_id;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->closeOnDateSelection(),

                TextInput::make('rencana_produksi')
                    ->label('Rencana Produksi (kg)')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01),

                TextInput::make('realisasi_produksi')
                    ->label('Realisasi Produksi (kg)')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01)
            ])
            ->statePath('data');
    }

    public function mount()
    {
        $this->afdeling_id = request('afdeling_id');
        $this->blokId = request('blok_id');
        $this->loadData();
    }

    public function loadData()
    {
        $this->hasilProduksis = ModelsHasilProduksi::where('blok_id', $this->blokId)
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function openCreateModal()
    {
        $this->editMode = false;
        $this->form->fill();
        $this->dispatch('open-modal', id: 'form-modal');
    }

    public function edit($id)
    {
        $this->selectedId = $id;
        $data = ModelsHasilProduksi::findOrFail($id);

        $this->form->fill([
            'tanggal' => $data->tanggal,
            'rencana_produksi' => $data->rencana_produksi,
            'realisasi_produksi' => $data->realisasi_produksi,
        ]);

        $this->editMode = true;
        $this->dispatch('open-modal', id: 'form-modal');
    }

    public function store()
    {
        $this->form->validate();

        DB::transaction(function () {
            $hasilProduksi = ModelsHasilProduksi::create(array_merge(
                ['blok_id' => $this->blokId],
                $this->form->getState()
            ));

            // Panggil method update dataset
            $this->updateDatasetSistem($hasilProduksi->tanggal);

            Notification::make()
                ->title('Data berhasil ditambahkan')
                ->success()
                ->send();
        });

        $this->dispatch('close-modal', id: 'form-modal');
        $this->form->fill();
        $this->loadData();
    }

    public function update()
    {
        $this->form->validate();

        DB::transaction(function () {
            $data = ModelsHasilProduksi::findOrFail($this->selectedId);
            $data->update($this->form->getState());

            // Panggil method update dataset
            $this->updateDatasetSistem($data->tanggal);

            Notification::make()
                ->title('Data berhasil diupdate')
                ->success()
                ->send();
        });

        $this->dispatch('close-modal', id: 'form-modal');
        $this->form->fill();
        $this->loadData();
        $this->editMode = false;
        $this->selectedId = null;
    }


    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->isDeleteModalOpen = true;
        $this->dispatch('open-modal', id: 'delete-modal');
    }


    public function delete()
    {
        DB::transaction(function () {
            $data = ModelsHasilProduksi::findOrFail($this->deleteId);
            $tanggal = $data->tanggal;
            $data->delete();

            // Panggil method update dataset
            $this->updateDatasetSistem($tanggal);

            Notification::make()
                ->title('Data berhasil dihapus')
                ->success()
                ->send();
        });

        $this->dispatch('close-modal', id: 'delete-modal');
        $this->isDeleteModalOpen = false;
        $this->deleteId = null;
        $this->loadData();
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', id: 'form-modal');
        $this->isDeleteModalOpen = false;
        $this->form->fill();
        $this->editMode = false;
        $this->selectedId = null;
    }

    // Models/HasilProduksi.php
    protected static function updateDatasetSistem($tanggal)
    {
        $month = date('n', strtotime($tanggal));
        $year = date('Y', strtotime($tanggal));

        $totalProduksi = \App\Models\HasilProduksi::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('realisasi_produksi');

        // Cari record dengan bulan dan tahun yang sama
        $existingRecord = DatasetSistem::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->first();

        if ($existingRecord) {
            // Update record yang sudah ada
            $existingRecord->update(['total_hasil_produksi' => $totalProduksi]);
        } else {
            // Buat record baru dengan tanggal pertama bulan tersebut
            DatasetSistem::create([
                'tanggal' => date('Y-m-01', strtotime($tanggal)),
                'total_hasil_produksi' => $totalProduksi
            ]);
        }
    }
}
