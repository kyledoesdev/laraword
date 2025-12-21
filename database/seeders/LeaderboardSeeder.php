<?php

namespace Database\Seeders;

use App\Enums\GameStatus;
use App\Models\DailyWord;
use App\Models\User;
use App\Models\Word;
use App\Models\WordleGame;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class LeaderboardSeeder extends Seeder
{
    private array $dailyWords = [];

    public function run(): void
    {
        $this->command->info('Creating daily words for the past 60 days...');
        $this->createDailyWords();

        $this->command->info('Creating 50 test users with game history...');
        $this->createUsersWithGames();

        $this->command->info('Leaderboard seeding complete!');
    }

    private function createDailyWords(): void
    {
        $period = CarbonPeriod::create(now()->subDays(60), now());
        $targetWords = Word::where('is_target', true)->pluck('id')->toArray();

        if (empty($targetWords)) {
            $this->command->warn('No target words found. Run WordSeeder first.');
            return;
        }

        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            
            $dailyWord = DailyWord::firstOrCreate(
                ['date' => $dateString],
                ['word_id' => $targetWords[array_rand($targetWords)]]
            );
            
            $this->dailyWords[$dateString] = $dailyWord;
        }
    }

    private function createUsersWithGames(): void
    {
        // Create different player profiles
        $this->createStreakPlayers(10);
        $this->createEfficientPlayers(10);
        $this->createCasualPlayers(15);
        $this->createNewPlayers(10);
        $this->createInconsistentPlayers(5);
    }

    private function createStreakPlayers(int $count): void
    {
        $this->command->info("  Creating {$count} streak players...");

        for ($i = 0; $i < $count; $i++) {
            $user = User::factory()->create([
                'name' => fake()->name(),
                'email' => "streak{$i}@example.com",
            ]);

            // Long current streak (5-30 days)
            $streakLength = rand(5, 30);
            $startDate = now()->subDays($streakLength - 1);

            for ($day = 0; $day < $streakLength; $day++) {
                $date = $startDate->copy()->addDays($day)->format('Y-m-d');
                
                if (!isset($this->dailyWords[$date])) continue;

                $this->createGame($user, $this->dailyWords[$date], [
                    'won' => rand(1, 100) <= 80, // 80% win rate
                    'attempts' => rand(2, 5),
                ]);
            }

            // Maybe add some older games with gaps
            if (rand(1, 100) <= 50) {
                $olderGames = rand(3, 10);
                $olderStart = now()->subDays($streakLength + rand(5, 15));

                for ($j = 0; $j < $olderGames; $j++) {
                    $date = $olderStart->copy()->subDays($j * rand(1, 3))->format('Y-m-d');
                    
                    if (!isset($this->dailyWords[$date])) continue;

                    $this->createGame($user, $this->dailyWords[$date], [
                        'won' => rand(1, 100) <= 70,
                        'attempts' => rand(3, 6),
                    ]);
                }
            }
        }
    }

    private function createEfficientPlayers(int $count): void
    {
        $this->command->info("  Creating {$count} efficient players...");

        for ($i = 0; $i < $count; $i++) {
            $user = User::factory()->create([
                'name' => fake()->name(),
                'email' => "efficient{$i}@example.com",
            ]);

            // Play 10-40 games with high efficiency
            $gamesPlayed = rand(10, 40);
            $dates = $this->getRandomDates($gamesPlayed);

            foreach ($dates as $date) {
                if (!isset($this->dailyWords[$date])) continue;

                $this->createGame($user, $this->dailyWords[$date], [
                    'won' => rand(1, 100) <= 95, // 95% win rate
                    'attempts' => $this->weightedRandom([1 => 5, 2 => 25, 3 => 40, 4 => 20, 5 => 8, 6 => 2]),
                ]);
            }
        }
    }

    private function createCasualPlayers(int $count): void
    {
        $this->command->info("  Creating {$count} casual players...");

        for ($i = 0; $i < $count; $i++) {
            $user = User::factory()->create([
                'name' => fake()->name(),
                'email' => "casual{$i}@example.com",
            ]);

            // Play 5-25 games scattered across time
            $gamesPlayed = rand(5, 25);
            $dates = $this->getRandomDates($gamesPlayed);

            foreach ($dates as $date) {
                if (!isset($this->dailyWords[$date])) continue;

                $this->createGame($user, $this->dailyWords[$date], [
                    'won' => rand(1, 100) <= 65, // 65% win rate
                    'attempts' => rand(3, 6),
                ]);
            }
        }
    }

    private function createNewPlayers(int $count): void
    {
        $this->command->info("  Creating {$count} new players...");

        for ($i = 0; $i < $count; $i++) {
            $user = User::factory()->create([
                'name' => fake()->name(),
                'email' => "newbie{$i}@example.com",
            ]);

            // Only played 1-5 games recently
            $gamesPlayed = rand(1, 5);
            
            for ($j = 0; $j < $gamesPlayed; $j++) {
                $date = now()->subDays($j)->format('Y-m-d');
                
                if (!isset($this->dailyWords[$date])) continue;

                $this->createGame($user, $this->dailyWords[$date], [
                    'won' => rand(1, 100) <= 50, // 50% win rate (learning)
                    'attempts' => rand(4, 6),
                ]);
            }
        }
    }

    private function createInconsistentPlayers(int $count): void
    {
        $this->command->info("  Creating {$count} inconsistent players...");

        for ($i = 0; $i < $count; $i++) {
            $user = User::factory()->create([
                'name' => fake()->name(),
                'email' => "sporadic{$i}@example.com",
            ]);

            // Multiple broken streaks
            $streakCount = rand(2, 4);
            $currentDate = now()->subDays(55);

            for ($streak = 0; $streak < $streakCount; $streak++) {
                $streakLength = rand(2, 7);

                for ($day = 0; $day < $streakLength; $day++) {
                    $date = $currentDate->copy()->addDays($day)->format('Y-m-d');
                    
                    if (!isset($this->dailyWords[$date])) continue;

                    $this->createGame($user, $this->dailyWords[$date], [
                        'won' => rand(1, 100) <= 60,
                        'attempts' => rand(3, 6),
                    ]);
                }

                // Gap between streaks
                $currentDate = $currentDate->addDays($streakLength + rand(3, 10));
            }
        }
    }

    private function createGame(User $user, DailyWord $dailyWord, array $options): void
    {
        $won = $options['won'] ?? true;
        $attempts = $won ? ($options['attempts'] ?? rand(1, 6)) : 6;
        $status = $won ? GameStatus::WON : GameStatus::LOST;

        // Check if game already exists for this user/daily word
        $exists = WordleGame::where('user_id', $user->id)
            ->where('daily_word_id', $dailyWord->id)
            ->exists();

        if ($exists) return;

        WordleGame::create([
            'user_id' => $user->id,
            'daily_word_id' => $dailyWord->id,
            'word_id' => null,
            'board_state' => $this->generateBoardState($attempts, $status),
            'current_row' => $attempts,
            'status' => $status->value,
            'attempts_used' => $attempts,
        ]);
    }

    private function generateBoardState(int $rowsFilled, GameStatus $status): array
    {
        $board = [];
        $statuses = ['correct', 'present', 'absent'];
        $letters = range('a', 'z');

        for ($row = 0; $row < 6; $row++) {
            $tiles = [];
            for ($col = 0; $col < 5; $col++) {
                if ($row < $rowsFilled) {
                    $isLastRow = $row === $rowsFilled - 1;
                    $isWon = $status === GameStatus::WON;

                    if ($isLastRow && $isWon) {
                        $tileStatus = 'correct';
                    } else {
                        $tileStatus = $statuses[array_rand($statuses)];
                    }

                    $tiles[] = [
                        'letter' => $letters[array_rand($letters)],
                        'status' => $tileStatus,
                        'position' => $col,
                    ];
                } else {
                    $tiles[] = [
                        'letter' => '',
                        'status' => '',
                        'position' => $col,
                    ];
                }
            }
            $board[] = $tiles;
        }

        return $board;
    }

    private function getRandomDates(int $count): array
    {
        $allDates = array_keys($this->dailyWords);
        shuffle($allDates);
        return array_slice($allDates, 0, min($count, count($allDates)));
    }

    private function weightedRandom(array $weights): int
    {
        $total = array_sum($weights);
        $random = rand(1, $total);
        $current = 0;

        foreach ($weights as $value => $weight) {
            $current += $weight;
            if ($random <= $current) {
                return $value;
            }
        }

        return array_key_first($weights);
    }
}