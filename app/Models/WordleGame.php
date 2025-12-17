<?php

namespace App\Models;

use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordleGame extends Model
{
    protected $fillable = [
        'user_id',
        'word_id',
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
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dailyWord(): BelongsTo
    {
        return $this->belongsTo(DailyWord::class);
    }

    public function isComplete(): bool
    {
        return in_array($this->status, [GameStatus::WON, GameStatus::LOST]);
    }

    public static function getOrCreateForToday(int $userId): self
    {
        return self::firstOrCreate([
            'user_id' => $userId,
            'word_id' => DailyWord::getToday()->getKey(),
        ], [
            'board_state' => self::createEmptyBoard(),
            'status' => GameStatus::ACTIVE->value,
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