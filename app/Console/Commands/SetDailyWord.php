<?php

namespace App\Console\Commands;

use App\Models\DailyWord;
use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SetDailyWord extends Command
{
    protected $signature = 'wordle:set-daily-word {--date= : The date to set (Y-m-d format)}';
    protected $description = 'Set the daily Wordle word';

    public function handle(): int
    {
        $date = $this->resolveDate();

        if ($existing = $this->dailyWordForDate($date)) {
            $this->info(
                "Word already set for {$date->toDateString()}: {$existing->word->word}"
            );

            return self::SUCCESS;
        }

        $word = $this->resolveDailyWord();

        DailyWord::create([
            'date'    => $date,
            'word_id' => $word->getKey(),
        ]);

        $this->info(
            "Daily word set for {$date->toDateString()}: {$word->word}"
        );

        return self::SUCCESS;
    }

    private function resolveDate(): Carbon
    {
        return $this->option('date')
            ? Carbon::parse($this->option('date'))
            : Carbon::today();
    }

    private function dailyWordForDate(Carbon $date): ?DailyWord
    {
        return DailyWord::whereDate('date', $date)->first();
    }

    private function resolveDailyWord(): Word
    {
        $word = Word::getRandomTarget();

        if (! $word) {
            Log::warning('All words have had a daily game, resetting all words.');

            Word::query()->update(['is_target' => true]);

            $word = Word::getRandomTarget();
        }

        $word->update(['is_target' => false]);

        return $word;
    }
}
