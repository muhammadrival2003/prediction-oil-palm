<?php

namespace App\Filament\Pages;

use App\Models\ActivityLog;
use App\Models\Blok;
use App\Models\DatasetSistem;
use App\Models\HasilProduksi;
use App\Models\KaryawanLapangan;
use Filament\Pages\Page;
use App\Models\Prediction;

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

    public function getChartDataProperty(): array
    {
        // Get prediction data
        $predictions = Prediction::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get()
            ->sortBy(fn($item) => $item->year * 100 + $item->month)
            ->values();

        // Get actual production data from DatasetSistem
        $actualProductions = DatasetSistem::orderBy('tanggal', 'desc')
            ->take(12)
            ->get()
            ->sortBy(fn($item) => $item->year * 100 + $item->month)
            ->values();

        // Prepare data only for months where both prediction and actual data exist
        $labels = [];
        $predictionData = [];
        $actualData = [];

        foreach ($predictions as $prediction) {
            $actual = $actualProductions->firstWhere(function ($item) use ($prediction) {
                return $item->month == $prediction->month && $item->year == $prediction->year;
            });

            if ($actual) {
                $labels[] = $this->getShortMonthName($prediction->month) . ' ' . $prediction->year;
                $predictionData[] = $prediction->prediction;
                $actualData[] = $actual->total_hasil_produksi;
            }
        }

        return [
            'labels' => $labels,
            'prediction' => $predictionData,
            'actual' => $actualData,
        ];
    }

    private function getShortMonthName($month): string
    {
        return [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ags',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        ][$month] ?? '';
    }

    // Jika perlu mengirim data tambahan ke view
    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), [
            'chartData' => $this->chartData,
        ]);
    }
}
