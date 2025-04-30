<?php

namespace App\Filament\Widgets;

use App\Models\Blok;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsDashboard extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $countBlok = Blok::count();
        $totalPokok = Blok::sum('jumlah_pokok');
        $luasLahan = Blok::sum('luas_lahan');

        return [
            Stat::make('Total Blok', Number::format($countBlok))
                ->description('Jumlah blok keseluruhan')
                ->descriptionIcon('heroicon-o-map-pin', 'before')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->extraAttributes([
                    'class' => 'animate-fade-in hover:scale-[1.02] transition-transform',
                    'style' => 'animation-delay: 0.1s',
                ])
                ->icon('heroicon-o-view-columns')
                ->chartColor('primary'),

            Stat::make('Luas Lahan', Number::format($luasLahan, 2).' Ha')
                ->description('Total lahan produktif')
                ->descriptionIcon('heroicon-o-globe-alt', 'before')
                ->color('success')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->extraAttributes([
                    'class' => 'animate-fade-in hover:scale-[1.02] transition-transform',
                    'style' => 'animation-delay: 0.3s',
                ])
                ->icon('heroicon-o-square-3-stack-3d')
                ->chartColor('success'),

            Stat::make('Total Tanaman', Number::format($totalPokok).' Pokok')
                ->description('Jumlah tanaman')
                ->descriptionIcon('heroicon-o-sparkles', 'before')
                ->color('warning')
                ->chart([10, 3, 8, 5, 7, 4, 6])
                ->extraAttributes([
                    'class' => 'animate-fade-in hover:scale-[1.02] transition-transform',
                    'style' => 'animation-delay: 0.5s',
                ])
                // ->icon('heroicon-o-leaf')
                ->chartColor('warning'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}