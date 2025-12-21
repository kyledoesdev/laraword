<?php

namespace App\Filament\Panels\Admin\Resources\WordleGames\Pages;

use App\Filament\Panels\Admin\Resources\WordleGames\WordleGameResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWordleGames extends ManageRecords
{
    protected static string $resource = WordleGameResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
