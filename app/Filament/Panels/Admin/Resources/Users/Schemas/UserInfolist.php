<?php

namespace App\Filament\Panels\Admin\Resources\Users\Schemas;

use App\Models\User;
use Carbon\Carbon;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->schema([
                                ImageEntry::make('avatar_url')
                                    ->circular(),
                            ]),

                        Group::make()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('id')
                                    ->label('ID'),
                                TextEntry::make('name')
                                    ->label('Full Name'),
                                TextEntry::make('email')
                                    ->label('Email Address'),
                                TextEntry::make('timezone')
                                    ->label('Timezone'),
                                TextEntry::make('ip_address')
                                    ->label('IP Address'),
                                TextEntry::make('user_platform')
                                    ->label('User Platform'),
                                TextEntry::make('created_at')
                                    ->label('Joined At')
                                    ->formatStateUsing(function (User $record): string {
                                        return Carbon::parse($record->getAttributes()['created_at'])
                                            ->inUserTimezone()
                                            ->format('m/d/Y g:i A T');
                                    }),
                                TextEntry::make('updated_at')
                                    ->label('Last Logged In At')
                                    ->formatStateUsing(function (User $record): string {
                                        return Carbon::parse($record->getAttributes()['updated_at'])
                                            ->inUserTimezone()
                                            ->format('m/d/Y g:i A T');
                                    }),
                            ]),
                    ]),
            ]);
    }
}
