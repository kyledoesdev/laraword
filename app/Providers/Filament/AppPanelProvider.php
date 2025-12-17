<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Panels\Project\Pages\Settings;
use Illuminate\Session\Middleware\StartSession;
use App\Filament\UserMenuActions\ShowNameAction;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use App\Filament\UserMenuActions\SettingsPageAction;
use App\Filament\Panels\Project\Widgets\WordleWidget;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\UserMenuActions\ConnectionsPageAction;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('')
            ->login()
            ->profile(Settings::class, false)
            ->registration()
            ->emailVerification()
            ->passwordReset()
            ->colors([
                'primary' => Color::Red,
            ])
            ->maxContentWidth('full')
            ->discoverResources(in: app_path('Filament/Project/Resources'), for: 'App\Filament\Panels\Project\Resources')
            ->discoverPages(in: app_path('Filament/Project/Pages'), for: 'App\Filament\Panels\Project\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Project/Widgets'), for: 'App\Filament\Panels\Project\Widgets')
            ->widgets([
                WordleWidget::class
            ])
            ->userMenuItems([
                //'profile' => fn () => ShowNameAction::make(),
                SettingsPageAction::make(),
                ConnectionsPageAction::make(),
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
            ->renderHook(
                'panels::head.end',
                fn () => '<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>'
            )
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
