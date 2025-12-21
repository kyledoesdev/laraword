<?php

namespace App\Models;

use App\Models\User;
use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WordleGame extends Model
{
    protected $fillable = [
        'user_id',
        'word_id',
        'daily_word_id',
        'board_state',
        'current_row',
        'status',
        'attempts_used',
    ];

    public function casts(): array
    {
        return [
            'board_state' => 'array',
            'current_row' => 'integer',
            'attempts_used' => 'integer',
            'is_daily_game' => 'boolean'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function word(): HasOne
    {
        return $this->hasOne(Word::class, 'id', 'word_id');
    }

    public function dailyWord(): HasOne
    {
        return $this->hasOne(DailyWord::class, 'id', 'daily_word_id');
    }

    public function isComplete(): bool
    {
        return in_array($this->status, [GameStatus::WON->value, GameStatus::LOST->value]);
    }

    public static function getOrCreateForToday(User $user): self
    {
        return self::firstOrCreate([
            'user_id' => $user->getKey(),
            'daily_word_id' => DailyWord::getToday()->getKey(),
        ], [
            'board_state' => self::createEmptyBoard(),
            'status' => GameStatus::ACTIVE->value,
        ]);
    }

    public static function getOrCreateFreePlayGame(User $user): self
    {
        $activeGame = self::query()
            ->where('user_id', $user->getKey())
            ->where('status', GameStatus::ACTIVE->value)
            ->whereNull('daily_word_id')
            ->first();

        if ($activeGame) {
            return $activeGame;
        }

        return self::create([
            'user_id' => $user->getKey(),
            'word_id' => Word::inRandomOrder()->first()->getKey(),
            'status' => GameStatus::ACTIVE->value,
            'is_daily_game' => false,
            'board_state' => self::createEmptyBoard(),
        ]);
    }

    public static function createEmptyBoard(): array
    {
        return collect()
            ->times(6)
            ->map(fn() => collect()->times(5)
                ->map(fn($col) => [
                    'letter' => '',
                    'status' => '',
                    'position' => $col,
                ])
            )
            ->toArray();
    }
}