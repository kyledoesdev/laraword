<?php

namespace App\Filament\UserMenuActions;

use App\Filament\Panels\Project\Pages\Settings;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class SettingsPageAction extends Action
{
    public function setUp(): void
    {
        parent::setUp();

        $this->icon(Heroicon::Cog6Tooth)
            ->label('Settings')
            ->url(fn (): string => Settings::getUrl());
    }

    public static function getDefaultName(): ?string
    {
        return 'settings';
    }
}