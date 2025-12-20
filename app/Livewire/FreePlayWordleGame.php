<?php

namespace App\Livewire;

use App\Enums\GameStatus;
use App\Livewire\Concerns\HasWordleLogic;
use App\Models\WordleGame;
use Livewire\Attributes\Computed;
use Livewire\Component;

class FreePlayWordleGame extends Component
{
    use HasWordleLogic;

    public ?WordleGame $game = null;

    public ?string $message = '';

    public function mount(): void
    {
        $this->game = WordleGame::getOrCreateFreePlayGame(auth()->user());

        $this->currentRowIndex = $this->game?->current_row;

        $this->isFreePlay = true;

        $this->message = match($this->game?->status) {
            GameStatus::WON->value => 'You won! 🎉 Play Again?',
            GameStatus::LOST->value => "You lost. The word was: {$this->game->word->word}. Play again?",
            default => ''
        };
    }

    #[Computed]
    public function theWord(): string
    {
        return strtolower($this->game->word->word);
    }

    public function render()
    {
        return view('livewire.wordle-game');
    }
}