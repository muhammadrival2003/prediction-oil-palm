<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\DatabaseNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);

        // // Fix untuk query JSON di PostgreSQL
        // DatabaseNotification::addGlobalScope('postgres-fix', function ($builder) {
        //     if (config('database.default') === 'pgsql') {
        //         $builder->whereRaw("data::jsonb->>'format' = 'filament'");
        //     }
        // });
    }
}
