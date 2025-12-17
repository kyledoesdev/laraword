<?php

namespace App\Livewire;

use App\Enums\GameStatus;
use App\Models\DailyWord;
use App\Models\Word;
use App\Models\WordleGame as WordleGameModel;
use Livewire\Attributes\Computed;
use Livewire\Component;

class WordleGame extends Component
{
    public ?WordleGameModel $game = null;

    public int $wordLength = 5;

    public int $guessesAllowed = 6;

    public ?string $message = '';

    public ?int $currentRowIndex = 0;

    public bool $alreadyPlayed = false;

    public function mount(): void
    {
        $dailyWord = DailyWord::getToday();

        $this->game = WordleGameModel::getOrCreateForToday(auth()->id());

        $this->currentRowIndex = $this->game?->current_row;
        $this->alreadyPlayed = $this->game?->isComplete();

        $this->message = match($this->game?->status) {
            GameStatus::WON->value => 'You already won today! 🎉',
            GameStatus::LOST->value => "You lost today. The word was: {$dailyWord->word->word}",
            default => ''
        };
    }

    #[Computed]
    public function theWord(): string
    {
        return strtolower(DailyWord::getToday()->word->word);
    }

    public function submitGuess(string $guess): array
    {
        if ($this->game->status !== 'active') {
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

        $statuses = $this->calculateStatuses($guess);
        
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

    protected function calculateStatuses(string $guess): array
    {
        $word = str_split($this->theWord);
        $guessLetters = str_split($guess);
        $statuses = array_fill(0, $this->wordLength, '');

        foreach ($guessLetters as $index => $letter) {
            if ($word[$index] === $letter) {
                $statuses[$index] = 'correct';
                $word[$index] = null;
            }
        }

        foreach ($guessLetters as $index => $letter) {
            if ($statuses[$index]) continue;
            
            $foundIndex = array_search($letter, $word);
            if ($foundIndex !== false) {
                $statuses[$index] = 'present';
                $word[$foundIndex] = null;
            } else {
                $statuses[$index] = 'absent';
            }
        }

        return $statuses;
    }

    public function render()
    {
        return view('livewire.wordle-game');
    }
}