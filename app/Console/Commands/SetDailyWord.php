<?php

namespace App\Console\Commands;

use App\Models\DailyWord;
use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SetDailyWord extends Command
{
    protected $signature = 'wordle:set-daily-word {--date= : The date to set (Y-m-d format)}';
    protected $description = 'Set the daily Wordle word';

    public function handle(): int
    {
        $date = $this->option('date') 
            ? Carbon::parse($this->option('date')) 
            : Carbon::today();

        $existing = DailyWord::whereDate('date', $date)->first();
        
        if ($existing) {
            $this->info("Word already set for {$date->toDateString()}: {$existing->word->word}");
            return self::SUCCESS;
        }

        $word = Word::getRandomTarget();
        
        DailyWord::create([
            'date' => $date,
            'word_id' => $word->id,
        ]);

        $this->info("Daily word set for {$date->toDateString()}: {$word->word}");
        
        return self::SUCCESS;
    }
}