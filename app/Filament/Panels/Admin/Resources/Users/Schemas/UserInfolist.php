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
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->schema([
                                ImageEntry::make('avatar')
                                    ->circular(),
                            ]),

                        Group::make()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('id'),
                                TextEntry::make('name'),
                                TextEntry::make('email'),
                                TextEntry::make('timezone'),
                                TextEntry::make('ip_address')
                                    ->label('Ip Address'),
                                TextEntry::make('created_at')
                                    ->label('First Joined At')
                                    ->formatStateUsing(function ($state, $record) {
                                        return Carbon::parse($record->getAttributes()['created_at'])
                                            ->inUserTimezone()
                                            ->format('m/d/Y g:i A T');
                                    }),
                                TextEntry::make('updated_at')
                                    ->label('Last Logged In At')
                                    ->formatStateUsing(function ($state, $record) {
                                        return Carbon::parse($record->getAttributes()['updated_at'])
                                            ->inUserTimezone()
                                            ->format('m/d/Y g:i A T');
                                    }),
                            ]),

                        TextEntry::make('user_packet')
                            ->label('User Packet')
                            ->markdown()
                            ->formatStateUsing(function ($state) {
                                if (! $state) {
                                    return 'No data';
                                }

                                return collect($state)
                                    ->map(fn ($value, $key) => "- **{$key}:** {$value}")
                                    ->join("\n");
                            }),
                    ]),
            ]);
    }
}
