<?php

namespace App\Livewire;

use App\Enums\GameStatus;
use App\Livewire\Concerns\HasWordleLogic;
use App\Models\DailyWord;
use App\Models\WordleGame;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DailyWordleGame extends Component
{
    use HasWordleLogic;

    public ?WordleGame $game = null;

    public string $message = '';

    public bool $alreadyPlayed = false;

    public function mount(): void
    {
        $this->game = WordleGame::getOrCreateForToday(auth()->user());

        $this->currentRowIndex = $this->game?->current_row;
        $this->alreadyPlayed = $this->game?->isComplete();

        $this->message = match($this->game?->status) {
            GameStatus::WON->value => 'You already won today! 🎉',
            GameStatus::LOST->value => "You lost today. The word was: {$this->game->dailyWord->word}",
            default => ''
        };
    }

    #[Computed]
    public function theWord(): string
    {
        return strtolower(DailyWord::getToday()->word->word);
    }

    public function render()
    {
        return view('livewire.wordle-game');
    }
}