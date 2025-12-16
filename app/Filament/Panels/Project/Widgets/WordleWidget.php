<?php

namespace App\Filament\Panels\Project\Widgets;

use Filament\Widgets\Widget;

class WordleWidget extends Widget
{
    protected string $view = 'filament.project.widgets.wordle-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = -2;
    
    public static function canView(): bool
    {
        return true;
    }
}