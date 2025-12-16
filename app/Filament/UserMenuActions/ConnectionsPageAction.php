<?php

namespace App\Filament\UserMenuActions;

use App\Filament\Panels\Project\Pages\Connections;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class ConnectionsPageAction extends Action
{
    public function setUp(): void
    {
        parent::setUp();

        $this->icon(Heroicon::Link)
            ->label('Connections')
            ->url(fn (): string => Connections::getUrl())
            ->visible(fn () => empty(config('services')));
    }

    public static function getDefaultName(): ?string
    {
        return 'connections';
    }
}