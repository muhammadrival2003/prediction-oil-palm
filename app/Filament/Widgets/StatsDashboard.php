<?php

namespace App\Filament\Widgets;

use App\Models\Blok;
use App\Models\TahunTanam;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $countTahunTanam = TahunTanam::count();
        $countBlok = Blok::count();
        return [
            Stat::make('Tahun Tanam', $countTahunTanam),
            Stat::make('Tahun Tanam', $countBlok),
        ];
    }
}
