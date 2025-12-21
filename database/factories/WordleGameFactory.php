<?php

namespace Database\Factories;

use App\Enums\GameStatus;
use App\Enums\LetterState;
use App\Models\DailyWord;
use App\Models\User;
use App\Models\Word;
use App\Models\WordleGame;
use Illuminate\Database\Eloquent\Factories\Factory;

class WordleGameFactory extends Factory
{
    protected $model = WordleGame::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement([GameStatus::WON, GameStatus::LOST]);

        $attempts = $status === GameStatus::WON 
            ? $this->faker->numberBetween(1, 6)
            : 6;

        return [
            'user_id' => User::factory(),
            'daily_word_id' => DailyWord::factory(),
            'word_id' => null,
            'board_state' => $this->generateBoardState($status, $attempts),
            'current_row' => $attempts,
            'status' => $status->value,
            'attempts_used' => $attempts,
        ];
    }

    public function won(?int $attempts): static
    {
        $attempts = $attempts ?? $this->faker->numberBetween(1, 6);
        
        return $this->state(fn () => [
            'status' => GameStatus::WON->value,
            'attempts_used' => $attempts,
            'current_row' => $attempts,
            'board_state' => $this->generateBoardState(GameStatus::WON, $attempts),
        ]);
    }

    public function lost(): static
    {
        return $this->state(fn () => [
            'status' => GameStatus::LOST->value,
            'attempts_used' => 6,
            'current_row' => 6,
            'board_state' => $this->generateBoardState(GameStatus::LOST, 6),
        ]);
    }

    public function forUser(User $user): static
    {
        return $this->state(fn () => [
            'user_id' => $user->id,
        ]);
    }

    public function forDailyWord(DailyWord $dailyWord): static
    {
        return $this->state(fn () => [
            'daily_word_id' => $dailyWord->getKey(),
        ]);
    }

    public function efficient(): static
    {
        return $this->won($this->faker->numberBetween(1, 3));
    }

    public function average(): static
    {
        return $this->won($this->faker->numberBetween(3, 5));
    }

    public function struggling(): static
    {
        return $this->won($this->faker->numberBetween(5, 6));
    }

    private function generateBoardState(GameStatus $status, int $rowsFilled): array
    {
        $board = [];

        $statuses = [
            LetterState::CORRECT->value,
            LetterState::ABSENT->value,
            LetterState::PRESENT->value
        ];

        for ($row = 0; $row < 6; $row++) {
            $tiles = [];
            for ($col = 0; $col < 5; $col++) {
                if ($row < $rowsFilled) {
                    $isLastRow = $row === $rowsFilled - 1;
                    $isWon = $status === GameStatus::WON;

                    if ($isLastRow && $isWon) {
                        $tileStatus = LetterState::CORRECT->value;
                    } else {
                        $tileStatus = $this->faker->randomElement($statuses);
                    }

                    $tiles[] = [
                        'letter' => $this->faker->randomLetter(),
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
}