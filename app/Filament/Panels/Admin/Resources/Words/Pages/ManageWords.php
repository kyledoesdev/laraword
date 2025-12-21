<?php

namespace App\Filament\Panels\Admin\Resources\Words\Pages;

use App\Filament\Panels\Admin\Resources\Words\WordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWords extends ManageRecords
{
    protected static string $resource = WordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
