<?php

namespace App\Filament\Widgets;

use App\Models\ManyGawanganManual;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Illuminate\Support\Carbon;

class ManyGawanganManualChart extends ApexChartWidget
{
    protected static ?string $chartId = 'manyGawanganManualChart';
    protected static ?string $heading = 'Progress Gawangan Manual';
    protected static ?int $sort = 2;

    public function getColumnSpan(): int | string | array
    {
        return [
            'md' => 12,
            'xl' => 'full',
        ];
    }

    protected function getOptions(): array
    {
        // Ambil data dari database
        $months = range(1, 12); // Januari - Desember
        $rencanaData = [];
        $realisasiData = [];

        foreach ($months as $month) {
            $rencana = ManyGawanganManual::whereMonth('tanggal', $month)
                ->sum('rencana_gawangan');
            
            $realisasi = ManyGawanganManual::whereMonth('tanggal', $month)
                ->sum('realisasi_gawangan');
            
            $rencanaData[] = $rencana;
            $realisasiData[] = $realisasi;
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
                'width' => '100%',
                'toolbar' => [
                    'show' => true,
                ],
            ],
            'series' => [
                [
                    'name' => 'Rencana',
                    'data' => $rencanaData,
                ],
                [
                    'name' => 'Realisasi',
                    'data' => $realisasiData,
                ],
            ],
            'xaxis' => [
                'categories' => array_map(function ($month) {
                    return Carbon::create()->month($month)->format('M'); // Jan-Dec
                }, $months),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'title' => [
                    'text' => 'Jumlah Gawangan'
                ],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#3b82f6', '#10b981'], // Warna berbeda untuk rencana & realisasi
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'endingShape' => 'rounded',
                    'columnWidth' => '70%',
                    'dataLabels' => [
                        'position' => 'top',
                    ],
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'stroke' => [
                'show' => true,
                'width' => 2,
                'colors' => ['transparent']
            ],
            'legend' => [
                'position' => 'bottom',
                // 'horizontalAlign' => 'right',
            ],
        ];
    }
}