<?php

namespace App\Livewire;

use App\Models\Word;
use Livewire\Component;

class WordBank extends Component
{
    public string $search = '';

    public string $letter = '';

    public function render()
    {
        $query = Word::query()->orderBy('word');

        if ($this->search !== '') {
            $query->where('word', 'like', '%' . strtoupper($this->search) . '%');
        }

        if ($this->letter !== '') {
            $query->where('word', 'like', strtoupper($this->letter) . '%');
        }

        return view('livewire.word-bank', [
            'words' => $query->paginate(48)
        ]);
    }
}
