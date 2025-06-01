<?php

namespace App\Filament\Pages;

use App\Models\ActivityLog;
use App\Models\Blok;
use App\Models\HasilProduksi;
use App\Models\KaryawanLapangan;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    public function getHeading(): string
    {
        return '';
    }
    protected static string $view = 'filament.pages.dashboard';
    protected static ?int $navigationSort = 1;

    public $totalBlok;
    public $totalProduksi;
    public $totalLuasLahan;
    public $produksiPerBlok;
    public $topBloks; // Tambahkan property untuk menyimpan data top blok
    public $recentActivities;


    public function mount()
    {
        $this->totalBlok = Blok::count();
        $this->totalProduksi = HasilProduksi::sum('realisasi_produksi');
        $this->totalLuasLahan = Blok::sum('luas_lahan');
        $this->produksiPerBlok = $this->totalLuasLahan > 0
            ? $this->totalProduksi / $this->totalLuasLahan
            : 0;

        // Tambahkan query untuk top blok
        $this->topBloks = Blok::withSum('hasilProduksis', 'realisasi_produksi')
            ->orderByDesc('hasil_produksis_sum_realisasi_produksi')
            ->take(5)
            ->get();
        $this->recentActivities = $this->getRecentActivities();
    }

    // Method baru untuk mengambil aktivitas terkini
    private function getRecentActivities()
    {
        return ActivityLog::with(['user', 'blok'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'type' => $activity->activity_type,
                    'description' => $activity->description,
                    'blok' => $activity->blok->nama_blok,
                    'weight' => $activity->data['weight'] ?? 0,
                    'date' => $activity->created_at,
                    'icon' => $this->getActivityIcon($activity->activity_type),
                    'color' => $this->getActivityColor($activity->activity_type)
                ];
            });
    }

    // Helper untuk icon aktivitas
    private function getActivityIcon($type)
    {
        return match ($type) {
            'verified' => 'fa-check',
            'created' => 'fa-plus',
            'pending' => 'fa-exclamation',
            'updated' => 'fa-edit',
            default => 'fa-circle'
        };
    }

    // Helper untuk warna aktivitas
    private function getActivityColor($type)
    {
        return match ($type) {
            'verified' => 'green',
            'created' => 'blue',
            'pending' => 'yellow',
            'updated' => 'purple',
            default => 'gray'
        };
    }
}
