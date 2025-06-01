<?php

namespace App\Filament\Pages;

use App\Models\TahunTanam as ModelsTahunTanam;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\View\View;
use Filament\Actions;

use function Laravel\Prompts\confirm;

class TahunTanam extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tahun-tanam';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return '';
    }

    public $tahunTanams;
    public $totalTahunTanam;
    public $totalBlok;
    public $totalPokok;
    public $averageBlokPerTahun;
    public $afdeling_id;
    public function mount()
    {
        $this->afdeling_id = request('afdeling_id');

        // Modifikasi query untuk filter berdasarkan afdeling_id
        $this->tahunTanams = ModelsTahunTanam::where('afdeling_id', $this->afdeling_id)
            ->withCount([
                'bloks',
                'bloks as total_pokok' => function ($query) {
                    $query->select(FacadesDB::raw('sum(jumlah_pokok)'));
                }
            ])->get();

        $this->totalBlok = $this->tahunTanams->sum('bloks_count');
        $this->totalPokok = $this->tahunTanams->sum('total_pokok');
        $this->totalTahunTanam = $this->tahunTanams->count();
        $this->averageBlokPerTahun = $this->totalTahunTanam > 0
            ? round($this->totalBlok / $this->totalTahunTanam, 1)
            : 0;
    }

    public function getColor($tahun)
    {
        // Sesuaikan dengan logika bisnis Anda
        $currentYear = date('Y');
        if ($tahun->tahun_tanam == $currentYear) {
            return 'blue'; // Tahun aktif
        } elseif ($tahun->tahun_tanam == $currentYear - 1) {
            return 'green'; // Tahun sebelumnya
        } else {
            return 'amber'; // Tahun arsip
        }
    }

    public function getStatus($tahun)
    {
        // $currentYear = date('Y');
        // if ($tahun->tahun_tanam == $currentYear) {
        //     return 'Aktif';
        // } elseif ($tahun->tahun_tanam == $currentYear - 1) {
        //     return 'Selesai';
        // } else {
        //     return 'Arsip';
        // }

        return 'Tahun Tanam';
    }

    public function getIcon($tahun)
    {
        // $currentYear = date('Y');
        // if ($tahun->tahun_tanam == $currentYear) {
        //     return '🌱'; // Tanam baru
        // } elseif ($tahun->tahun_tanam == $currentYear - 1) {
        //     return '🌾'; // Panen
        // } else {
        //     return '🍂'; // Arsip
        // }

        return '🌴';
    }

    public function getDescription($tahun)
    {
        $currentYear = date('Y');
        if ($tahun->tahun_tanam == $currentYear) {
            return 'Tahun tanam saat ini, tanaman dalam masa pertumbuhan';
        } elseif ($tahun->tahun_tanam == $currentYear - 1) {
            return 'Tahun tanam sebelumnya, hasil panen telah dicatat';
        } else {
            return 'Tahun tanam lama, data tersimpan sebagai arsip';
        }
    }

    public function getButtonColor($tahun)
    {
        $currentYear = date('Y');
        if ($tahun->tahun_tanam == $currentYear) {
            return 'emerald';
        } elseif ($tahun->tahun_tanam == $currentYear - 1) {
            return 'success';
        } else {
            return 'warning';
        }
    }

    public function buttonAdd()
    {
        return 'filament.admin.resources.tahun-tanams.create';
    }


    public function deleteTahunTanam($id)
    {
        try {
            $tahunTanam = ModelsTahunTanam::findOrFail($id);
            $afdeling_id = $tahunTanam->afdeling_id;
            $tahunTanam->delete();

            // Memuat ulang semua data
            $this->mount();

            Notification::make()
                ->title('Berhasil!')
                ->body('Tahun tanam berhasil dihapus')
                ->success()
                ->send();


            return redirect()->route(
                    'filament.admin.pages.tahun-tanam',
                    ['afdeling_id' => $afdeling_id],
                );
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal!')
                ->body('Gagal menghapus tahun tanam: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function getHeaders(): ?View
    {

        return view('filament.pages.tahun-tanam.header-tahun-tanam', [
            'totalTahunTanam' => $this->totalTahunTanam,
            'totalBlok' => $this->totalBlok,
            'totalPokok' => $this->totalPokok,
        ]);
    }
}
