<?php

namespace App\Filament\Panels\Project\Pages;

use Filament\Pages\Page;

class FreePlay extends Page
{
    protected string $view = 'filament.panels.project.pages.free-play';

    public ?string $heading = '';

    protected static ?string $navigationLabel = 'Free Play';
}
