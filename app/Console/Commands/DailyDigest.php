<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\WordleGame;
use App\Stats\LoginStat;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DailyDigest extends Command
{
    protected $signature = 'daily-digest:send';

    protected $description = 'Send a discord message with Daily Stats';

    private Carbon $start;
    private Carbon $end;

    public function __construct()
    {
        parent::__construct();

        $this->start = now()->subDays(1)->startOfDay();
        $this->end = now()->subDays(1)->endOfDay();
    }

    public function handle()
    { 
        $games = $this->getTotalDailyGamesPlayed() + $this->getTotalFreePlayGamesPlayed();

        $message = "Daily Digest {$this->start->format('m/d/Y h:i:s A T')} - {$this->end->format('m/d/Y h:i:s A T')}. \n";

        $message .= "New Users: {$this->getNewUsers()}. \n";
        $message .= "Logins Today: {$this->getLogins()}. \n";
        $message .= "Total Games Played: {$games}. \n";
        $message .= "Total Daily Games Played: {$this->getTotalDailyGamesPlayed()}. \n";
        $message .= "Total Free Play Games Played: {$this->getTotalFreePlayGamesPlayed()}. \n";

        Log::channel('discord_status_updates')->info($message);

        return Command::SUCCESS;
    }

    private function getNewUsers(): int
    {
        return User::query()
            ->whereBetween('created_at', [$this->start, $this->end])
            ->count();
    }

    private function getLogins(): int
    {
        return LoginStat::query()
            ->start($this->start)
            ->end($this->end)
            ->get()
            ->sum('increments');
    }

    private function getTotalDailyGamesPlayed()
    {
        return WordleGame::query()
            ->whereNotNull('daily_word_id')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->count();
    }

    private function getTotalFreePlayGamesPlayed()
    {
        return WordleGame::query()
            ->whereNull('daily_word_id')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->count();
    }
}