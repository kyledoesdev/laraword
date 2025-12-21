<?php

namespace App\Livewire;

use App\Enums\GameStatus;
use App\Models\WordleGame;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class Leaderboard extends Component
{
    public function getStreakLeaders(): Collection
    {
        $games = WordleGame::query()
            ->whereNotNull('daily_word_id')
            ->whereIn('status', [GameStatus::WON->value, GameStatus::LOST->value])
            ->get()
            ->groupBy('user_id');

        return $games->map(function ($userGames) {
            $dates = $userGames
                ->map(fn ($game) => $game->dailyWord->date->format('Y-m-d'))
                ->unique()
                ->sort()
                ->values()
                ->toArray();

            return [
                'user' => $userGames->first()->user,
                'streak' => $this->calculateStreak($dates),
            ];
        })
        ->filter(fn ($item) => $item['streak'] > 0)
        ->sortByDesc('streak')
        ->take(10)
        ->values();
    }

    private function calculateStreak(array $dates): int
    {
        if (empty($dates)) {
            return 0;
        }

        $streak = 0;
        $today = now()->startOfDay();
        $yesterday = $today->copy()->subDay();

        $sortedDates = collect($dates)
            ->map(fn ($d) => Carbon::parse($d)->startOfDay())
            ->sortDesc()
            ->values();

        $mostRecent = $sortedDates->first();

        if (!$mostRecent->equalTo($today) && !$mostRecent->equalTo($yesterday)) {
            return 0;
        }

        $checkDate = $mostRecent;

        foreach ($sortedDates as $gameDate) {
            if ($gameDate->equalTo($checkDate)) {
                $streak++;
                $checkDate = $checkDate->copy()->subDay();
            } elseif ($gameDate->lessThan($checkDate)) {
                break;
            }
        }

        return $streak;
    }

    public function getEfficiencyLeaders(): Collection
    {
        return WordleGame::query()
            ->selectRaw('
                user_id,
                COUNT(*) as games_won,
                SUM(attempts_used) as total_attempts,
                AVG(attempts_used) as avg_attempts'
            )
            ->whereNotNull('daily_word_id')
            ->where('status', GameStatus::WON->value)
            ->groupBy('user_id')
            ->having('games_won', '>=', 1)
            ->orderBy('avg_attempts')
            ->orderByDesc('games_won')
            ->take(10)
            ->get()
            ->map(fn ($row) => [
                'user' => $row->user,
                'games_won' => $row->games_won,
                'avg_attempts' => round($row->avg_attempts, 2),
            ])
            ->filter(fn ($item) => $item['user'] !== null)
            ->values();
    }

    public function render()
    {
        return view('livewire.leaderboard', [
            'streakLeaders' => $this->getStreakLeaders(),
            'efficiencyLeaders' => $this->getEfficiencyLeaders(),
        ]);
    }
}