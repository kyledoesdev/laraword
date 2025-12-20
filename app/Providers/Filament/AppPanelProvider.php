<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Panels\Project\Pages\Settings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
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
            ->path('app')
            ->login()
            ->profile(Settings::class, false)
            ->registration()
            ->emailVerification()
            ->passwordReset()
            ->colors([
                'primary' => Color::Red,
            ])
            ->maxContentWidth('full')
            ->discoverResources(in: app_path('Filament/Panels/Project/Resources'), for: 'App\Filament\Panels\Project\Resources')
            ->discoverPages(in: app_path('Filament/Panels//Project/Pages'), for: 'App\Filament\Panels\Project\Pages')
            ->discoverWidgets(in: app_path('Filament/Panels/Project/Widgets'), for: 'App\Filament\Panels\Project\Widgets')
            ->topNavigation()
            ->navigationItems([
                NavigationItem::make('Word Bank')
                    ->url('/word-bank', shouldOpenInNewTab: false)
                    ->sort(3),
                    
                NavigationItem::make('Leaderboards')
                    ->url('/leaderboards', shouldOpenInNewTab: false)
                    ->sort(2),
            ])
            ->spa()
            ->userMenuItems([
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
