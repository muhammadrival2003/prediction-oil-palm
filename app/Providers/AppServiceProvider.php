<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Container\Attributes\Config;
use Illuminate\Support\Facades\URL;
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
    public function boot(\Illuminate\Http\Request $request): void
    {
        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'emerald' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
            'emerald' => Color::Emerald,
        ]);

        if (!empty( env('NGROK_URL') ) && $request->server->has('HTTP_X_ORIGINAL_HOST')) {
            $this->app['url']->forceRootUrl(env('NGROK_URL'));
        }
        config([
            'excel.exports.sheets.orientation' => 'landscape',
        ]);

        if (env('APP_ENV') !== 'production') {
            URL::forceRootUrl(env('APP_URL'));
        }

        // // Fix untuk query JSON di PostgreSQL
        // DatabaseNotification::addGlobalScope('postgres-fix', function ($builder) {
        //     if (config('database.default') === 'pgsql') {
        //         $builder->whereRaw("data::jsonb->>'format' = 'filament'");
        //     }
        // });
    }
}
