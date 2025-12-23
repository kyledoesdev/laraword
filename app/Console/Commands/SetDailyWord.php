<?php

namespace App\Console\Commands;

use App\Models\DailyWord;
use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SetDailyWord extends Command
{
    protected $signature = 'wordle:set-daily-word';
    protected $description = 'Set daily Wordle words for the next 30 days';

    public function handle(): int
    {
        $startDate = Carbon::today();

        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i);

            if (DailyWord::whereDate('date', $date)->exists()) {
                continue;
            }

            $word = Word::where('is_target', true)->inRandomOrder()->first();

            if (!$word) {
                Log::warning('All words used for daily games, resetting pool.');
                Word::query()->update(['is_target' => true]);
                $word = Word::where('is_target', true)->inRandomOrder()->first();
            }

            DailyWord::create([
                'date' => $date,
                'word_id' => $word->getKey(),
            ]);

            $word->update(['is_target' => false]);

            $this->info("{$date->toDateString()}: {$word->word}");
        }

        $this->info('Done!');

        return self::SUCCESS;
    }
}