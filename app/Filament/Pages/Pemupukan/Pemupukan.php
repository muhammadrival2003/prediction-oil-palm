<?php

namespace App\Filament\Pages\Pemupukan;

use Filament\Pages\Page;
use App\Models\Pemupukan as ModelsPemupukan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class Pemupukan extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.pemupukan.pemupukan';
    protected static ?string $title = '';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public $blokId;
    public $data = [];
    public $editMode = false;
    public $selectedId;
    public $pemupukans;
    public $isDeleteModalOpen = false;
    public $deleteId;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Form Pemupukan')
                    ->schema([
                        DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->required()
                            ->closeOnDateSelection()
                            ->native(false),

                        TextInput::make('dosis')
                            ->label('Dosis (kg/pokok)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(0.01),

                        TextInput::make('volume')
                            ->label('Volume (kg)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(0.01)
                    ])
            ])
            ->statePath('data');
    }

    public function mount()
    {
        $this->blokId = request('blok_id');
        $this->loadData();
    }

    public function loadData()
    {
        $this->pemupukans = ModelsPemupukan::where('blok_id', $this->blokId)
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
        $data = ModelsPemupukan::findOrFail($id);

        $this->form->fill([
            'tanggal' => $data->tanggal,
            'dosis' => $data->dosis,
            'volume' => $data->volume,
        ]);

        $this->editMode = true;
        $this->dispatch('open-modal', id: 'form-modal');
    }

    public function store()
    {
        $this->form->getState();

        DB::transaction(function () {
            $pemupukan = ModelsPemupukan::create(array_merge(
                ['blok_id' => $this->blokId],
                $this->form->getState()
            ));

            // Panggil method update dataset
            $this->updateDatasetSistem($pemupukan->tanggal);

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
            $data = ModelsPemupukan::findOrFail($this->selectedId);
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
            $data = ModelsPemupukan::findOrFail($this->deleteId);
            $tanggal = $data->tanggal;
            $data->delete();

            // Panggil method update dataset
            $this->updateDatasetSistem($tanggal);

            Notification::make()
                ->title('Data berhasil dihapus')
                ->success()
                ->send();
        });

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

    protected function updateDatasetSistem($tanggal)
    {
        $bulan = date('n', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $totalVolume = ModelsPemupukan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('volume');

        \App\Models\DatasetSistem::updateOrCreate(
            ['bulan' => $bulan, 'tahun' => $tahun],
            ['total_pemupukan' => $totalVolume]
        );
    }
}
