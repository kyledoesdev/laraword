<?php

namespace App\Filament\Panels\Project\Pages;

use App\Filament\Fields\AvatarField;
use Filament\Auth\Pages\EditProfile;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Settings extends EditProfile
{
    protected static ?string $slug = 'settings';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        AvatarField::make('avatar'),
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getCurrentPasswordFormComponent(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}