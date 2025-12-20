<?php

namespace App\Filament\Panels\Project\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Dashboard extends Page
{
    public string $view = 'filament.panels.project.pages.dashboard';

    public ?string $heading = '';

    protected static ?string $navigationLabel = 'Daily Game';
}
