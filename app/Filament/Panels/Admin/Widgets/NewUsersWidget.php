<?php

namespace App\Filament\Panels\Admin\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use App\Filament\Panels\Admin\Widgets\Concerns\HasDateFilters;

class NewUsersWidget extends ChartWidget
{
    use HasDateFilters;

    protected ?string $heading = 'New Users Widget';
    
    public ?string $filter = 'year';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $trendConfig = $this->getTrendConfig($this->filter ?? 'year');

        $newUsers = Trend::model(User::class)
            ->between(
                start: $trendConfig['start'],
                end: $trendConfig['end'],
            )
            ->{$trendConfig['period']}()
            ->count();

        $deletedUsers = Trend::query(User::onlyTrashed())
            ->between(
                start: $trendConfig['start'],
                end: $trendConfig['end'],
            )
            ->{$trendConfig['period']}()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $newUsers->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#93c5fd'
                ],
                [
                    'label' => 'Deleted Users',
                    'data' => $deletedUsers->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#f87171'
                ],
            ],
            'labels' => $trendConfig['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'day' => 'Past Day',
            'week' => 'Past Week',
            'month' => 'Past Month',
            'year' => 'Past Year',
        ];
    }
}