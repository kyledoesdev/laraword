<?php

namespace App\Filament\Panels\Admin\Resources\DailyWords\Pages;

use App\Filament\Panels\Admin\Resources\DailyWords\DailyWordResource;
use Filament\Resources\Pages\ManageRecords;

class ManageDailyWords extends ManageRecords
{
    protected static string $resource = DailyWordResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
