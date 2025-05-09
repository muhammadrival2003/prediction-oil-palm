<?php

namespace App\Filament\Pages;

use App\Models\Blok;
use App\Models\TahunTanam;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\View\View;
use Filament\Notifications\Actions\Action;

class TahunTanamBlok extends Page
{
    protected $listeners = ['undoDeleteBlok' => 'undoDeleteBlok'];
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.tahun-tanam-blok.tahun-tanam-blok';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public function getTitle(): string
    {
        return '';
    }

    public $bloks;
    public $tahunTanam;
    public $afdeling_id;

    public function mount(): void
    {
        $this->afdeling_id = request('afdeling_id');
        $tahunTanamId = request()->input('tahun_tanam_id');
        $this->tahunTanam = TahunTanam::find($tahunTanamId);
        $this->bloks = Blok::with('tahunTanam')
            ->where('tahun_tanam_id', $tahunTanamId)
            ->get();
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

    public function deleteBlok($id)
    {
        try {
            // $afdeling_id = request('afdeling_id');
            $blok = Blok::findOrFail($id);
            $tahunTanamId = $blok->tahun_tanam_id;
            $tahunTanam = TahunTanam::findOrFail($tahunTanamId);
            $afdeling_id = $tahunTanam->afdeling_id;



            $blok->delete();

            Notification::make()
                ->success()
                ->title('Blok Dihapus')
                ->body("Blok {$blok->nama_blok} dipindahkan ke trash.")
                ->persistent()
                ->actions([
                    Action::make('undo')
                        ->color('gray')
                        ->label('Batalkan')
                        ->dispatch('undoDeleteBlok', ['recordId' => $blok->id]),
                ])
                ->send();

            // Tambahkan afdeling_id ke redirect
            return redirect()->route('filament.admin.pages.tahun-tanam-blok', [
                'tahun_tanam_id' => $tahunTanamId,
                'afdeling_id' => $afdeling_id // 👈 Tambahkan ini
            ]);
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal!')
                ->body('Gagal menghapus blok: ' . $e->getMessage())
                ->danger()
                ->send();

            // Tambahkan afdeling_id ke redirect error
            return redirect()->route('filament.admin.pages.tahun-tanam-blok', [
                'tahun_tanam_id' => request('tahun_tanam_id'),
                'afdeling_id' => $this->afdeling_id // 👈 Tambahkan ini
            ]);
        }
    }

    public function getHeaders(): ?View
    {
        if (!$this->tahunTanam) {
            return null;
        }

        return view('filament.pages.header-table', [
            'tahunTanam' => $this->tahunTanam,
            'title' => 'Tahun Tanam',
            'subTitle' => 'Blok'
        ]);
    }
}
