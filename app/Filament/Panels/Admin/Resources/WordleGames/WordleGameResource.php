<?php

namespace App\Filament\Panels\Admin\Resources\WordleGames;

use App\Enums\GameStatus;
use App\Filament\Panels\Admin\Resources\WordleGames\Pages\ManageWordleGames;
use App\Models\WordleGame;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WordleGameResource extends Resource
{
    protected static ?string $model = WordleGame::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedCube;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User')
                    ->icon(Heroicon::UserCircle),
                TextEntry::make('word.word')
                    ->label('Word')
                    ->placeholder('-')
                    ->icon(Heroicon::DocumentText),
                TextEntry::make('dailyWord.word')
                    ->label('Daily Word')
                    ->placeholder('-')
                    ->icon(Heroicon::Calendar),
                TextEntry::make('status')
                    ->icon(Heroicon::CheckBadge),
                TextEntry::make('attempts_used')
                    ->numeric()
                    ->icon(Heroicon::NumberedList),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->icon(Heroicon::OutlinedClock),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->icon(Heroicon::OutlinedClock),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->icon(Heroicon::OutlinedUser)
                    ->sortable(),
                TextColumn::make('word.word')
                    ->label('Word')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('dailyWord.word.word')
                    ->label('Daily Word')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'primary' => GameStatus::ACTIVE->value,
                        'success' => GameStatus::WON->value,
                        'danger' => GameStatus::LOST->value,
                    ])
                    ->icon(Heroicon::OutlinedCheckBadge)
                    ->sortable(),
                TextColumn::make('attempts_used')
                    ->label('Attempts')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon(Heroicon::OutlinedClock),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon(Heroicon::OutlinedClock),
            ])
            ->recordActions([
                ViewAction::make()->icon(Heroicon::OutlinedEye),
                DeleteAction::make()->icon(Heroicon::OutlinedTrash),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->icon(Heroicon::OutlinedTrash),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageWordleGames::route('/'),
        ];
    }
}
