<?php

namespace App\Livewire;

use App\Models\DailyWord;
use App\Models\Word;
use App\Models\WordleGame as WordleGameModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class WordleGame extends Component
{
    public array $board = [];
    public int $currentRowIndex = 0;
    public string $status = 'active';
    public string $message = '';
    public int $guessesAllowed = 6;
    public int $wordLength = 5;
    public bool $alreadyPlayed = false;

    public function mount(): void
    {
        $game = WordleGameModel::getOrCreateForToday(Auth::id());
        $dailyWord = DailyWord::getToday();
        
        $this->wordLength = strlen($dailyWord->word->word);
        $this->board = $game->board_state;
        $this->currentRowIndex = $game->current_row;
        $this->status = $game->status;
        $this->alreadyPlayed = $game->isComplete();

        if ($this->status === 'won') {
            $this->message = 'You already won today! 🎉';
        } elseif ($this->status === 'lost') {
            $this->message = "You lost today. The word was: {$dailyWord->word->word}";
        }
    }

    #[Computed]
    public function theWord(): string
    {
        return strtolower(DailyWord::getToday()->word->word);
    }

    public function submitGuess(string $guess): array
    {
        $game = WordleGameModel::getOrCreateForToday(Auth::id());
        $this->currentRowIndex = $game->current_row;
        $this->status = $game->status;
        $this->board = $game->board_state;

        if ($this->status !== 'active') {
            return ['success' => false, 'error' => 'Game is complete'];
        }

        if ($this->currentRowIndex >= $this->guessesAllowed) {
            return ['success' => false, 'error' => 'No guesses remaining'];
        }

        $guess = strtolower($guess);

        if (strlen($guess) !== $this->wordLength) {
            return ['success' => false, 'error' => 'Incomplete word'];
        }

        if ($this->hasAlreadyGuessed($guess)) {
            return ['success' => false, 'error' => 'Already guessed'];
        }

        if (!Word::isValidWord($guess)) {
            return ['success' => false, 'error' => 'Invalid word'];
        }

        $statuses = $this->calculateStatuses($guess);
        
        foreach ($statuses as $index => $status) {
            $this->board[$this->currentRowIndex][$index]['letter'] = $guess[$index];
            $this->board[$this->currentRowIndex][$index]['status'] = $status;
        }

        $won = $guess === $this->theWord;
        $isLastGuess = $this->currentRowIndex >= $this->guessesAllowed - 1;

        if ($won) {
            $this->status = 'won';
            $this->message = 'You Win! 🎉';
        } elseif ($isLastGuess) {
            $this->status = 'lost';
            $this->message = "Game Over. The word was: " . strtoupper($this->theWord);
        }
        
        $nextRow = $this->currentRowIndex;
        if (!$won && !$isLastGuess) {
            $nextRow = $this->currentRowIndex + 1;
        }

        $game->update([
            'board_state' => $this->board,
            'current_row' => $nextRow,
            'status' => $this->status,
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
        foreach ($this->board as $row) {
            $rowWord = collect($row)->pluck('letter')->join('');
            if ($rowWord === $guess && !empty($row[0]['status'])) {
                return true;
            }
        }
        return false;
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