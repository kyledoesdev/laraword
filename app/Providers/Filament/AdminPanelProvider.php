<?php

namespace App\Providers\Filament;

use App\Filament\Panels\Project\Pages\Settings;
use App\Filament\UserMenuActions\ConnectionsPageAction;
use App\Http\Middleware\System\IsDeveloper;
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
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile(Settings::class, false)
            ->colors([
                'primary' => Color::Purple,
            ])
            ->maxContentWidth('full')
            ->discoverResources(in: app_path('Filament/Panels/Admin/Resources'), for: 'App\Filament\Panels\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Panels/Admin/Pages'), for: 'App\Filament\Panels\Admin\Pages')
            ->discoverWidgets(in: app_path('Filament/Panels/Admin/Widgets'), for: 'App\Filament\Panels\Admin\Widgets')
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
            ->userMenuItems([
                ConnectionsPageAction::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
                IsDeveloper::class,
            ]);
    }
}
