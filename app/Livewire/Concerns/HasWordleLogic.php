<?php

namespace App\Livewire\Concerns;

use App\Models\Word;
use App\Enums\GameStatus;
use App\Enums\LetterState;

trait HasWordleLogic
{
    public int $wordLength = 5;

    public int $guessesAllowed = 6;

    public ?int $currentRowIndex = 0;

    public bool $isFreePlay = false;

    public function submitGuess(string $guess): array
    {
        if ($this->game->status !== GameStatus::ACTIVE->value) {
            return ['success' => false, 'error' => 'Game is complete'];
        }

        if ($this->game->current_row >= $this->guessesAllowed) {
            return ['success' => false, 'error' => 'No guesses remaining'];
        }

        $guess = strtolower($guess);

        if (strlen($guess) !== 5) {
            return ['success' => false, 'error' => 'Incomplete word'];
        }

        if ($this->hasAlreadyGuessed($guess) || !Word::isValidWord($guess)) {
            return ['success' => false, 'error' => 'Invalid word'];
        }

        $statuses = $this->checkLetters($guess);
        
        $boardState = $this->game->board_state;
        foreach ($statuses as $index => $status) {
            $boardState[$this->currentRowIndex][$index] = [
                'letter' => $guess[$index],
                'status' => $status,
            ];
        }

        $won = $guess === $this->theWord;
        $isLastGuess = $this->currentRowIndex >= $this->guessesAllowed - 1;

        if ($won) {
            $this->game->status = GameStatus::WON->value;
            $this->message = 'You Win! 🎉';
        } elseif ($isLastGuess) {
            $this->game->status = GameStatus::LOST->value;
            $this->message = "Game Over. The word was: " . strtoupper($this->theWord);
        }

        $nextRow = $won || $isLastGuess ? $this->currentRowIndex : $this->currentRowIndex + 1;

        $this->game->update([
            'board_state' => $boardState,
            'current_row' => $nextRow,
            'status' => $this->game->status,
            'attempts_used' => $this->currentRowIndex + 1,
        ]);

        $this->currentRowIndex = $nextRow;

        return [
            'success' => true,
            'statuses' => $statuses,
            'won' => $won,
            'lost' => $isLastGuess && !$won,
            'message' => $this->message,
            'nextRow' => $nextRow,
        ];
    }

    protected function hasAlreadyGuessed(string $guess): bool
    {
        return collect($this->game->board_state)
            ->contains(fn($row) => collect($row)->pluck('letter')->join('') === $guess && !empty($row[0]['status']));
    }

    protected function checkLetters(string $guess): array
    {
        $word = str_split($this->theWord);
        $guessLetters = str_split($guess);
        $statuses = array_fill(0, $this->wordLength, '');

        foreach ($guessLetters as $index => $letter) {
            if ($word[$index] === $letter) {
                $statuses[$index] = LetterState::CORRECT->value;
                $word[$index] = null;
            }
        }

        foreach ($guessLetters as $index => $letter) {
            if ($statuses[$index]) continue;
            
            $foundIndex = array_search($letter, $word);
            if ($foundIndex !== false) {
                $statuses[$index] = LetterState::PRESENT->value;
                $word[$foundIndex] = null;
            } else {
                $statuses[$index] = LetterState::ABSENT->value;
            }
        }

        return $statuses;
    }
}