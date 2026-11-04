<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\ArticleViewsChart;
use App\Filament\Widgets\CategoryViewsChart;
use App\Filament\Widgets\PendingCommentsWidget;
use App\Filament\Widgets\RecentArticlesWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\TopArticlesWidget;
use App\Filament\Widgets\TrafficByLanguageChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->brandName(config('brand.name', 'The Chronicle'))
            ->brandLogo(fn () => view('filament.components.brand-logo'))
            ->theme(asset('css/filament/admin/theme.css'))
            ->colors([
                'primary' => [
                    50 => '#fef2f3',
                    100 => '#fde6e8',
                    200 => '#fbd0d5',
                    300 => '#f7aab4',
                    400 => '#f27686',
                    500 => '#e6455a',
                    600 => '#C8102E', // The Chronicle Crimson Red
                    700 => '#a80c25',
                    800 => '#8c0d22',
                    900 => '#761021',
                    950 => '#43040e',
                ],
                'gray' => Color::Zinc,
            ])
            ->font('Inter')
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'Editorial',
                'Community',
                'Media & Marketing',
                'Settings',
            ])
            ->favicon('https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=32&q=80')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                StatsOverviewWidget::class,
                ArticleViewsChart::class,
                TopArticlesWidget::class,
                RecentArticlesWidget::class,
                PendingCommentsWidget::class,
                CategoryViewsChart::class,
                TrafficByLanguageChart::class,
            ])
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
            ]);
    }
}
