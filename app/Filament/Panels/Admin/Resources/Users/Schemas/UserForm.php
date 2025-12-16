<?php

namespace App\Filament\Panels\Admin\Resources\Users\Schemas;

use App\Filament\Fields\AvatarField;
use App\Models\User;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Image;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        Image::make(fn (?User $record) => $record?->getAvatarUrlAttribute(), 'Avatar')
                            ->visible(fn (?User $record) => Str::isUrl($record?->avatar)),

                        AvatarField::make()
                            ->columnSpanFull(),
                            
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->rule(Password::default())
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                            ->same('password_confirmation')
                            ->visible(fn (string $context): bool => $context === 'create'),

                        TextInput::make('password_confirmation')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(false)
                            ->visible(fn (string $context): bool => $context === 'create'),
                    ])
                    ->columns(2),

                Section::make('Additional Information')
                    ->schema([
                        Select::make('timezone')
                            ->options(collect(timezone_identifiers_list())->mapWithKeys(function ($timezone) {
                                return [$timezone => $timezone];
                            }))
                            ->required()
                            ->searchable()
                            ->default('America/New_York')
                            ->placeholder('Select timezone'),

                        Checkbox::make('is_dev')
                            ->label('Developer Access')
                            ->required()
                            ->helperText('Grants access to the admin panel'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
