<?php

namespace App\Providers;

use App\Filament\DicebearAvatarProvider;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->configureFilament();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::prohibitDestructiveCommands(app()->isProduction());

        Model::automaticallyEagerLoadRelationships();

        Vite::useAggressivePrefetching();
    }

    private function configureFilament(): void
    {
        Panel::configureUsing(function (Panel $panel) {
            $panel->defaultAvatarProvider(DicebearAvatarProvider::class);
        });

        Select::configureUsing(function (Select $select) {
            $select->native(false);
        });
    }
}
