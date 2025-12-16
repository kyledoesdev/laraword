<?php

namespace App\Filament\Panels\Project\Pages;

use Filament\Pages\Page;

class Connections extends Page
{
    protected string $view = 'filament.project.pages.connections';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
