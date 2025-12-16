<?php

namespace App\Filament;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

class DicebearAvatarProvider implements AvatarProvider
{
    public function get(Model $record): string
    {
        return 'https://api.dicebear.com/7.x/identicon/svg?seed='.urlencode(Filament::getNameForDefaultAvatar($record));
    }
}
