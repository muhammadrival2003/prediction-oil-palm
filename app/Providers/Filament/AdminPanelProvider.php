<?php

namespace App\Providers\Filament;

// use Doctrine\DBAL\Schema\View;

use App\Filament\Components\PredictionChart;
use App\Filament\Pages\TahunTanam;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Filament\Notifications\DatabaseNotification;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View as ContractsViewView;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\View\View;
use Illuminate\View\View as ViewView;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Filament\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('PTPN IV Oil Palm')
            // ->brandLogo(fn (): View => view('filament.logo'))
            // ->brandLogo(asset('images/palm-svgrepo-com.svg'))
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->darkMode()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            // Custom Navigation Items
            ->navigationItems([
                NavigationItem::make('Afdeling Management')
                    ->icon('heroicon-o-map')
                    ->url(fn (): string => route('filament.admin.pages.afdeling'))
                    ->isActiveWhen(function (): bool {
                        $activeRoutes = [
                            'filament.admin.pages.afdeling',
                            'filament.admin.pages.afdeling.menu',
                            'filament.admin.pages.tahun-tanam',
                            'filament.admin.pages.menu-pekerjaan',
                            'filament.admin.pages.blok-produksi',
                            'filament.admin.resources.karyawan-lapangans.index',
                            'filament.admin.pages.hasil-produksi'
                        ];

                        $currentRoute = request()->route()?->getName();
                        return in_array($currentRoute, $activeRoutes);
                    })
                    ->sort(3),
            ])
            // ->spa()
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->databaseNotifications()
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn() => '<style>
                    .fi-sidebar {
                        background: #FFFFFF !important; /* Ganti dengan warna yang Anda inginkan */
                    }
                    .dark .fi-sidebar {
                        background: #101827 !important;
                    }
                </style>'
            )
            ->plugins([
                FilamentApexChartsPlugin::make()
            ])
            ->breadcrumbs(false)
            ;
    }
}
