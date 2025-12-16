<?php

namespace App\Filament\UserMenuActions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class ShowNameAction extends Action
{
    public function setUp(): void
    {
        parent::setUp();

        $this->icon(Heroicon::UserCircle)
            ->label(auth()->user()->name)
            ->url(null);
    }

    public static function getDefaultName(): ?string
    {
        return 'user_name';
    }
}